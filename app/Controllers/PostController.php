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
		$this->recargarTabla();
		return new RedirectResponse('posts');
	}

	public function updatePost($request){
		
		if ($request->getMethod() === "GET") {
			
			echo "Update post";
		}else{

		$postData = $request->getParsedBody();
		$method = 'PUT';
		$id = $postData['idPost'];
		$url = 'https://api.dev.graphs.social/v4/graphs/'.$id.'?';
		$title = $postData['titlePost'];
		$description = $postData['descriptionPost'];
		$access_token = $_SESSION['access_token'];
		$data = array(
			    'access_token' => $access_token,
			    'title' => $title,
			    'description' => $description
			);
		$serverRequest = new ServerRequest();
		$callAPI = $serverRequest->callAPI($method, $url, $data);
		$this->recargarTabla();
		return new RedirectResponse('posts');
		}
		
	}

	public function deletePost($request){

		if ($request->getMethod() === "GET") {
			
			echo "delete post";
		}else{
		
		$postData = $request->getParsedBody();
		$method = 'DELETE';
		$idPost = $postData['idPostDel'];
		$url = 'https://api.dev.graphs.social/v4/graphs/'.$idPost.'?';
		$access_token = $_SESSION['access_token'];
		$data = array(
			    'access_token' => $access_token
			);
		$serverRequest = new ServerRequest();
		$callAPI = $serverRequest->callAPI($method, $url, $data);
		$this->recargarTabla();
		return new RedirectResponse('posts');
	  }
	}

	public function recargarTabla(){

			$serverRequest = new ServerRequest();
			$method = 'GET';
			$url = 'https://api.dev.graphs.social/v4/graphs';
			$containers_ids = "5c6f101e3039354937fc1279";
			$entities_ids = "14,23,48,49,50,51";
			$limit = "30";
			$data = array( 'containers_ids' => $containers_ids, 'entities_ids' => $entities_ids, 'limit' => $limit);	
			$response = $serverRequest->callAPI($method, $url, $data);
			$responsePosts = json_decode(json_encode($response), true);
			$_SESSION['posts'] = $responsePosts;
	}
}