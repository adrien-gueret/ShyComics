<?php
	class Controller_SM58 extends Controller_index
	{
		public function __init()
		{
			parent::__init();	//Call parent init method
			
			//Overwrite page title
			\Eliya\Tpl::set([
				'page_title'		=>	'Page de SM58',
			]);
		}
		
		public function get_index()
		{
			$view	=	\Eliya\Tpl::get('SM58/index');
			$this->response->set($view);
		}
		
		public function get_coucou($name = 'SM58')
		{
			$view = \Eliya\Tpl::get('SM58/coucou', ['name' => $name]);
			$this->response->set($view);
		}
	}
?>