<?php

namespace model;

require_once('./model/LoginModel.php'); 
require_once('./model/Repository.php');   
	
//Hur ska jag spara bilder?

class BlogModel {
	
	private $picPath = "./UploadedPics/";
	
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
		if(file_exists($this->picPath . $_FILES["file"]["name"])){
			return true;
		}
		else{
			return false;
		}
	}
	
	//Att ändra filnamn hittade jag en bra funktion på 
	//http://css-tricks.com/snippets/php/check-if-file-exists-append-number-to-name/
	public function changeImgName($filename){
		if ($pos = strrpos($filename, '.')) {
			$name = substr($filename, 0, $pos);
			$ext = substr($filename, $pos);
		} else {
			$name = $filename;
		}
		$newpath = $this->picPath . $filename;
		$newname = $filename;
		$counter = 0;
	
		while(file_exists($newpath)){
			$newname = $name .'_'. $counter . $ext;
		    $newpath = $this->picPath . $newname;
		    $counter++;
		 }
		return $newname;
		// $directory = $this->picPath;
		// $jpg = glob($directory . '*.jpg');
		// $jpeg = glob($directory . '*.jpeg');
		// $png = glob($directory . '*.png');
// 
		// if($jpg !== false || $jpeg !== false || $png !== false)
		// {
		    // $jpgcount = count($jpg);
			// $jpegcount = count($jpeg);
			// $pngcount = count($png);
			// $result = $jpgcount + $jpegcount + $pngcount;
		// }
		// $newname = $result . $filename;
		// var_dump($newname);
	}
	
	public function saveImg($newPicName, $rubrik){
		//Save to folder
		move_uploaded_file($_FILES["file"]["tmp_name"], $this->picPath . $newPicName);
		
		//Save to database
		$uploader = $_SESSION['user'];
		$db = $this->Repository->connection();
		
		$sql = "INSERT INTO blogimages (uploader, image, rubrik) VALUES(?, ?, ?)";
		$params = array($uploader, $newPicName, $rubrik);
		
		$query = $db -> prepare($sql);
		$query -> execute($params);
	}
	
	public function blogPosts(){
		$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM blogimages";
			$params = array();
			
			$query = $db->prepare($sql);
			$query->execute($params);
			$result = $query->fetchAll();
			
			return $result;		
	}
}
	