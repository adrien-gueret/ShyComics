<?php
	class Controller_friends_index extends Controller_main
	{
		public function get_index()
		{
			if( ! $this->_current_member->isConnected()) {
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('friends.page_title'),
				'page_description'	=>	Library_i18n::get('friends.page_description'),
			]);

			if($this->_current_member->prop('friends')->isEmpty())
			{
				Library_Messages::add(Library_i18n::get('friends.no_friends.flash_message'), Library_Messages::TYPE_WARNING);
				$view	=	\Eliya\Tpl::get('friends/no_friends');
			}
			else
			{
				$view = \Eliya\Tpl::get('friends/index');
			}

			$this->response->set($view);
		}
	}