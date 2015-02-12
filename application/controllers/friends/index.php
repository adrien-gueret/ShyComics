<?php
	class Controller_friends_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Gestion des amis',
			]);
			
			if(isset($_SESSION['connected_user_id']) AND !empty($_SESSION['connected_user_id']))
			{
				if($this->_current_member->prop('friends')->isEmpty())
				{
					$arrayInfo = [
						'infos_message' => 'Vous n\'avez aucun ami !',
						'infos_message_status' => 'class="message infos"',
					];

					$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
					$view = $infos_message;
				}
				else
				{
					$view = \Eliya\Tpl::get('friends/index');
				}
			}
			else
			{
				$arrayInfo = [
					'infos_message' => \Eliya\Config('messages')->ERRORS['LOGIN']['CONTENT'],
					'infos_message_status' => \Eliya\Config('messages')->ERRORS['LOGIN']['CLASS'],
				];

				$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
				$view = $infos_message;
			}
			
			$this->response->set($view);
		}
	}