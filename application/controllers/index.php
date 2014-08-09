<?php
	/*
		Controller_index is the default controller called on the website root
	*/
	class Controller_index extends Eliya\Controller
	{
		//This "magic" method is called by Eliya, like a constructor
		public function __init()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Page title',
				'page_description'	=>	'Page description',
			]);
		}
		
		//action index with GET request (corresponding to path "./")
		public function get_index()
		{
			$this->response->set('<p>Hello world!</p>');
		}
	}