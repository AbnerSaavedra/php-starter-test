<?php 

namespace App\Controllers;

use App\Models\ServerRequest;
use Respect\Validation\Validator;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController{
	
	public function getLogin($request){
	$responseMessage = null;
		if ($request->getMethod() == 'POST') {
			
			$postData = $request->getParsedBody();

			$method = 'GET';
			$url = 'https://auth.dev.graphs.social/v4/login';
			$data = array(
			    'email' => $postData['email'],
			    'password' => $postData['password'],
			    'application_id' => $postData['appId']
			);
			$serverRequest = new ServerRequest();
			$callAPI = $serverRequest->callAPI($method, $url, $data);

			if (isset($callAPI->access_token) and !empty($callAPI->access_token)) {
			
			$method = 'GET';
			$url = 'https://api.dev.graphs.social/v4/graphs';
			$access_token = $callAPI->access_token;
			$data = array( 'access_token' => $access_token );	

			$responsePosts = $serverRequest->callAPI($method, $url, $data);
			$_SESSION['posts'] = $responsePosts;
			return new RedirectResponse('posts');
			}elseif (isset($callAPI->errorCode) and !empty($callAPI->errorCode)){

				$responseMessage = "Error: $callAPI->errorCode, $callAPI->errorMessage";
				return $this->renderHTML('login.twig', [
				'responseMessage' => $responseMessage
			]);

			}else{

				//En respuesta se rederiza, se entrega.
				return $this->renderHTML('login.twig', [
				'responseMessage' => $callAPI->text
			]);
			}
	}
}

	public function getLogout(){

		unset($_SESSION['userId']);
		return new RedirectResponse('login');

	}
}