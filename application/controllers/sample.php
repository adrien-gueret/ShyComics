<?php
	/*
		Sample controller.
	*/
	
	//This controller extends our own index controller for this example
	class Controller_sample extends Controller_index
	{
		//This "magic" method is called by Eliya, like a constructor
		public function __init()
		{
			parent::__init();	//Call parent init method
			
			//Overwrite page title
			\Eliya\Tpl::set([
				'page_title'		=>	'This is a sample page',
			]);
		}
		
		/*
			action index with GET request
			Corresponding to paths

			./sample/
			./sample?page=2
			etc.

			 Thanks to URL rewritting from congifs/main.json, you can access this controller via:
			./sample-1.html
			./sample-8242.html
			etc.
		*/
		public function get_index($page = 0)
		{
			//We get and display the value of GET parameter "page"
			//Get parameter can be gotten via $this->request->get() method or simply thanks to this method parameter
			$this->response->set('<p>Page to see: <b>'.$this->request->get('page').' ('.$page.')</b></p>');
		}

		/*
			action test with GET request
			Corresponding to path ./sample/test/ (with(out) "name" get parameter)
		*/
		public function get_test($name = 'World')
		{
			$view	=	\Eliya\Tpl::get('sample/test', ['name' => $name]);
			$this->response->set($view);
		}

		/*
			action test with POST request
			Corresponding to path ./sample/test/ (with(out) "total" post parameter
		*/
		public function post_test($total = null)
		{
			if(empty($total))
				$this->response->set('<p>You perform a post request to ./sample/test without "total" parameter!</p>');
			else
				$this->response->set('<p>You perform a post request to ./sample/test with '.$total.' as "total" parameter!</p>');
				//You can also use $this->request->post('total') if you don't want to/can't use method parameters
		}
	}