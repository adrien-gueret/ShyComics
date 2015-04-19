<?php
	class Controller_follows_index extends Controller_main
	{
		public function get_index()
		{
			if( ! $this->_current_member->isConnected()) {
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('follows.page_title'),
				'page_description'	=>	Library_i18n::get('follows.page_description'),
			]);

			if($this->_current_member->prop('follows')->isEmpty())
			{
				Library_Messages::add(Library_i18n::get('follows.no_follows.flash_message'), Library_Messages::TYPE_WARNING);
				$view	=	\Eliya\Tpl::get('follows/no_follows');
			}
			else
			{
				$view = \Eliya\Tpl::get('follows/index');
			}

			$this->response->set($view);
		}
	}