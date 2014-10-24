<?php

namespace controller;

require_once("./view/EditProfileView.php");
require_once("./view/BlogView.php");

require_once("./model/EditModel.php");


class EditController{
	private $editProfileView;
	private $blogView;

	private $editModel;
	
	private $Message = "";
	
	public function __construct() {
		$this->editModel = new \model\EditModel();
		
		$this->editProfileView = new \view\EditProfileView();
		$this->blogView = new \view\BlogView();
	}
	
	public function editProfile(){
		return $this->editProfileView->didUserPressSave();
	}
	
	public function htmlPage($Message){
		return $this->editProfileView->HTMLPage($Message);
	}
	
	public function changePasswordInput(){
		return $this->editProfileView->checkChangePasswordInput();
	}

	public function doEditProfile(){
		$oldPassword = $this->editProfileView->getOldPassword();
		$newPassword = $this->editProfileView->getNewPassword();
		
			if($this->editModel->editProfile($oldPassword, $newPassword)){
				$this->Message = "Lösenordet är ändrat";
			}
			else{
				$this->Message = "Gick inte att ändra lösenord";
			}
			return $this->blogView->HTMLPage($this->Message);	
	}
}