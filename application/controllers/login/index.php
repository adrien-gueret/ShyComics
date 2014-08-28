<?php
	class Controller_login_index extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Se connecter',
			]);
			
			if(isset($_SESSION['connected_user_id']))
				$view	=	\Eliya\Tpl::get('login/alreadyLogged');
			else
				$view	=	\Eliya\Tpl::get('login/index');
			
			$this->response->set($view);
		}
		
		public function post_index($username = null, $password = null)
		{
			if(!empty($username) && !empty($password))
			{
				$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
				$password = htmlspecialchars($password, ENT_QUOTES, 'utf-8');
				$password = Library_String::hash($password);
				
				$resultMembre = Model_Users::getForLogin($username, $password);
				
				if($resultMembre !== null)
				{
					$_SESSION['connected_user_id'] = $resultMembre->prop('id');
					$_SESSION['connected_user_username'] = $resultMembre->prop('username');
					
					$view	=	\Eliya\Tpl::get('login/alreadyLogged');
					$this->response->set($view);
				}
			}
		}
	}