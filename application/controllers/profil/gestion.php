<?php
	class Controller_profil_gestion extends Controller_index
	{
		public function get_index()
		{
			if(!empty($this->_current_member))
			{
				\Eliya\Tpl::set([
					'page_title'		=>	'Gestion de votre profil',
				]);
			
				$view	=	\Eliya\Tpl::get('profil/gestion');
			}
			else
			{
				$arrayInfo = [
					'infos_message' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CONTENT'],
					'infos_message_status' => \Eliya\Config('messages')->MESSAGE_ERROR_LOGIN['CLASS'],
				];

				$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
				$view = $infos_message;
			}
			$this->response->set($view);
		}
	}