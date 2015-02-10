<?php
	class Controller_profile_gestion extends Controller_index
	{
		public function get_index()
		{
			if(!empty($this->_current_member))
			{
				\Eliya\Tpl::set([
					'page_title'		=>	'Gestion de votre profil',
				]);
			
				$view	=	\Eliya\Tpl::get('profile/gestion');
			}
			else
			{
				$arrayInfo = [
					'infos_message' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CONTENT'],
					'infos_message_status' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CLASS'],
				];
				
				$view = \Eliya\Tpl::get('infos_message', $arrayInfo);
			}
			$this->response->set($view);
		}
	}