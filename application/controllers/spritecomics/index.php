<?php
	class Controller_spritecomics_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$this->response->set(\Eliya\Tpl::get('spritecomics/index'));
		}
	}