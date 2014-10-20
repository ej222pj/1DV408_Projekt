<?php

namespace controller;

require_once("./view/EditProfileView.php");
require_once("./view/BlogView.php");

require_once("./model/BlogModel.php");
require_once("./model/EditModel.php");


class EditController{
	private $editProfileView;
	private $blogView;
	
	private $blogModel;
	private $editModel;
	
	private $Message = "";
	
	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->editModel = new \model\EditModel();
		
		$this->editProfileView = new \view\EditProfileView();
		$this->blogView = new \view\BlogView($this->blogModel);
	}

	public function doEditProfile(){
		
		$newPassword = $this->editProfileView->getNewPassword();
		try{
			if($this->editModel->editProfile($newPassword)){
				$this->Message = "Lösenordet är ändrat";
			}
			
			return $this->blogView->HTMLPage($this->Message);
		}
		catch(\Exception $e){
			throw new \Exception("Försöker lägga till medlem!");
		}	
	}
}