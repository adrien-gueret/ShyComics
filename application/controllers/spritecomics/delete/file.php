<?php
	class Controller_spritecomics_delete_file extends Controller_main
	{
		public function delete_index($id = null)
		{
			$file			=	null;
			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/';

			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			$file	=	Model_Files::getById($id);

			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.not_found_in_db'), 404);
				return;
			}

			$parent_id	=	$file->getParentFileId();

			$owner						=	$file->getUser();
			$can_remove_others_files	=	$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_FILES);

			if( ! $this->_current_member->equals($owner) && ! $can_remove_others_files)
			{
				$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.forbidden'), 403);
				return;
			}

			$file->unlink();

			if(empty($parent_id))
				$redirect_url	.=	''.$owner->getId();
			else
				$redirect_url	.=	'details/'.$parent_id;

			Library_Messages::store(Library_i18n::get('spritecomics.delete.file.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}