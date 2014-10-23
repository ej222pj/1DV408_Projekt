<?php

namespace model;
 
require_once('./model/Repository.php');   

class EditModel {
	private $user = "user";
	
	private $picPath = "./UploadedPics/";
	
	public function __construct() {
		$this->Repository = new Repository();
	}
	//Editarar lösenordet
	public function editProfile($oldPassword, $newPassword){
		try{
			//Update password
			$loggedInUser = $_SESSION[$this->user];
			$db = $this->Repository->connection();
			
			$sql = "UPDATE registerforblog SET password=? WHERE name=? AND password=?";
			$params = array($newPassword, $loggedInUser, $oldPassword);
			
			$query = $db->prepare($sql);
			$query->execute($params);
			
			return true;

		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Lägg till nytt lösenord!");
		}
	}
}