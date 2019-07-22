<?php

namespace Controller;
use Models\User;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {

   public function getLogin()
   {

        return $this->renderHTML('login.twig');

   }

   public function postLogin($request)
   {
   	  $responseMessage = "";
      $postData = $request->getParsedBody();
      $user = User::where('email', $postData['email'])->first();

         if($user){
      	   if(password_verify($postData['password'], $user->password)) {

      	   	$_SESSION['userId']= $user->id;

      		return new RedirectResponse('/app/admin');
      	  } else{
      	  	  $responseMessage= 'Bad credentials';
      	  }
      	   
        }  else  {
      	$responseMessage = 'Bad credentials';
        }
        return $this->renderHTML('login.twig', [ 'responseMessage' => $responseMessage]);

   }

   public function getLogout()
   {

      	    unset($_SESSION['userId']);
            $responseMessage = 'Debe autenticarse para acceder a esa pagina';
      		return new RedirectResponse('/app/login');
   }



}