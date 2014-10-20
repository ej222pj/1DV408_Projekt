<?php

namespace model;
 
require_once('./model/Repository.php');   

class EditModel {
	
	private $picPath = "./UploadedPics/";
	
	public function __construct() {
		$this->Repository = new Repository();
	}
	
	public function editProfile($newPassword){
		try{
			//Update password
			$loggedInUser = $_SESSION['user'];
			$db = $this->Repository->connection();
			
			$sql = "UPDATE registerforblog SET password=? WHERE name=?";
			$params = array($newPassword, $loggedInUser);
			
			$query = $db->prepare($sql);
			$query->execute($params);
			
			return true;
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Lägg till nytt lösenord!");
		}
	}
}