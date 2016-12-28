<?php
	class Controller_spritecomics_edit_comment extends Controller_main
	{
		public function update_index($id = null, $content = null)
		{
			$redirect_url = $this->request->getBaseURL().'spritecomics/gallery/';

			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
			
			$comment = Model_Comments::getById($id);

			if(empty($comment))
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.comment.errors.not_found_in_db'), 404);
				return;
			}
			
			if(empty($content))
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.comment.errors.empty_edit'), 404);
				return;
			}
			
			$file = $comment->getFile();

			$owner						=	$comment->getUser();

			$can_remove_other_comments	=	$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_COMMENTS);

			if( ! $this->_current_member->equals($owner) && ! $can_remove_other_comments)
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.comment.errors.forbidden'), 403);
				return;
			}
			
			$comment->prop('content', $content);
			$comment->getUser();
			Model_Comments::update($comment);
			
			$redirect_url .= 'details/'.$file->getId();

			Library_Messages::store(Library_i18n::get('spritecomics.edit.comment.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}