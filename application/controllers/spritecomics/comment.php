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

			$file = Model_Files::getById($id_file);
			
			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.comment.errors.not_found'), 404);
				return;
			}

			$comment = new Model_Comments($this->_current_member, $content, $file);
			Model_Comments::add($comment);

			//Not forget to update the feed for followers
			$feed = new Model_Feed($this->_current_member, $id_file, 2);
			Model_Feed::add($feed);
			
			Library_Messages::store(Library_i18n::get('spritecomics.gallery.comments.success'), Library_Messages::TYPE_SUCCESS);
			
			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();
			$this->response->redirect($redirect_url);
		}
	}