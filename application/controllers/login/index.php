<?php
	class Controller_login_index extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Se connecter',
			]);
			
			if(isset($_SESSION['id']))
				$view	=	\Eliya\Tpl::get('login/alreadyLogged');
			else
				$view	=	\Eliya\Tpl::get('login/index');
			
			$this->response->set($view);
		}
		
		public function post_index()
		{
			//Code pour connecter le membre
		}
	}