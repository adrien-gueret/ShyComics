<?php
	class Controller_login_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Se connecter',
			]);

			if($this->_current_member->isConnected())
				$this->_redirectToCurrentMemberProfile();
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
				
				$resultMember = Model_Users::getForLogin($username, $password);

				if(!empty($resultMember))
				{
					$_SESSION['connected_user_id'] = $resultMember->prop('id');
					$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);

					Library_Messages::store('Bon retour parmi nous '.$resultMember->prop('username').' !', Library_Messages::TYPE_SUCCESS);

					$this->_redirectToCurrentMemberProfile('login');
					exit;
				}

				Library_Messages::add('Vos informations de connexion sont incorrectes.');
			}
			else
			{
				Library_Messages::add('Veuillez renseigner tous les champs du formulaire.');
			}

			$this->response->set(\Eliya\Tpl::get('login/index'));
		}
	}