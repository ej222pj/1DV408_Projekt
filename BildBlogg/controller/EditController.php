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