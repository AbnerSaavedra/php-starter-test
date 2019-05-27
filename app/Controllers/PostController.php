<?php 

namespace App\Controllers;
use App\Models\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;


class PostController extends BaseController{

	public function getIndex(){
		return $this->renderHTML('posts/index.twig', ['posts' => $_SESSION['posts']]);
	}

	public function addPost($request){
		
		$postData = $request->getParsedBody();
		$method = 'POST';
		$url = 'https://api.dev.graphs.social/v4/graphs';
		$access_token = $_SESSION['access_token'];
		$entity = "post";
		$container_id = "5c6f101e3039354937fc1279";
		$title = $postData['title'];
		$description = $postData['description'];
		$data = array(
			    'access_token' => $access_token,
			    'entity' => $entity,
			    'container_id' => $container_id,
			    'title' => $title,
			    'description' => $description
			);
		$serverRequest = new ServerRequest();
		$callAPI = $serverRequest->callAPI($method, $url, $data);
		return new RedirectResponse('posts');
	}
}