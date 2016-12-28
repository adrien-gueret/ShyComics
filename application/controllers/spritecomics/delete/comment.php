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

			$owner						=	$file->getUser();
			$can_remove_other_comments	=	$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_COMMENTS);

			if( ! $this->_current_member->equals($owner) && ! $can_remove_other_comments)
			{
				$this->response->error(Library_i18n::get('spritecomics.delete.comment.errors.forbidden'), 403);
				return;
			}
			
			//Not forget to update the feed for followers
			$request = Model_Feed::createRequest();
			$feeds = $request->where('author.id=? AND object=? AND type=?', [$this->getId(), $file->getId(), Model_Feed::OBJECT_IS_A_COMMENTARY])
                               ->getOnly(1)
							   ->exec();
            
            foreach($feeds as $feed)
					Model_Feed::delete($feed);
			
			Model_Comments::delete($comment);
			
			$redirect_url .= 'details/'.$file->getId();

			Library_Messages::store(Library_i18n::get('spritecomics.delete.comment.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}