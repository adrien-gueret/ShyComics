<?php
	class Controller_spritecomics_delete extends Controller_main
	{
		public function delete_index($id = null)
		{
			$file			=	null;
			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/';

			try
			{
				if( ! $this->_current_member->isConnected())
					throw new RedirectException(Library_i18n::get('errors.global.need_connection'), 401);

				$file	=	Model_Files::getById($id);

				if(empty($file))
					throw new RedirectException(Library_i18n::get('spritecomics.delete.errors.not_found_in_db'), 404);

				$owner						=	$file->getUser();
				$can_remove_others_files	=	$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_FILES);

				if( ! $this->_current_member->equals($owner) && ! $can_remove_others_files)
					throw new RedirectException(Library_i18n::get('spritecomics.delete.errors.forbidden'), 403);

				$file->unlink();

				$parent_id	=	$file->getParentFileId();

				if(empty($parent_id))
					$redirect_url	.=	''.$owner->getId();
				else
					$redirect_url	.=	'details/'.$parent_id;

				Library_Messages::store(Library_i18n::get('spritecomics.delete.success'), Library_Messages::TYPE_SUCCESS);
				$this->response->redirect($redirect_url, 200);
			}
			catch (RedirectException $e)
			{
				$this->response->error($e->getMessage(), $e->getCode());
			}
			catch (Exception $e)
			{
				Library_Messages::store($e->getMessage());

				$redirect_url	.=	'details/';

				if( ! empty($file))
					$redirect_url	.=	$file->getId();

				$this->response->redirect($redirect_url, $e->getCode());
				exit;
			}
		}
	}