<?php
	class Controller_login_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Se connecter',
			]);
			
			if(isset($_SESSION['connected_user_id']))
				$view	=	\Eliya\Tpl::get('login/alreadyLogged', $_SESSION);
			else
				$view	=	\Eliya\Tpl::get('login/index');
			
			$this->response->set($view);
		}
		
		public function post_index($username = null, $password = null)
		{
			if(!empty($username) && !empty($password))
			{
				$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
				$password = Library_String::hash($password);
				
				$resultMembre = Model_Users::getForLogin($username, $password);
				if(!empty($resultMembre))
				{
					$_SESSION['connected_user_id'] = $resultMembre->prop('id');
					$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);
					\Eliya\Tpl::set(['current_member' => $this->_current_member]);
					
					$view	=	\Eliya\Tpl::get('login/alreadyLogged', $_SESSION);
				}
				else
				{
					$view = \Eliya\Tpl::get('login/index');
				}
			}
			else
			{
				$view = 'Erreur &bull; Le formulaire de connexion n\'a pas, ou a mal, été envoyé et/ou rempli. Veuillez réessayer.';
			}
			
			$this->response->set($view);
		}
	}