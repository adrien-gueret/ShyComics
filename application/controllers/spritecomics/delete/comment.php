<?php
	class Controller_spritecomics_delete_comment extends Controller_main
	{
		public function delete_index($id = null)
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
				$this->response->error(Library_i18n::get('spritecomics.delete.comment.errors.not_found_in_db'), 404);
				return;
			}
			
			$file = $comment->getFile();

			$owner						=	$comment->getUser();
			$can_remove_other_comments	=	$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_COMMENTS);

			if( ! $this->_current_member->equals($owner) && ! $can_remove_other_comments)
			{
				$this->response->error(Library_i18n::get('spritecomics.delete.comment.errors.forbidden'), 403);
				return;
			}
			
			Model_Comments::delete($comment);
			
			$redirect_url .= 'details/'.$file->getId();

			Library_Messages::store(Library_i18n::get('spritecomics.delete.comment.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}