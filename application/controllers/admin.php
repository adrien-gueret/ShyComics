<?php
	/*
		A custom controller for handling back office
		Corresponding path: ./admin/
	*/
	class Controller_admin extends Eliya\Controller
	{
		//Set another view path for header
		protected $_header_view_path	=	'admin';

		//By default, all controller inheriting from Controller_admin will require an admin user
		public function __init($require_admin = true)
		{
			if($require_admin)
				$this->_requireAdmin();

			\Eliya\Tpl::set([
		  		'page_title'		=>	'Admin',
		  	]);
		}

		protected function _requireAdmin()
		{
			//Of course, we should check for admin status here... For a simpler example, we simply forbid the access
			$this->response->error('Forbidden access', 403);
		}

		public function get_index()
		{
			$this->response->set('<p>Hello to admin!</p>');
		}
	}