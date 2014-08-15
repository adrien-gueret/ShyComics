<?php
	class Controller_Toulou extends Controller_index
	{
		public function __init()
		{
			parent::__init();	//Call parent init method
			
			//Overwrite page title
			\Eliya\Tpl::set([
				'page_title'		=>	'Toulou\'s place',
			]);
		}
		
		public function get_index()
		{
			$view	=	\Eliya\Tpl::get('Toulou/index');
			$this->response->set($view);
		}
		
		public function get_coucou($name = 'Toulou')
		{
			$view = \Eliya\Tpl::get('Toulou/coucou', ['name' => $name]);
			$this->response->set($view);
		}
	}
?>