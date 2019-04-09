<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Library\BaseController;

/**
 * Error Controller Actions.
 *
 */

class ErrorController extends BaseController
{
    /**
     * 404 - Not found
     *
     * @return Response object.
     */
    public function notFound(): Response
    {
        return $this->render('error/404.html.php');
    }
    
    /**
     * System Error
     *
     * @param Request $request A request object
     * @return Response object.
     */
    public function systemError(Request $request): Response
    {
        $message = $request->get('message');
        return $this->render('error/systemError.html.php', ['message' => $message]);
    }
    
}