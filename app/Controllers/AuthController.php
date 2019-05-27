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
			$application_id = '5b51eb29303935456453d09a';
			$data = array(
			    'email' => $postData['email'],
			    'password' => $postData['password'],
			    'application_id' => $application_id
			);
			$serverRequest = new ServerRequest();
			$callAPI = $serverRequest->callAPI($method, $url, $data);
			if (isset($callAPI->access_token) and !empty($callAPI->access_token)) {
			
			$method = 'GET';
			$url = 'https://api.dev.graphs.social/v4/graphs';
			$containers_ids = "5c6f101e3039354937fc1279";
			$entities_ids = "14,23,48,49,50,51";
			$limit = "30";
			$access_token = $callAPI->access_token;
			$_SESSION['access_token'] = $access_token;
			$data = array( 'containers_ids' => $containers_ids, 'entities_ids' => $entities_ids, 'limit' => $limit);	
			$response = $serverRequest->callAPI($method, $url, $data);
			 $responsePosts = json_decode(json_encode($response), true);
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

		$method = 'GET';
		$url = 'https://auth.dev.graphs.social/v4/login/logout';
		$data = array( 'access_token' => $_SESSION['access_token']);
		$serverRequest = new ServerRequest();
		$callAPI = $serverRequest->callAPI($method, $url, $data);
		unset($_SESSION['access_token']);
		return new RedirectResponse('/php-starter-test');

	}
}