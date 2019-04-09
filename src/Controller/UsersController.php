<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Library\BaseController;
use App\Validators\UserValidator;
use App\Library\MessageConst;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Repository\RolesRepository;

/**
 * Users Controller Actions.
 *
 */

class UsersController extends BaseController
{

    /**
     * Users list
     *
     * @param Request $request A request object
     * @param $userObj Users Entity Repository
     * @return Response object.
     */
    public function index(Request $request, UsersRepository $userObj): Response
    {
        $errorMessages = $this->get('session')->getFlashBag()->get('errorMessages');
        $successMessages = $this->get('session')->getFlashBag()->get('successMessages');
        
        // Fetch Users
        $groupUsers = $userObj->getItems(['roleSlug' => 'ROLE_GROUP_USER']);
        
        return $this->render('users/list.html.php', [
            'errorMessages' => $errorMessages,
            'successMessages' => $successMessages,
            'groupUsers' => $groupUsers
        ]);
    }
    
    /**
     * Add Users
     *
     * @param Request $request A request object
     * @param $userObj Users Entity Repository
     * @param $roleObj Roles Entity Repository
     * @return Response object.
     */
    public function saveItem(Request $request, UsersRepository $userObj, RolesRepository $roleObj): Response
    {
        if(!$request->isMethod(Request::METHOD_POST))
        {
             return $this->redirectToRoute('app_manage_users');
        }
        
        $validators = new UserValidator();
        $registerPost = $request->get('register');
        $validators->setFormValidator($registerPost);

        if (!$validators->isValid())
        {
            $errorMessages = $validators->getPageErrors();
            $this->addFlash('errorMessages', $errorMessages);
            return $this->redirectToRoute('app_manage_users');
        }
        
        # Check if email already exists
        $userExists = $userObj->getItemByEmail($registerPost['email']);
        if($userExists !== false)
        {
            $this->addFlash('errorMessages', sprintf(MessageConst::VAL000016, $registerPost['email']));
            return $this->redirectToRoute('app_manage_users');
        }
        
        $em = $this->getDoctrine()->getManager();
        $groupRole = $roleObj->findOneBySlug('ROLE_GROUP_USER');

        // Insert the User
        $user = new Users();
        $user->setName($registerPost['name']);
        $user->setEmail($registerPost['email']);
        $user->setRole($groupRole);
        $user->setCreatedById($this->getUser()->getId());
        $user->setCreatedOn(new \DateTime());
        $em->persist($user);
        $em->flush();
        $this->addFlash('successMessages', MessageConst::VAL000008);
        return $this->redirectToRoute('app_manage_users');
    }
}