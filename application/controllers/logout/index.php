<?php
	class Controller_logout_index extends Controller_index
	{
		public function get_index($token = null)
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Déconnexion',
			]);
			
			if(isset($_SESSION['connected_user_id']) && !empty($token) && $token == $_SESSION['token_logout'])
			{
				$_SESSION = array();
				session_destroy();
				
				\Eliya\Tpl::set([
					'connected_user_id' 		=> 	'',
					'connected_user_username'	=> 	'',
				]);
				
				$view	=	\Eliya\Tpl::get('login/index');
			}
			else
			{
				$view	=	'Erreur';
			}
			
			$this->response->set($view);
		}
	}