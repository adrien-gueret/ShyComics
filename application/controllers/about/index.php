<?php
	class Controller_about_index extends Controller_main
	{
		public function get_index()
		{
			$this->response->set(\Eliya\Tpl::get('about/index'));
		}
	}