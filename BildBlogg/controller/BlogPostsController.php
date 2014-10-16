<?php

namespace controller;

require_once("./model/BlogModel.php");

require_once("./view/BlogView.php");

class BlogPostsController{
	private $blogView;
	
	private $blogModel;

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		
		$this->blogView = new \view\BlogView($this->blogModel);
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