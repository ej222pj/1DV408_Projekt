<?php

namespace model;

require_once('./model/LoginModel.php');    
	
//Hur ska jag spara bilder?

class BlogModel {
	
	public function __construct() {
		$this->loginModel = new LoginModel();
	}
	
	public function loginStatus(){
		return $this->loginModel->loginstatus();
	}
	
	public function imgUploaded(){
		if(file_exists("./UploadedPics/" . $_FILES["file"]["name"])){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function saveImg(){
		move_uploaded_file($_FILES["file"]["tmp_name"],
		"./UploadedPics/" . $_FILES["file"]["name"]);
	}
}
	