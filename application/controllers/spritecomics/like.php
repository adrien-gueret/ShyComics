<?php
	class Controller_spritecomics_like extends Controller_main
	{
		public function post_index($id_file)
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			$file = Model_Files::getById($id_file);
			
			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.like.errors.not_found'), 404);
				return;
			}

			switch($this->_current_member->like($file))
			{
				case Model_Users::ERROR_LIKE_ALREADY_LIKE:
					Library_Messages::store(Library_i18n::get('spritecomics.like.errors.already_like'));
				break;

				case Model_Users::ERROR_LIKE_USER_IS_OWNER:
					Library_Messages::store(Library_i18n::get('spritecomics.like.errors.own_file'));
				break;

				case Model_Users::LIKE_SUCCESS:
					Library_Messages::store(Library_i18n::get('spritecomics.like.success'), Library_Messages::TYPE_SUCCESS);
				break;
			}

			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();
			$this->response->redirect($redirect_url);
		}
	}