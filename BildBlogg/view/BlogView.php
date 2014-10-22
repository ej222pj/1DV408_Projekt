<?php

namespace view;
require_once("./view/LoginView.php");
require_once("./model/LoginModel.php");

class BlogView {
	private $blogModel;
	private $loginView;
	Private $loginModel;
	
	private $dirname = "./UploadedPics/";
	private $upload = "upload";
	private $editProfile = "EditProfile";
	private $postComment = "postcomment";
	private $commentThisPost = "commentThisPost";
	private $removePost = "removePost";
	private $picForRemoval = "picForRemoval";
	private $editComment = "editComment";
	private $removeComment = "removeComment";
	private $commentForRemoval = "commentForRemoval";
	private $comment = "comment";
	private $rubrik = "rubrik";
	private $timestamp = "timestamp";
	private $logout = "Logout";
	
	private $user;
	private $message = "";
	private $postNr = 0;
	
	public function __construct(\model\BlogModel $blogModel) {
		$this->blogModel = $blogModel;
		
		$this->loginModel = new \model\LoginModel;
		
		$this->loginView = new \view\LoginView($this->loginModel);
	}
	
	public function printImg($image){//Lägger bilderna i en img och a tagg
		$ret = '<a href="' . $this->dirname . $image . '" target="_blank"><img class=pictures src="' . $this->dirname . $image . '" alt=""/></a>';
		return $ret;
	}
	
	
	//Kollar om man klickat på logout knappen.
	public function didUserPressLogout(){
		if(isset($_POST[$this->logout])){
			$this->loginView->removeCookie();
			return true;
		}
		else {
			return false;
		}
	}
	
	public function didUserPressUpload(){
		if(isset($_POST[$this->upload])){
			return true;
		}
	}
	
	public function didUserEditProfile(){
		if(isset($_POST[$this->editProfile])){
			return true;
		}
	}
	
	public function didUserPressComment(){
		if(isset($_POST[$this->postComment])){
			return true;
		}
	}
	
	public function commentThisPost(){//Tar fram Id på bilden som ska kommentera
		return $_POST[$this->commentThisPost];
	}
	
	public function didUserPressRemovePost(){		
		if(isset($_POST[$this->removePost])){
			return true;
		}
	}
	
	public function postForRemoval(){//Tar fram namnet på bilden som ska bort
		return $_POST[$this->picForRemoval];
	}
	
	public function didUserPressEditComment(){		
		if(isset($_POST[$this->editComment])){
			return true;
		}
	}
	
	public function didUserPressRemoveComment(){		
		if(isset($_POST[$this->removeComment])){
			return true;
		}
	}
	
	public function removeThisComment(){//Tar fram Id på kommentaren som ska bort
		return $_POST[$this->commentForRemoval];
	}
	
	public function getComment(){
		if(($_POST[$this->comment]) == ""){
			$this->message = "kommentar saknas!";
		}
		else{
			return $_POST[$this->comment];
		}
	}
	
	public function getRubrik(){
		if(($_POST[$this->rubrik]) == ""){
			$this->message = "Rubrik saknas!";
		}
		else{
			return $_POST[$this->rubrik];
		}
	}
	
	public function setUser($username){
		$ret = $this->user = $username;
		return $ret;
	}
	
	public function HTMLPage($Message){
		$sessonUser = "user";
		$ret = "";
		
		if(isset($_SESSION[$sessonUser]) === false){
			$_SESSION[$sessonUser] = $this->user;
		}
		
		//Om man inte är inloggad
		if($this->blogModel->loginstatus() == false) {
			$ret = $this->loginView->HTMLPage($Message);
		}
		
		//Om man är inloggad
		if($this->blogModel->loginstatus()){
			
			$posts = $this->blogModel->blogPosts();		
				
			$ret = "
			<img src='./pic/bild.jpg' class='headerpic' alt=''>
				<h2>" . $_SESSION[$sessonUser] . "</h2>
				<form method='post'>
					<input type=submit name=$this->logout value='Logga ut'>
					<input type=submit name=$this->editProfile value='Redigera Profil'>
				</form>
				<div class='uploadborder'>	
				<h2>Ladda upp bild</h2>
				<p>$this->message</p>
				<p class='textsize'>$Message</p>
				
			<form method='post' enctype='multipart/form-data'>
				<label for='file'>Filnamn:</label>
				<input type='file' name='file' id='file'>
				<label>Rubrik:</label>
				<input type=text size=5 name=$this->rubrik id='rubrik' value=''>		
				<input type='submit' name=$this->upload value='Upload'>
			</form>
			</div> 

			";
			
			//Sorterar listan efter datum
			usort($posts, function($a, $b){
				return $a[$this->timestamp] - $b[$this->timestamp]; 
			});
					
			foreach($posts as $blogPost) {
				$uploader = "uploader";
				$image = "image";
				$commentId = "commentId";
				$Id = "Id";
				
			 	$removePostButton = "";
				$this->postNr++;
				$comments = $this->blogModel->picComments($blogPost['Id']);
				
				//Tar fram en "ta bort post" knapp om inloggad användare har tillstånd
				if($blogPost[$uploader] == $_SESSION[$sessonUser] || $_SESSION[$sessonUser] == "Admin"){
					$removePostButton = 
					"<form method='post'>
					<input type='submit' name=$this->removePost value='Ta bort inlägg'>
					<input type=text name=$this->picForRemoval class='hidden' value=" . $blogPost[$image] . ">
					</form>";
				}
				$ret .= "
					<div class='blogpost'> 
						<h3>" . $blogPost[$this->rubrik] . "</h3> " 
						. $this->printImg($blogPost[$image]) . "
						<form method='post'>
							<textarea type=text cols='20' name=$this->comment class='comment'></textarea>
							<input type=submit name=$this->postComment value='Kommentera'>
							<input type=text name=$this->commentThisPost class='hidden' value=" . $blogPost[$Id] . ">
						</form>";
						
				foreach(array_reverse($comments) as $picComment){//Loopar kommentarer
					$RemoveComment = "";
					$EditComment = "";
					//Lägger till removecomment om uppladdaren är samma som inloggade
					if($picComment[$uploader] == $_SESSION[$sessonUser] || $_SESSION[$sessonUser] == "Admin"){
							$RemoveComment = 
						"<form method='post'>
							<input type='submit' name=$this->removeComment value='Ta Bort Kommentar'>
							<input type=text name=$this->commentForRemoval class='hidden' value=" .  $picComment[$commentId] . ">
						</form>";
					}
					
					$ret .= "<div class='blogcomments'><p>" . $picComment[$this->comment] . "</p></div>" 
					. "<div class='commentinfo'>" . $picComment[$uploader] . " " . $picComment[$this->timestamp] . 
					$RemoveComment . "</div>";
				}
				$ret .= $removePostButton . "
						<p>Uppladdare " . $blogPost[$uploader] . "</p>
						<p>Datum " . $blogPost[$this->timestamp] . "</p>												
					</div>
				";
			}
		}
		return $ret;
	}
}