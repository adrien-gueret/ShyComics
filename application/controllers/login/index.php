<?php
	class Controller_login_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('login.index.page_title'),
				'page_description'	=>	Library_i18n::get('login.index.page_description'),
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
					if(!$resultMember->prop('is_banned'))
					{
						$_SESSION['connected_user_id'] = $resultMember->prop('id');
						$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);

                        Library_i18n::defineLocale($this->_current_member);
						Library_Messages::store(Library_i18n::get('login.success', $resultMember->prop('username')), Library_Messages::TYPE_SUCCESS);

						$this->_redirectToCurrentMemberProfile();
					}
					else
					{
						Library_Messages::add(Library_i18n::get('login.errors.banned'), Library_Messages::TYPE_ERROR);
					}
				}
				else
				{
					Library_Messages::add(Library_i18n::get('login.errors.bad_credentials'), Library_Messages::TYPE_ERROR);
				}
			}
			else
			{
				Library_Messages::add(Library_i18n::get('login.errors.empty_fields'), Library_Messages::TYPE_WARNING);
			}

			$this->response->set(\Eliya\Tpl::get('login/index'));
		}
	}