<?php

namespace view;

class BlogView {
	private $model;
	private $user;
	private $Uvalue = "";
	
	public function __construct(\model\BlogModel $model) {
		$this->model = $model;
	}
	
	// public function didUserPressLoginView(){
		// if(isset($_POST['LoginView'])){
			// return true;
		// }
	//}
	public function setUser($username){
		$ret = $this->user = $username;
		return $ret;
	}
	
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
	}
	
	public function HTMLPage($statusMessage){
		$Message = "$statusMessage";
		
		if(isset($_SESSION['user']) === false){
			$_SESSION['user'] = $this->user;
		}
		
		$ret = "<img src='./pic/bild.jpg' style='Width:960px;Height:200px' alt=''>";
			
			if($this->model->loginstatus() == false) {
				$ret .= "
					<form method='post'>
							<input type=submit name='' value='Något'>
							<input type=submit name='LoginView' value='Logga in'>
							<input type=submit name='Register' value='Registrera'>
					</form>
					
					<h2>Ej inloggad</h2>
						<form method='post'>
							<fieldset>
								<legend>Login - Skriv in användarnamn och lösenord</legend>
								<p>$Message</p>
								<label>Användarnamn:</label>
								<input type=text size=20 name='username' id='UserNameID' value='$this->Uvalue'>
								<label>Lösenord:</label>
								<input type=password size=20 name='password' id='PasswordID' value=''>
								<label>Håll mig inloggad  :</label>
								<input type=checkbox name='checkbox'>
								<input type=submit name='Login' value='Logga in'>
							</fieldset>
						</form>
				
				";
			}//<p>$this->message</p>
			if($this->model->loginstatus()){
				$ret .= "
						<h2>" . $_SESSION['user'] . " är inloggad</h2>
				 		
				 		<p>$Message</p>
						<form method ='post'>
							<input type=submit name='Logout' value='Logga ut'>
						</form>
						";
		}
		return $ret;
	}
}