<?php
	/*
		Controller_index is the default controller called on the website root
	*/
	class Controller_index extends Eliya\Controller
	{
		protected $_current_url	=	null;
		protected $_current_member	=	null;

		//This "magic" method is called by Eliya, like a constructor
		public function __init()
		{
			$this->_current_url	=	$this->request->getProtocol().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			if(substr($this->_current_url, -1) !== '/')
				$this->_current_url	.=	'/';

			\Eliya\Tpl::set([
				'page_title'				=>	'Page title',
				'page_description'			=>	'Page description',
				'base_url'					=>	$this->request->getBaseURL(),
				'current_url'				=>	$this->_current_url,
			]);
			
			if(isset($_SESSION['connected_user_id']))
			{
				$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);
				\Eliya\Tpl::set(['current_member' => $this->_current_member]);
			}
			else
			{
				\Eliya\Tpl::set(['current_member' => null]);
			}
			
			if(!isset($_SESSION['token_logout']))
				$_SESSION['token_logout'] = uniqid(rand(), true); //Protection contre les failles CSRF
		}
		
		//action index with GET request (corresponding to path "./")
		public function get_index()
		{
			$this->response->set('<p>Hello world!</p>');
		}
	}