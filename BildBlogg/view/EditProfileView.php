<?php

namespace view;

class EditProfileView{
	
	public function didUserPressSave(){
		if(isset($_POST['save'])){
			return true;
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