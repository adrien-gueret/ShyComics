<?php
	class Controller_spritecomics_unlike extends Controller_main
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

			switch($this->_current_member->unlike($file))
			{
				case Model_Users::ERROR_LIKE_DOES_NOT_EXIST:
					Library_Messages::store(Library_i18n::get('spritecomics.like.unlike.error'));
				break;

				case Model_Users::UNLIKE_SUCCESS:
					Library_Messages::store(Library_i18n::get('spritecomics.like.unlike.success'), Library_Messages::TYPE_SUCCESS);
				break;
			}

			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();
			$this->response->redirect($redirect_url);
		}
	}