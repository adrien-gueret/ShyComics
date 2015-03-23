<?php
	class Controller_profile_modify extends Controller_index
	{
		use Trait_checkIdUser;

		public function get_index()
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('profile.modify.page_title'),
				'page_description'	=>	Library_i18n::get('profile.modify.page_description'),
			]);
			
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
		
		public function post_index()
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
			
			if( ! isset($_FILES['avatar']) || $_FILES['avatar']['error'] != 0)
			{
				Library_Messages::add(Library_i18n::get('profile.modify.avatar.errors.bad_upload'));
				return false;
			}

			switch($this->_current_member->changeAvatar($_FILES['avatar']))
			{
				case Model_Files::ERROR_SIZE:
					Library_Messages::add(Library_i18n::get('profile.modify.avatar.errors.file_too_big'));
				break;

				case Model_Files::ERROR_TYPE:
					Library_Messages::add(Library_i18n::get('profile.modify.avatar.errors.bad_type'));
				break;

				case Model_Files::ERROR_SAVE:
					Library_Messages::add(Library_i18n::get('profile.modify.avatar.errors.unknown'));
				break;

				case Model_Files::PROCESS_OK:
					Library_Messages::add(Library_i18n::get('profile.modify.avatar.success'), Library_Messages::TYPE_SUCCESS);
				break;
			}

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('profile.modify.page_title'),
				'page_description'	=>	Library_i18n::get('profile.modify.page_description'),
			]);
			
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
	}