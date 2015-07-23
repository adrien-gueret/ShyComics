<?php
	/*
		Controller_index is the default controller called on the website root
	*/
	class Controller_index extends Controller_main
	{
		public function get_index()
		{
			$this->response->set(\Eliya\Tpl::get('index/index'));
		}
	}