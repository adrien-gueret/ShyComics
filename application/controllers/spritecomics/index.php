<?php
	class Controller_spritecomics_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('spritecomics.index.page_title'),
				'page_description'	=>	Library_i18n::get('spritecomics.index.page_description'),
			]);
			
			$this->response->set(\Eliya\Tpl::get('spritecomics/index'));
		}
	}