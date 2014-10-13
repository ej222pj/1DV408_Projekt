<?php

namespace view;

class BlogView {
	private $model;
	private $user;
	private $message = "";
	private $Uvalue = "";
	private $RegUvalue = "";
	private $picHeader = "";
	
	public function __construct(\model\BlogModel $model) {
		$this->model = $model;
	}
	
	public function printImg(){
		$ret = array();
		$dirname = './UploadedPics/';
		$images = glob($dirname.'*.jpg');
		foreach($images as $image) {
			$ret[] =  '<img class=pictures src="'.$image.'" /><br />';
		}
		return $ret;
	}
	
	public function didUserPressUpload(){
		if(isset($_POST['upload'])){
			return true;
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
		
		$ret = "<img src='./pic/bild.jpg' style='Width:960px;Height:200px' alt=''>";
			
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
			}//<p>$this->message</p>
			if($this->model->loginstatus()){
				$images = $this->printImg();				
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
						<input type=text size=5 name='rubrik' id='rubrik' value='$this->picHeader'>
						<input type='submit' name='upload' value='Upload'>
					</form>
					</div> 

					";
					 foreach($images as $image) {
						$ret .= $image;
					 }
		}
		return $ret;
	}
}