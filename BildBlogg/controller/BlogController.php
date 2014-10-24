<?php

namespace controller;

require_once("./view/BlogView.php");

require_once("./controller/LoginController.php");
require_once("./controller/RegisterController.php");
require_once("./controller/BlogPostsController.php");
require_once("./controller/EditController.php");


class BlogController{
	private $blogView;
	
	private $loginController;
	private $registerController;
	private $blogPostsController;
	
	private $loginSucess = "LoginSucess";

	public function __construct() {		
		$this->loginController = new \controller\LoginController();
		$this->registerController = new \controller\RegisterController();
		$this->blogPostsController = new \controller\BlogPostsController();
		$this->editController = new \controller\EditController();
		
		$this->blogView = new \view\BlogView();
	}
	
	public function BlogControl(){
		$Message = "";
		//Om man inte är inloggad eller trycker på logga in
		if($this->loginController->pressedLogin() || $this->blogPostsController->loginStatus() == false){
			$ret = $this->loginController->doLogin();
			if(!isset($_SESSION[$this->loginSucess])){
				$ret .= $this->registerController->doRegister();
			}
			return $ret;
		}
		//Om man trycker på logga ut
		elseif($this->blogView->didUserPressLogout()){
			$ret = $this->loginController->doLogin();
			$ret .= $this->registerController->doRegister();
			return $ret;
		}
		//Om man trycker på redigera profil
		elseif($this->blogView->didUserEditProfile()){
			$ret = $this->editController->htmlPage($Message);
			return $ret;
		}
		//Om man trycker på spara profiländring
		elseif($this->editController->editProfile()){
			$ret = "";
			if($this->editController->changePasswordInput()){
				$ret = $this->editController->doEditProfile();
			}
			else{
				$ret = $this->editController->htmlPage($Message);
			}			
			return $ret;
		}
		//Om man trycker på Upload
		elseif($this->blogView->didUserpressUpload()){
			$ret = $this->blogPostsController->doUpload();
			return $ret;
		}
		//Om man trycker på Tabort post
		elseif($this->blogView->didUserPressRemovePost()){
			$ret = $this->blogPostsController->doRemovePost();
			return $ret;
		}
		//Om man trycker på kommentera
		elseif($this->blogView->didUserPressComment()){
			$ret = $this->blogPostsController->doComment();
			return $ret;
		}
		//Om man trycker på ta bort kommentar
		elseif($this->blogView->didUserPressRemoveComment()){
			$ret = $this->blogPostsController->doRemoveComment();
			return $ret;
		}
		 else{
			 return $this->blogView->HTMLPage($Message);
		}
	}
}