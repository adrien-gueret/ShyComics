<?php
	/*
		A custom admin controller
		Corresponding path: ./admin/
	*/
	class Controller_admin_login extends Controller_admin
	{
		//We don't want to force users to be admin for this controller
		public function __init($require_admin = false)
		{
			parent::__init($require_admin);
		}

		//If we don't overwrite get_index() method, the one from parent will be used
	}