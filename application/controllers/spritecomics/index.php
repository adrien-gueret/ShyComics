<?php
	class Controller_spritecomics_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function get_add()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Ajouter du contenu',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/add');
			$this->response->set($view);
		}
	}