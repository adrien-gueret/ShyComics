<?php
	class Controller_friends_index extends Controller_main
	{
		public function get_index()
		{
			if( ! $this->_current_member->isConnected()) {
				$this->response->error('Vous devez être connecté pour accéder à cette partie du site.', 401);
				return;
			}

			\Eliya\Tpl::set([
				'page_title'	=>	'Gestion des amis',
			]);

			if($this->_current_member->prop('friends')->isEmpty())
			{
				Library_Messages::add('Vous n\'avez aucun ami !', Library_Messages::TYPE_WARNING);
				$view	=	\Eliya\Tpl::get('friends/no_friends');
			}
			else
			{
				$view = \Eliya\Tpl::get('friends/index');
			}

			$this->response->set($view);
		}
	}