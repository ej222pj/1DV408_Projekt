<?php

namespace controller;

require_once("./view/EditProfileView.php");

class BlogPostsController{
	private $editProfileView;

	public function __construct() {
		$this->editProfileView = new \view\EditProfileView();
	}

	public function doEditProfile(){
		$Message = "";
		
	}	
}