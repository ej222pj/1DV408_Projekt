<?php

namespace model;

require_once('./model/LoginModel.php'); 
require_once('./model/Repository.php');   
	
class BlogModel {
	private $loginModel;
	
	private $picPath = "./UploadedPics/";
	
	private $file = "file";
	private $type = "type";
	private $size = "size";
	private $name = "name";
	private $tmp_name = "tmp_name";
	private $user = "user";
	private $loginSucess = "LoginSucess";
	
	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->Repository = new Repository();
	}
	
	public function loginStatus(){
		return $this->loginModel->loginstatus();
	}
	//Kolla om bilden validerar
	public function checkPic(){
		$allowedExts = array("jpeg", "jpg", "png");
		$temp = explode(".", $_FILES[$this->file][$this->name]);
		$extension = end($temp);
		if(($_FILES[$this->file][$this->type] == "image/jpeg")
		|| ($_FILES[$this->file][$this->type] == "image/jpg")
		|| ($_FILES[$this->file][$this->type] == "image/png")
		&& ($_FILES[$this->file][$this->size] < 52428800)
		&& in_array($extension, $allowedExts)){
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
	}
	//Sparar bilden i både mappen och databasen
	public function saveImg($newPicName, $rubrik){
		try{		
			//Save to folder
			move_uploaded_file($_FILES[$this->file][$this->tmp_name], $this->picPath . $newPicName);
			
			//Save to database
			$uploader = $_SESSION[$this->user];
			$db = $this->Repository->connection();
			
			$sql = "INSERT INTO BlogImages (uploader, image, rubrik) VALUES(?, ?, ?)";
			$params = array($uploader, $newPicName, $rubrik);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Spara bilden!");
		}
	}
	//Sparar blogposterna
	public function blogPosts(){
		$_SESSION[$this->loginSucess] = false;
		try{	
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM BlogImages";
			$params = array();
			
			$query = $db->prepare($sql);
			$query->execute($params);
			$result = $query->fetchAll();
			
			return $result;	
			}
		catch(\Exception $e){
			throw new \Exception("Databas error, Hämta blogposter!");
		}	
	}
	//Hämtar kommentaren i databasn
	public function picComments($id){
		try{	
			$db = $this->Repository->connection();
			
			$sql = "SELECT * FROM CommentsForPics WHERE Id = ?";
			$params = array($id);
			
			$query = $db->prepare($sql);
			$query->execute($params);
			$result = $query->fetchAll();
			
			return $result;	
			}
		catch(\Exception $e){
			throw new \Exception("Databas error, Hämta blogposter!");
		}	
	}
	//Sparar kommentaren i databasen
	public function commentOnPost($id, $comment){
		try{
			$uploader = $_SESSION[$this->user];
			$db = $this->Repository->connection();
			
			$sql = "INSERT INTO CommentsForPics (Id, uploader, comment) VALUES(?, ?, ?)";
			$params = array($id, $uploader, $comment);
			
			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Kommentera på inlägg!");
		}
	}
	//Tar bort ett inlägg med hjälp av inläggsId
	public function removePost($postPic){
		try{	
			//Tar bort bilden med info från databasen
			$db = $this->Repository->connection();
			
			$sql = "DELETE FROM BlogImages WHERE image = ?";
			$params = array($postPic);
			
			$query = $db->prepare($sql);
			$query->execute($params);
			
			//Tar bort bilden från mappen
			unlink($this->picPath . $postPic);
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Ta bort bilden!");
		}
	}
	//Tar bort en kommentaren via kommentarId
	public function removeComment($commentId){
		try{	
			//Tar bort bilden med info från databasen
			$db = $this->Repository->connection();
			
			$sql = "DELETE FROM CommentsForPics WHERE commentId = ?";
			$params = array($commentId);
			
			$query = $db->prepare($sql);
			$query->execute($params);
		}
		catch(\Exception $e){
			throw new \Exception("Databas error, Ta bort Kommentar!");
		}
	}
}
	