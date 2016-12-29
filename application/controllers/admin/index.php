<?php
	class Controller_admin_index extends Controller_admin_main
	{
		public function get_index()
		{
			$this->response->set(\Eliya\Tpl::get('admin/index'));
		}
	}