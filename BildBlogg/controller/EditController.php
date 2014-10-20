<?php

namespace controller;

require_once("./view/EditProfileView.php");
require_once("./view/BlogView.php");

require_once("./model/BlogModel.php");
require_once("./model/EditModel.php");


class EditController{
	private $editProfileView;

	public function __construct() {
		$this->blogModel = new \model\BlogModel();
		$this->editModel = new \model\EditModel();
		
		$this->editProfileView = new \view\EditProfileView();
		$this->blogView = new \view\BlogView($this->blogModel);
	}

	public function doEditProfile(){
		$Message = "";
		$newPassword = $this->editProfileView->getNewPassword();
		try{
			$this->editModel->editProfile($newPassword);
			
			return $this->blogView->HTMLPage($Message);
		}
		catch(\Exception $e){
			throw new \Exception("Försöker lägga till medlem!");
		}	
	}
}