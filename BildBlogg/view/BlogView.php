<?php

namespace view;
require_once("./view/LoginView.php");
require_once("./model/LoginModel.php");

class BlogView {
	private $blogModel;
	Private $loginModel;
	private $loginView;
	
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
	//Lägger bilderna i en <img> och <a> tagg
	public function printImg($image){
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
	//Trycker på upload
	public function didUserPressUpload(){
		if(isset($_POST[$this->upload])){
			return true;
		}
	}
	//Trycker på redigera profil
	public function didUserEditProfile(){
		if(isset($_POST[$this->editProfile])){
			return true;
		}
	}
	//Trycker på kommentera
	public function didUserPressComment(){
		if(isset($_POST[$this->postComment])){
			return true;
		}
	}
	//Tar fram Id på bilden som ska kommentera
	public function commentThisPost(){
		return $_POST[$this->commentThisPost];
	}
	//Trycker på ta bort inlägg
	public function didUserPressRemovePost(){		
		if(isset($_POST[$this->removePost])){
			return true;
		}
	}
	//Tar fram namnet på bilden som ska bort
	public function postForRemoval(){
		return $_POST[$this->picForRemoval];
	}
	//Trycker på redigera kommentar
	public function didUserPressEditComment(){		
		if(isset($_POST[$this->editComment])){
			return true;
		}
	}
	//Trycker på ta bort kommentar
	public function didUserPressRemoveComment(){		
		if(isset($_POST[$this->removeComment])){
			return true;
		}
	}
	//Tar fram Id på kommentaren som ska bort
	public function removeThisComment(){
		return $_POST[$this->commentForRemoval];
	}
	//Modellen vill ha kommentaren fårn getComment
	public function getComment(){
		if(($_POST[$this->comment]) == ""){
			$this->message = "kommentar saknas!";
		}
		else{
			return $_POST[$this->comment];
		}
	}
	//Modellen vill ha rubriken från getRubrik
	public function getRubrik(){
		if(($_POST[$this->rubrik]) == ""){
			$this->message = "Rubrik saknas!";
		}
		else{
			return $_POST[$this->rubrik];
		}
	}
	//Sätter användernamnet ifrån kakan om man loggar in med kakor
	public function setUser($username){
		$ret = $this->user = $username;
		return $ret;
	}
	
	public function HTMLPage($Message){
		$sessonUser = "user";
		$ret = "";
		//Sätter användarnamnet ifrån sessionen
		if(isset($_SESSION[$sessonUser]) === false){
			$_SESSION[$sessonUser] = $this->user;
		}
		
		//Om man inte är inloggad skapa en ny login page
		if($this->blogModel->loginstatus() == false) {
			$ret = $this->loginView->HTMLPage($Message);
		}
		
		//Om man är inloggad
		if($this->blogModel->loginstatus()){
			//Sparar alla blogposter i $posts
			$posts = $this->blogModel->blogPosts();		
			//Skapar logga ut, redigera profil, och ladda upp formulären
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
			<div class='allPosts'>
			";
			
			//Sorterar blogpost listan efter datum
			usort($posts, function($a, $b){
				return $a[$this->timestamp] - $b[$this->timestamp]; 
			});
			//Loopar igenom alla blogposter och skriver ut dom
			foreach($posts as $blogPost) {
				$uploader = "uploader";
				$image = "image";
				$commentId = "commentId";
				$Id = "Id";
				
			 	$removePostButton = "";
				$this->postNr++;//Ger posterna ett ID för att kunna ta bort eller lägga kommentarer på
				//Hämtar kommentarerna för rätt inlägg
				$comments = $this->blogModel->picComments($blogPost[$Id]);
				
				//Tar fram en "ta bort post" knapp om inloggad användare har tillstånd eller om man är Admin
				if($blogPost[$uploader] == $_SESSION[$sessonUser] || $_SESSION[$sessonUser] == "Admin"){
					$removePostButton = 
					"<form method='post'>
					<input type='submit' name=$this->removePost value='Ta bort inlägg'>
					<input type=text name=$this->picForRemoval class='hidden' value=" . $blogPost[$image] . ">
					</form>";
				}
				//Skriver ut blogposterna
				$ret .= "
					<div class='blogpost'> 
						<h3>" . $blogPost[$this->rubrik] . "</h3> " 
						. $this->printImg($blogPost[$image]) . "
						<form method='post'>
							<textarea type=text cols='20' name=$this->comment class='comment'></textarea>
							<input type=submit name=$this->postComment value='Kommentera'>
							<input type=text name=$this->commentThisPost class='hidden' value=" . $blogPost[$Id] . ">
						</form>";
				$ret .= "<div class='allComments'>";
				//Loopar kommentarer innuti inläggen
				foreach(array_reverse($comments) as $picComment){
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
					//Lägger till kommentaren, person som kommenterade/timestamp och ta bort kommentar
					$ret .= "<div class='blogcomments'><p>" . $picComment[$this->comment] . "</p></div>" 
					. "<div class='commentinfo'>" . $picComment[$uploader] . " " . $picComment[$this->timestamp] . 
					$RemoveComment . "</div>";
				}
				//Lägger till ta bort inlägg knapp, uppladder/timestamp
				$ret .= "</div>" . $removePostButton . "
						<p>Uppladdare " . $blogPost[$uploader] . "</p>
						<p>Datum " . $blogPost[$this->timestamp] . "</p>												
					</div>
				";
			}
		}
		return $ret;
	}
}