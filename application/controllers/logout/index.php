<?php
	class Controller_logout_index extends Controller_main
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
				\Eliya\Tpl::set(['current_member' => null]);
				
				$view	=	\Eliya\Tpl::get('login/index');
			}
			else
			{
				$view	=	'Erreur &bull; Jeton de sécurité manquant ou incorrect.';
			}
			
			$this->response->set($view);
		}
	}