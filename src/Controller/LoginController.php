<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Library\BaseController;
use App\Library\MessageConst;
use App\Validators\LoginValidator;
use App\Library\Utils\SecurityUtil;
use App\Repository\UsersRepository;

/**
 * Login Controller Actions.
 *
 */

class LoginController extends BaseController
{
    /**
     * Login Users
     *
     * @param Request $request A request object
     * @param $userObj Users Entity Repository
     * @return Response object.
     */
    public function index(Request $request, UsersRepository $userObj): Response
    {
        
        $errorMessages = [];
        
        if($request->isMethod(Request::METHOD_POST))
        {
            $validators = new LoginValidator();
            $loginPost = $request->get('login');
            $validators->setFormValidator($loginPost);
            if (!$validators->isValid())
            {
                $errorMessages = $validators->getPageErrors();
                 return $this->render('login/index.html.php', [ 'errorMessages' => $errorMessages ]);
            }
            
            // Check for credentials
            $user = $userObj->getItemByEmail($loginPost['email']);
            if(!$user)
            {
                 return $this->render('login/index.html.php', [ 'errorMessages' => [MessageConst::VAL000004] ]);
            }

            // Check for user role and validate password
            if($user->getPassword() != SecurityUtil::getEncocedPassword($loginPost['password']))
            {
                return $this->render('login/index.html.php', [ 'errorMessages' => [MessageConst::VAL000005] ]);
            }
            if($user->getRole()->getSlug() == 'ROLE_GROUP_USER')
            {
                return $this->render('login/index.html.php', [ 'errorMessages' => [MessageConst::VAL000006] ]);
            }

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('app_manage_users');
        }
        
        return $this->render('login/index.html.php', [
            'errorMessages' => $errorMessages
        ]);
    }
    
    /**
     * Login Users
     *
     * @return Response object.
     */
    public function logout(): Response 
    {
        // Logout User
        $this->get('security.token_storage')->setToken($token);
        $this->get('request')->getSession()->invalidate();
        
         return $this->redirectToRoute('homepage');
    }
    
    
}