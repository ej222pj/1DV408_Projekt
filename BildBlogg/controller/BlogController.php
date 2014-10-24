<?php

namespace controller;

require_once("./model/BlogModel.php");
require_once("./model/LoginModel.php");
require_once("./model/RegisterModel.php");

require_once("./view/BlogView.php");
require_once("./view/LoginView.php");
require_once("./view/RegisterView.php");
require_once("./view/EditProfileView.php");

require_once("./controller/LoginController.php");
require_once("./controller/RegisterController.php");
require_once("./controller/BlogPostsController.php");
require_once("./controller/EditController.php");


class BlogController{
	private $blogView;
	private $loginView;
	private $registerView;
	private $editProfileView;
	
	private $blogModel;
	private $loginModel;
	private $registerModel;
	
	private $loginController;
	private $registerController;
	private $blogPostsController;
	
	private $loginSucess = "LoginSucess";

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->loginModel = new \model\LoginModel();
		$this->registerModel = new \model\RegisterModel();
		
		$this->loginController = new \controller\LoginController();
		$this->registerController = new \controller\RegisterController();
		$this->blogPostsController = new \controller\BlogPostsController();
		$this->editController = new \controller\EditController();
		
		$this->blogView = new \view\BlogView($this->blogModel);
		$this->loginView = new \view\LoginView($this->loginModel);
		$this->registerView = new \view\RegisterView($this->registerModel);
		$this->editProfileView = new \view\EditProfileView();
	}
	
	public function BlogControl(){
		$Message = "";
		//Om man inte är inloggad eller trycker på logga in
		if($this->loginView->didUserPressLogin() || $this->loginModel->loginstatus() == false){
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
			$ret = $this->editProfileView->HTMLPage($Message);
			return $ret;
		}
		//Om man trycker på spara profiländring
		elseif($this->editProfileView->didUserPressSave()){
			$ret = "";
			if($this->editProfileView->checkChangePasswordInput()){
				$ret = $this->editController->doEditProfile();
			}
			else{
				$ret = $this->editProfileView->HTMLPage($Message);
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