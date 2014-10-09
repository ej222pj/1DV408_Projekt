<?php

class BlogView {
	private $model;

	public function __construct(BlogModel $model) {
		$this->model = $model;
	}
	
	public function didUserPressLoginView(){
		if(isset($_POST['LoginView'])){
			return true;
		}
	}
	
	//Hämtar ut användarnamnet
	public function getUsername(){
		if(isset($_POST["username"])){
			return $_POST["username"];
		}
	}

	//Hämtar ut lösenordet
	public function getPassword(){
		if(isset($_POST["password"])){
			return $_POST["password"];
		}
	}
	
	public function didUserPressRegister(){
		if(isset($_POST['Register'])){
			return true;
		}
	}
	
	public function HTMLPage(){
		$ret = "";
			
			$ret = "
				<img src='./pic/bild.jpg' style='Width:960px;Height:200px' alt=''>
				<form method='post'>
						<input type=submit name='' value='Något'>
						<input type=submit name='LoginView' value='Logga in'>
						<input type=submit name='Register' value='Registrera'>
				</form>
				
				<h2>Ej 
				inloggad</h2>
					<form method='post'>
						<fieldset>
							<legend>Login - Skriv in användarnamn och lösenord</legend>

							<label>Användarnamn:</label>
							<input type=text size=20 name='username' id='UserNameID' value=''>
							<label>Lösenord:</label>
							<input type=password size=20 name='password' id='PasswordID' value=''>
							<label>Håll mig inloggad  :</label>
							<input type=checkbox name='checkbox'>
							<input type=submit name='LoginView' value='Logga in'>
						</fieldset>
					</form>
			
			";
		
		return $ret;
	}
}