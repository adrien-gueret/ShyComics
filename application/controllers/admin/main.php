<?php
	//Main controller class of the admin panel: all controllers of the admin panel should inherit from it
	abstract class Controller_admin_main extends Controller_main
	{
		public function __init()
		{
			parent::__init();
			if(!$this->_current_member->can_access_admin_panel)
			{
				$this->response->error(Library_i18n::get('admin.forbidden_access'), 403);
				return;
			}
		}
	}