<?php

namespace view;

class EditProfileView{
	
	// public function didUserPressSave(){
		// if(isset($_POST['save'])){
			// return true;
		// }
	// }
	
		public function didUserPressSave(){
		if(isset($_POST['save'])){
			if(($_POST["newusername"]) == "" && ($_POST["oldpassword"]) == ""){
				$this->RegUvalue = $_POST["regusername"];
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken!\nLösenordet har för få tecken. Minst 6 tecken";
			}
			elseif(strlen(($_POST["newusername"])) < 3){
				$this->RegUvalue = $_POST["newusername"];
				$this->message = "Användarnamnet har för få tecken. Minst 3 tecken";
			}
			elseif(($_POST["oldpassword"]) == "" && ($_POST["newusername"]) != "" || strlen(($_POST["oldpassword"])) < 6) {
				$this->RegUvalue = $_POST["newusername"];
				$this->message = "Lösenordet har för få tecken. Minst 6 tecken";
			}
			elseif(($_POST["repnewpassword"]) !== ($_POST["newpassword"])) {
				$this->RegUvalue = $_POST["newusername"];
				$this->message = "Lösenorden matchar inte";
			}
			return true;
		}
		else{
			return false;
		}
	}

	public function HTMLPage($Message){
	$ret = "";

		$ret .= "	
		<img src='./pic/bild.jpg' class='headerpic' alt=''>
		<div class='fullborder'>				
			<h2>Ej inloggad</h2>
				<form method='post' id='RedigeraProfil'>
					<fieldset>
						<legend>Redigera Profil</legend>
						<p>$Message</p>
						<label>Användarnamn:</label>
						<input type=text size=2 name='newusername' id='newUserNameID' value=''>
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