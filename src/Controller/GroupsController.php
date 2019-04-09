<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Library\BaseController;
use App\Entity\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use App\Library\MessageConst;
use App\Repository\GroupsRepository;
use App\Form\GroupsType;

/**
 * Groups Controller Actions.
 *
 */

class GroupsController extends BaseController
{
    
    /**
     * Group listing, add/edit action
     *
     * @param Request $request A request object
     * @return Response object.
     */
    public function index(Request $request, GroupsRepository $groupObj): Response
    {
        $errorMessages = $this->get('session')->getFlashBag()->get('errorMessages');
        $successMessages = $this->get('session')->getFlashBag()->get('successMessages');
        
        if($request->attributes->has('groupId'))
        {
            $groupId = $request->attributes->get('groupId');
            $itemObj = $groupObj->getItemById($groupId);
            
            if($request->isMethod(Request::METHOD_POST))
            {
                $originalObj = new ArrayCollection();

                // Create an ArrayCollection of the current Tag objects in the database
                foreach ($itemObj->getUsers() as $user) {
                    $originalObj->add($user);
                }
            }
            
            $formBlockTitle = 'Edit Group: '.$itemObj->getName();
            
        } else{
            $itemObj = new Groups();
            $formBlockTitle = 'Create A Group';
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(GroupsType::class, $itemObj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Set other parameters
            if(!empty($groupId)){
                $itemObj->setUpdatedOn(new \DateTime());
                $itemObj->setUpdatedById($this->getUser()->getId());
                
                foreach ($originalObj as $oUser) {
                    if (false === $itemObj->getUsers()->contains($oUser)) {
                        // remove the Task from the Tag
                        $oUser->removeGroup($itemObj);
                        
                        $em->persist($oUser);
                    }
                }
                
                // Add/Remove userss
                $form->get('users')->getData()->map(
                    function ($user) use ($em, $itemObj) {
                        // Add User if not presents
                        if(!$user->hasGroup($itemObj))
                        {
                            $user->addGroup($itemObj);
                            $em->persist($user);
                        }
                    }
                );
            } else{
                $itemObj->setCreatedOn(new \DateTime());
                $itemObj->setCreatedById($this->getUser()->getId());
                
                // Add any users selected
                $form->get('users')->getData()->map(
                    function ($users) use ($em, $itemObj) {
                        $users->addGroup($itemObj);
                        $em->persist($users);
                    }
                );
            }
            
            $em->persist($itemObj);
            $em->flush();

            $this->addFlash('successMessages', MessageConst::VAL000009);
            return $this->redirectToRoute('app_manage_groups');
        } else{
            if(count($form->getErrors()) > 0)
            {
                foreach($form->getErrors() as $e)
                {
                    $errorMessages[] = $e->getMessage();
                }
            }
        }
        
        // Fetch Groups
        $groups = $groupObj->getItems( ['isDeleted' => 0] );
        
        return $this->render('groups/list.html.php', [
            'errorMessages' => $errorMessages,
            'successMessages' => $successMessages,
            'groups' => $groups,
            'form' => $form->createView(),
            'formBlockTitle' => $formBlockTitle
        ]);
    }
    
    /**
     * Unlink/Delete a group
     *
     * @param Request $request A request object
     * @param $groupObj Groups Entity Repository
     * @return Response object.
     */
    
    public function unlink(Request $request, $groupId, GroupsRepository $groupObj): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        # Get group details
        $groupInfo = $groupObj->findOneById($groupId);
        if(!$groupInfo)
        {
            return $this->forward('App\Controller\ErrorController::systemError', ['message' => MessageConst::VAL000012]);
        }
        
        if($groupInfo->getIsDeleted() != 0)
        {
            return $this->forward('App\Controller\ErrorController::systemError', ['message' => MessageConst::VAL000015]);
        }
        
        $groupName = $groupInfo->getName();
       
        if(count($groupInfo->getUsers()) >= 1)
        {
            $this->addFlash('errorMessages', sprintf(MessageConst::VAL000013, $groupName));
            return $this->redirectToRoute('app_manage_groups');
        }
        
        // Delete the Group
        $em = $this->getDoctrine()->getManager();
        $groupInfo->setIsDeleted(1);
        $em->persist($groupInfo);
        $em->flush();
        
        // Set success message and redirect
       $this->addFlash('successMessages', sprintf(MessageConst::VAL000014, $groupName));
        return $this->redirectToRoute('app_manage_groups');
    }
}