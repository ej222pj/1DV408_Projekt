<?php

namespace model;

require_once('./model/LoginModel.php'); 
require_once('./model/Repository.php');   
	
//Hur ska jag spara bilder?

class BlogModel {
	
	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->Repository = new Repository();
	}
	
	public function loginStatus(){
		return $this->loginModel->loginstatus();
	}
	
	public function checkPic(){
		$allowedExts = array("jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		
		if(($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/png")
		&& ($_FILES["file"]["size"] < 52428800)
		&& in_array($extension, $allowedExts)){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function imgExists(){
		if(file_exists("./UploadedPics/" . $_FILES["file"]["name"])){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function saveImg(){
		//Save to database
		$image = $_FILES['file']['name'];
		$uploader = $_SESSION['user'];
		$db = $this->Repository->connection();
		
		$sql = "INSERT INTO images (uploader, imagename) VALUES(?, ?)";
		$params = array($uploader, $image);
		
		$query = $db -> prepare($sql);
		$query -> execute($params);
		//$result = $query -> fetch();
		
		//Save to folder
		move_uploaded_file($_FILES["file"]["tmp_name"], "./UploadedPics/" . $_FILES["file"]["name"]);
	}
}
	