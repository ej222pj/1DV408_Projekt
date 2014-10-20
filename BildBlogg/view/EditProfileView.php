<?php

namespace view;

class EditProfileView{
	
	private $message;
	
	private $save = "save";
	private $oldpassword = "oldpassword";
	private $newpassword = "newpassword";
	private $repnewpassword = "repnewpassword";
	
	public function didUserPressSave(){
		if(isset($_POST[$this->save])){
				return true;
		}
	}
	
	public function getOldPassword(){
		if(isset($_POST[$this->oldpassword])){
				return $_POST[$this->oldpassword];
		}
	}
	
	public function getNewPassword(){
		if(isset($_POST[$this->newpassword])){
				return $_POST[$this->newpassword];
		}
	}
	
	public function checkChangePasswordInput(){
		if(($_POST[$this->oldpassword]) == ""){
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST[$this->oldpassword]) == "" || strlen(($_POST[$this->oldpassword])) < 6) {
				$this->message = "Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST[$this->newpassword]) == "" || strlen(($_POST[$this->newpassword])) < 6) {
				$this->message = "Nya Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST[$this->repnewpassword]) == "" || strlen(($_POST[$this->repnewpassword])) < 6) {
				$this->message = "Repetera Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST[$this->repnewpassword]) !== ($_POST[$this->newpassword])) {
				$this->message = "Lösenorden matchar inte";
				return false;
			}
			else{
				return true;
			}
	}

	public function HTMLPage($Message){
	$user = "user";
	$ret = "";

		$ret .= "	
		<img src='./pic/bild.jpg' class='headerpic' alt=''>
		<div class='fullborder'>				
			<h2>" . $_SESSION[$user] . "</h2>
				<form method='post' id='RedigeraProfil'>
					<fieldset>
						<legend>Redigera Profil</legend>
						<p>$this->message</p>
						<p>$Message</p>
						<label>Gammalt Lösenord:</label>
						<input type=password size=2 name=$this->oldpassword id='oldPasswordID' value=''>
						<label>Nytt Lösenord:</label>
						<input type=password size=2 name=$this->newpassword id='newPasswordID' value=''>
						<label>Repetera Lösenord:</label>
						<input type=password size=5 name=$this->repnewpassword id='repnewpasswordID' value=''>
						<input type=submit name=$this->save value='Spara'>
						<input type=submit name='' value='Tillbaka'>
					</fieldset>
				</form>
			</div>				
		";
	return $ret;
		
}
}