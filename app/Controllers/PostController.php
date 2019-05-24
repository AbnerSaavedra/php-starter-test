<?php 

namespace App\Controllers;

class PostController extends BaseController{

	public function getIndex(){
		// var_dump($_SESSION['posts']);
		return $this->renderHTML('posts/index.twig', ['posts' => $_SESSION['posts']]);
	}
}