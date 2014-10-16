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


class BlogController{
	private $blogView;
	private $loginView;
	Private $registerView;
	
	private $blogModel;
	private $loginModel;
	private $registerModel;
	
	private $loginController;
	private $registerController;

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->loginModel = new \model\LoginModel();
		$this->registerModel = new \model\RegisterModel();
		
		$this->loginController = new \controller\LoginController();
		$this->registerController = new \controller\RegisterController();
		
		$this->blogView = new \view\BlogView($this->blogModel);
		$this->loginView = new \view\LoginView($this->loginModel);
		$this->registerView = new \view\RegisterView($this->registerModel);
	}
	
	public function BlogControl(){
		$Message = "";
		$_SESSION['UserWantsToLogin'] = false;
		if($this->loginView->didUserPressLogin()){
			$ret = $this->loginController->doLogin();
			$ret .= $this->registerController->doRegister();
			return $ret;
		}
		elseif($this->registerView->didUserPressRegisterNew()){
			$ret = $this->loginController->doLogin();
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
			$ret = $this->doUpload();
			return $ret;
		}
		elseif($this->blogView->didUserPressRemovePost()){
			$ret = $this->doRemovePost();
			return $ret;
		}
		elseif($this->blogView->didUserPressComment()){
			$ret = $this->doComment();
			return $ret;
		}
		elseif($this->blogView->didUserPressRemoveComment()){
			$ret = $this->doRemoveComment();
			return $ret;
		}
		else{
			return $this->blogView->HTMLPage($Message);
		}
	}
	//Laddar upp bilder.
	//Strukturen till denna koden är tagen ifrån
	//http://www.w3schools.com/php/php_file_upload.asp
	//Men jag har gjort en hel del ändringar
	public function doUpload(){
		$Message = "";
		$rubrik = $this->blogView->getRubrik();

		if ($this->blogModel->checkPic()){
			if ($_FILES["file"]["error"] > 0 || empty($rubrik)) {
				$Message = "Det gick inte att ladda upp bilden!";
			} 
			else{
				$newPicName = $this->blogModel->changeImgName($_FILES["file"]["name"]);
				$this->blogModel->saveImg($newPicName, $rubrik);
				$Message = $newPicName . " är uppladdad!";
			}
		}
		else {
			$Message = "Fel filformat";
		}
		return $this->blogView->HTMLPage($Message);
	}
	
	public function doRemovePost(){
		$Message = "";
		
		$postPic = $this->blogView->postForRemoval();//Hämta namnet på bilden som ska bort
		
		if(empty($postPic)){
			$Message = "Det gick inte att ta bort inlägget";
		}
		else{
			$this->blogModel->removePost($postPic);
			$Message = "Inlägget är borttaget";
		}
		
		return $this->blogView->HTMLPage($Message);
	}
	
	public function doComment(){
		$Message = "";
		
		$postId = $this->blogView->commentThisPost();//Hämta Id på bilden som ska kommenteras
		$comment = $this->blogView->getComment();
		
		if(empty($postId) || empty($comment)){
			$Message = "Det gick inte att kommentera";
		}
		else{
			$this->blogModel->commentOnPost($postId, $comment);
			$Message = "Du har kommenterat";
		}
		
		return $this->blogView->HTMLPage($Message);
	}
	
	public function doRemoveComment(){
		$Message = "";
		
		$commentId = $this->blogView->removeThisComment();//Hämta namnet på bilden som ska bort
		
		if(empty($commentId)){
			$Message = "Det gick inte att ta bort inlägget";
		}
		else{
			$this->blogModel->removeComment($commentId);
			$Message = "Kommentaren är borttagen";
		}
		
		return $this->blogView->HTMLPage($Message);
	}
}