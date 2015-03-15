<?php
	class Controller_spritecomics_comment extends Controller_main
	{
		public function post_index($id_file, $content)
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			$file = Model_Files::getById(intval($id_file));
			
			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.comment.errors.not_found'), 404);
				return;
			}

			$comment = new Model_Comments($this->_current_member, htmlspecialchars($content), $file);
			Model_Comments::add($comment);

			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();
			$this->response->redirect($redirect_url);
		}
	}