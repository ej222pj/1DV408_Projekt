<?php

namespace controller;

require_once("./model/BlogModel.php");

require_once("./view/BlogView.php");

class BlogPostsController{
	private $blogView;
	
	private $blogModel;
	
	private $Message = "";

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		
		$this->blogView = new \view\BlogView($this->blogModel);
	}

	//Laddar upp bilder.
	//Strukturen till denna koden är tagen ifrån
	//http://www.w3schools.com/php/php_file_upload.asp
	//Men jag har gjort en hel del ändringar
	public function doUpload(){
		$rubrik = $this->blogView->getRubrik();

		if ($this->blogModel->checkPic()){
			if ($_FILES["file"]["error"] > 0 || empty($rubrik)) {
				$this->Message = "Det gick inte att ladda upp bilden!";
			} 
			else{
				$newPicName = $this->blogModel->changeImgName($_FILES["file"]["name"]);
				$this->blogModel->saveImg($newPicName, $rubrik);
				$this->Message = $newPicName . " är uppladdad!";
			}
		}
		else {
			$this->Message = "Fel filformat";
		}
		return $this->blogView->HTMLPage($this->Message);
	}
	
	public function doRemovePost(){
		$postPic = $this->blogView->postForRemoval();//Hämta namnet på bilden som ska bort
		
		if(empty($postPic)){
			$this->Message = "Det gick inte att ta bort inlägget";
		}
		else{
			$this->blogModel->removePost($postPic);
			$this->Message = "Inlägget är borttaget";
		}
		
		return $this->blogView->HTMLPage($this->Message);
	}
	
	public function doComment(){
		$postId = $this->blogView->commentThisPost();//Hämta Id på bilden som ska kommenteras
		$comment = $this->blogView->getComment();//Hämta kommentaren
		
		if(empty($postId) || empty($comment) || 
		strpos($comment,'<') !== false || 
		strpos($comment,'>') !== false){
			$this->Message = "Det gick inte att kommentera";
		}
		else{
			$this->blogModel->commentOnPost($postId, $comment);
			$this->Message = "Du har kommenterat";
		}
		
		return $this->blogView->HTMLPage($this->Message);
	}
	
	public function doRemoveComment(){
		$commentId = $this->blogView->removeThisComment();//Hämta namnet på bilden som ska bort
		
		if(empty($commentId)){
			$this->Message = "Det gick inte att ta bort inlägget";
		}
		else{
			$this->blogModel->removeComment($commentId);
			$this->Message = "Kommentaren är borttagen";
		}
		
		return $this->blogView->HTMLPage($this->Message);
	}
}