<?php
	class Controller_about_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('about')['page_title'],
				'page_description'	=>	Library_i18n::get('about')['page_description'],
			]);

			$this->response->set(\Eliya\Tpl::get('about/index'));
		}
	}