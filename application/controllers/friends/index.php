<?php
	class Controller_friends_index extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Gestion des amis',
			]);
			
			if(isset($_SESSION['connected_user_id']) AND !empty($_SESSION['connected_user_id']))
			{
				$member = Model_Users::getById($_SESSION['connected_user_id']);
				$data = [
					'user_friends'		=> $member->prop('friends'),
				];
				
				if($data['user_friends']->isEmpty())
				{
					$arrayInfo = [
						'infos_message' => 'Vous n\'avez aucun ami !',
						'infos_message_status' => 'class="message infos"',
					];
					$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
					$data['infos_message'] = $infos_message;
					
					$view = \Eliya\Tpl::get('friends/error', $data);
				}
				else
				{
					$view = \Eliya\Tpl::get('friends/index', $data);
				}
			}
			else
			{
				$arrayInfo = [
					'infos_message' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CONTENT'],
					'infos_message_status' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CLASS'],
				];
				$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
				$data['infos_message'] = $infos_message;
				
				$view = \Eliya\Tpl::get('friends/error', $data);
			}
			
			$this->response->set($view);
		}
	}