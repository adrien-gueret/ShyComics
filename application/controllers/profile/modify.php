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
			$arrayBirth = explode('-', $this->_current_member->prop('birthdate'));
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
				'tpl_form_pass' => \Eliya\Tpl::get('profile/form_pass'),
				'tpl_form_about' => \Eliya\Tpl::get('profile/form_about', [
					'user_about' => $this->_current_member->prop('about'),
					'user_sexe' => $this->_current_member->prop('sexe'),
					'user_interest' => $this->_current_member->prop('interest'),
					'year_now' => date('Y'),
					'user_YOB' => $arrayBirth[0],
					'user_MOB' => $arrayBirth[1],
					'user_DOB' => $arrayBirth[2],
					'tpl_buttons' => Library_Parser::getButtons($this->request->getBaseURL(), 'content-about')
				]),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
		
		public function post_avatar()
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
			
			$arrayBirth = explode('-', $this->_current_member->prop('birthdate'));
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
				'tpl_form_pass' => \Eliya\Tpl::get('profile/form_pass'),
				'tpl_form_about' => \Eliya\Tpl::get('profile/form_about', [
					'user_about' => $this->_current_member->prop('about'),
					'user_sexe' => $this->_current_member->prop('sexe'),
					'user_interest' => $this->_current_member->prop('interest'),
					'year_now' => date('Y'),
					'user_YOB' => $arrayBirth[0],
					'user_MOB' => $arrayBirth[1],
					'user_DOB' => $arrayBirth[2],
					'tpl_buttons' => Library_Parser::getButtons($this->request->getBaseURL(), 'content-about')
				]),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
		
		public function post_about($content, $DOB, $MOB, $YOB, $sexe, $interest)
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
			
			switch($this->_current_member->updateAbout($content, $YOB, $MOB, $DOB, $sexe, $interest))
			{
				case Model_Files::PROCESS_OK:
					Library_Messages::add(Library_i18n::get('profile.modify.about.success'), Library_Messages::TYPE_SUCCESS);
				break;
			}
            
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('profile.modify.page_title'),
				'page_description'	=>	Library_i18n::get('profile.modify.page_description'),
			]);
			
			$arrayBirth = explode('-', $this->_current_member->prop('birthdate'));
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
				'tpl_form_pass' => \Eliya\Tpl::get('profile/form_pass'),
				'tpl_form_about' => \Eliya\Tpl::get('profile/form_about', [
					'user_about' => $this->_current_member->prop('about'),
					'user_sexe' => $this->_current_member->prop('sexe'),
					'user_interest' => $this->_current_member->prop('interest'),
					'year_now' => date('Y'),
					'user_YOB' => $arrayBirth[0],
					'user_MOB' => $arrayBirth[1],
					'user_DOB' => $arrayBirth[2],
					'tpl_buttons' => Library_Parser::getButtons($this->request->getBaseURL(), 'content-about')
				]),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
		
		public function post_pass($pass_actual, $pass_new, $pass_confirm)
		{
            if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
            
			switch($this->_current_member->updatePassword($pass_actual, $pass_new, $pass_confirm))
			{
				case Model_Files::PROCESS_OK:
					Library_Messages::add(Library_i18n::get('profile.modify.pass.success'), Library_Messages::TYPE_SUCCESS);
				break;
                
				case Model_Files::ERROR_SAVE:
					Library_Messages::add(Library_i18n::get('profile.modify.pass.error'), Library_Messages::TYPE_ERROR);
				break;
			}
            
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('profile.modify.page_title'),
				'page_description'	=>	Library_i18n::get('profile.modify.page_description'),
			]);
			
			$arrayBirth = explode('-', $this->_current_member->prop('birthdate'));
			$data = [
				'avatarURL' => $this->_current_member->getAvatarURL(),
				'tpl_form_avatar' => \Eliya\Tpl::get('profile/form_avatar'),
				'tpl_form_pass' => \Eliya\Tpl::get('profile/form_pass'),
				'tpl_form_about' => \Eliya\Tpl::get('profile/form_about', [
					'user_about' => $this->_current_member->prop('about'),
					'user_sexe' => $this->_current_member->prop('sexe'),
					'user_interest' => $this->_current_member->prop('interest'),
					'year_now' => date('Y'),
					'user_YOB' => $arrayBirth[0],
					'user_MOB' => $arrayBirth[1],
					'user_DOB' => $arrayBirth[2],
					'tpl_buttons' => Library_Parser::getButtons($this->request->getBaseURL(), 'content-about')
				]),
			];
			
			$view	=	\Eliya\Tpl::get('profile/modify', $data);
			$this->response->set($view);
		}
	}