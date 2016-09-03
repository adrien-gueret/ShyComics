<?php
	class Controller_spritecomics_edit_description extends Controller_main
	{
		public function update_index($id = null, $content = null)
		{
			$redirect_url = $this->request->getBaseURL().'spritecomics/gallery/';

			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
			
			$file = Model_Files::getById($id);

			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.file.errors.not_found_in_db'), 404);
				return;
			}

			$owner			=	$file->getUser();
			$can_edit_desc	=	$this->_current_member->can(Model_UsersGroups::PERM_EDIT_OTHERS_DESCS);

			if( ! $this->_current_member->equals($owner) && ! $can_edit_desc)
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.file.errors.forbidden'), 403);
				return;
			}
			
			$file->prop('description', $content);
			$file->getParentFile();
			Model_Files::update($file);
			
			$redirect_url .= 'details/'.$file->getId();

			Library_Messages::store(Library_i18n::get('spritecomics.edit.file.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}