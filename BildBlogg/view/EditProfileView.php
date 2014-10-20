<?php

namespace view;

class EditProfileView{
	
	private $message;
	
	public function didUserPressSave(){
		if(isset($_POST['save'])){
				return true;
		}
	}
	
	public function getNewPassword(){
		if(isset($_POST['newpassword'])){
				return $_POST['newpassword'];
		}
	}
	
	public function checkChangePasswordInput(){
		if(($_POST["oldpassword"]) == ""){
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST["oldpassword"]) == "" || strlen(($_POST["oldpassword"])) < 6) {
				$this->message = "Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST["newpassword"]) == "" || strlen(($_POST["newpassword"])) < 6) {
				$this->message = "Nya Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST["repnewpassword"]) == "" || strlen(($_POST["repnewpassword"])) < 6) {
				$this->message = "Repetera Lösenordet har för få tecken. Minst 6 tecken";
				return false;
			}
			elseif(($_POST["repnewpassword"]) !== ($_POST["newpassword"])) {
				$this->message = "Lösenorden matchar inte";
				return false;
			}
			else{
				return true;
			}
	}

	public function HTMLPage($Message){
	$ret = "";

		$ret .= "	
		<img src='./pic/bild.jpg' class='headerpic' alt=''>
		<div class='fullborder'>				
			<h2>" . $_SESSION['user'] . "</h2>
				<form method='post' id='RedigeraProfil'>
					<fieldset>
						<legend>Redigera Profil</legend>
						<p>$this->message</p>
						<p>$Message</p>
						<label>Gammalt Lösenord:</label>
						<input type=password size=2 name='oldpassword' id='oldPasswordID' value=''>
						<label>Nytt Lösenord:</label>
						<input type=password size=2 name='newpassword' id='newPasswordID' value=''>
						<label>Repetera Lösenord:</label>
						<input type=password size=5 name='repnewpassword' id='repnewpasswordID' value=''>
						<input type=submit name='save' value='Spara'>
					</fieldset>
				</form>
			</div>				
		";
	return $ret;
		
}
}