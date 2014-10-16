<?php

namespace view;

class BlogView {
	private $model;
	private $user;
	private $message = "";
	private $Uvalue = "";
	private $RegUvalue = "";
	private $picComment = "";
	private $postNr = 0;
	private $picForRemoval = "";
	
	public function __construct(\model\BlogModel $model) {
		$this->model = $model;
	}
	
	public function printImg($image){
		$dirname = './UploadedPics/';
		$ret = '<a href=""><img class=pictures src="' . $dirname . $image . '" /></a>';
		return $ret;
	}
	
	public function didUserPressUpload(){
		if(isset($_POST['upload'])){
			return true;
		}
	}
	
	public function didUserPressComment(){
		if(isset($_POST['postcomment'])){
			return true;
		}
	}
	
	public function commentThisPost(){//Tar fram Id på bilden som ska kommentera
		return $_POST['commentThisPost'];
	}
	
	public function didUserPressRemovePost(){		
		if(isset($_POST['removePost'])){
			return true;
		}
	}
	
	public function postForRemoval(){//Tar fram namnet på bilden som ska bort
		return $_POST['picForRemoval'];
	}
	
	public function didUserPressEditComment(){		
		if(isset($_POST['editComment'])){
			return true;
		}
	}
	
	public function didUserPressRemoveComment(){		
		if(isset($_POST['removeComment'])){
			return true;
		}
	}
	
	public function removeThisComment(){//Tar fram Id på kommentaren som ska bort
		return $_POST['commentForRemoval'];
	}
	
	
	
	public function getComment(){
		if(($_POST["comment"]) == ""){
			$this->message = "kommentar saknas!";
		}
		else{
			return $_POST["comment"];
		}
	}
	
	public function getRubrik(){
		if(($_POST["rubrik"]) == ""){
			$this->message = "Rubrik saknas!";
		}
		else{
			return $_POST["rubrik"];
		}
	}
	
	public function setUser($username){
		$ret = $this->user = $username;
		return $ret;
	}
	
	public function HTMLPage($statusMessage){
		$Message = "$statusMessage";
		
		if(isset($_SESSION['user']) === false){
			$_SESSION['user'] = $this->user;
		}
		
		$ret = "<img src='./pic/bild.jpg' class='headerpic' alt=''>";
			//Om man inte är inloggad
			if($this->model->loginstatus() == false) {
				$ret .= "	
				<div class='border'>				
					<h2>Ej inloggad</h2>
						<form method='post' id='login'>
							<fieldset>
								<legend>Logga in</legend>
								<p>$this->message</p>
								<p>$Message</p>
								<label>Användarnamn:</label>
								<input type=text size=2 name='username' id='UserNameID' value='$this->Uvalue'>
								<label>Lösenord:</label>
								<input type=password size=2 name='password' id='PasswordID' value=''>
								<label>Håll mig inloggad  :</label>
								<input type=checkbox name='checkbox'>
								<input type=submit name='Login' value='Logga in'>
							</fieldset>
						</form>
					</div>
					<div class='bordertwo'>	
					<h2>Registrerar användare</h2>
					<form method='post' id='register'>
						<fieldset>
							<legend>Registrera ny användare</legend>
							<p>$this->message</p>
							<p>$Message</p>
							<label>Namn:</label>
							<input type=text size=5 name='regusername' id='regUserNameID' value='$this->RegUvalue'>
							<label>Lösenord:</label>
							<input type=password size=5 name='regpassword' id='regPasswordID' value=''>
							<label>Repetera Lösenord:</label>
							<input type=password size=5 name='repregpassword' id='repregPasswordID' value=''>
							<input type=submit name='RegisterNew' value='Registrera'>
						</fieldset>
					</form>
				</div>
				
				";
			}
			//Om man är inloggad
			if($this->model->loginstatus()){
				$posts = $this->model->blogPosts();		
					
				$ret .= "
						<h2>" . $_SESSION['user'] . "</h2>
						<form method='post'>
							<input type=submit name='Logout' value='Logga ut'>
						</form>
						<div class='uploadborder'>	
						<h2>Ladda upp bild</h2>
						<p>$this->message</p>
						<p class='textsize'>$Message</p>
						
					<form method='post' enctype='multipart/form-data'>
						<label for='file'>Filnamn:</label>
						<input type='file' name='file' id='file'>
						<label>Rubrik:</label>
						<input type=text size=5 name='rubrik' id='rubrik' value=''>		
						<input type='submit' name='upload' value='Upload'>
					</form>
					</div> 

					";
					
					//Sorterar listan efter datum
					usort($posts, function($a, $b){
						return $a["timestamp"] - $b["timestamp"]; 
					});
					
					foreach(array_reverse($posts) as $blogPost) {
					 	$removePostButton = "";
						$this->postNr++;
						$comments = $this->model->picComments($blogPost['Id']);
						
						//Tar fram en "ta bort post" knapp om inloggad användare har tillstånd
						if($blogPost['uploader'] == $_SESSION['user'] || $_SESSION['user'] == "Admin"){
							$removePostButton = "<form method='post'>
							<input type='submit' name='removePost' value='Ta bort inlägg'>
							<input type=text name='picForRemoval' class='hidden' value=" . $blogPost['image'] . ">
							</form>";
						}
						$ret .= "
							<div class='blogpost'> 
								<h3>" . $blogPost['rubrik'] . "</h3> " 
								. $this->printImg($blogPost['image']) . "
								<form method='post'>
									<textarea type=text cols='20' name='comment' class='comment'></textarea>
									<input type=submit name='postcomment' value='Kommentera'>
									<input type=text name='commentThisPost' class='hidden' value=" . $blogPost['Id'] . ">
								</form>";
								
						foreach($comments as $picComment){
							$RemoveComment = "";
							$EditComment = "";
							
							if($picComment['uploader'] == $_SESSION['user'] || $_SESSION['user'] == "Admin"){
									$RemoveComment = "<form method='post'>
									<input type='submit' name='removeComment' value='Ta Bort Kommentar'>
									<input type=text name='commentForRemoval' class='hidden' value=" .  $picComment['commentId'] . ">
								</form>";
							}
							if($picComment['uploader'] == $_SESSION['user']){
									$EditComment = "<form method='post'>
									<input type='submit' name='editComment' value='Redigera Kommentar'>
									<input type=text name='commentForEdit' class='hidden' value=" .  $picComment['commentId'] . ">
								</form>";
							}
							
							$ret .= "<div class='blogcomments'><p>" . $picComment['comment'] . "</p></div>" 
							. "<div class='commentinfo'>" . $picComment['uploader'] . " " . $picComment['timestamp'] . 
							$RemoveComment . $EditComment . "</div>";
						}
						$ret .= $removePostButton . "
								<p>Uppladdare " . $blogPost['uploader'] . "</p>
								<p>Datum " . $blogPost['timestamp'] . "</p>
																								
							</div>
						";
					}
		}
		return $ret;
	}
}