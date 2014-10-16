<?php

namespace controller;

require_once("./model/BlogModel.php");
require_once("./model/LoginModel.php");
require_once("./model/RegisterModel.php");

require_once("./view/BlogView.php");
require_once("./view/LoginView.php");
require_once("./view/RegisterView.php");

require_once("./controller/LoginController.php");
require_once("./controller/RegisterController.php");
require_once("./controller/BlogPostsController.php");


class BlogController{
	private $blogView;
	private $loginView;
	Private $registerView;
	
	private $blogModel;
	private $loginModel;
	private $registerModel;
	
	private $loginController;
	private $registerController;
	private $blogPostsController;

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->loginModel = new \model\LoginModel();
		$this->registerModel = new \model\RegisterModel();
		
		$this->loginController = new \controller\LoginController();
		$this->registerController = new \controller\RegisterController();
		$this->blogPostsController = new \controller\BlogPostsController();
		
		$this->blogView = new \view\BlogView($this->blogModel);
		$this->loginView = new \view\LoginView($this->loginModel);
		$this->registerView = new \view\RegisterView($this->registerModel);
	}
	
	public function BlogControl(){
		$Message = "";
		//$_SESSION['UserWantsToLogin'] = false;
		if($this->loginView->didUserPressLogin()){
			$ret = $this->loginController->doLogin();
			if(!isset($_SESSION['LoginSucess'])){
				$ret .= $this->registerController->doRegister();
			}
			return $ret;
		}
		elseif($this->registerView->didUserPressRegisterNew()){
			$ret = $this->loginView->HTMLPage($Message);
			$ret .= $this->registerController->doRegister();
			return $ret;
		}
		elseif($this->loginView->didUserPressLogout()){
			$ret = $this->loginController->doLogin();
			$ret .= $this->registerController->doRegister();
			return $ret;
		}
		elseif($this->loginModel->loginstatus() == false){
			$ret = $this->loginView->HTMLPage($Message);
			$ret .= $this->registerView->HTMLPage($Message);
			return $ret;
		}
		elseif($this->blogView->didUserpressUpload()){
			$ret = $this->blogPostsController->doUpload();
			return $ret;
		}
		elseif($this->blogView->didUserPressRemovePost()){
			$ret = $this->blogPostsController->doRemovePost();
			return $ret;
		}
		elseif($this->blogView->didUserPressComment()){
			$ret = $this->blogPostsController->doComment();
			return $ret;
		}
		elseif($this->blogView->didUserPressRemoveComment()){
			$ret = $this->blogPostsController->doRemoveComment();
			return $ret;
		}
		else{
			return $this->blogView->HTMLPage($Message);
		}
	}
}