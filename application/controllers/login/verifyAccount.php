<?php
	class Controller_login_verifyAccount extends Controller_main
	{
		public function get_index($m = null, $h = null)
		{
			if($this->_current_member->isConnected())
				$this->_redirectToCurrentMemberProfile();

			if(empty($m) || empty($h))
			{
				$this->response->error(Library_i18n::get('login.verify_account.errors.empty_data'), 400);
				return;
			}

			if( ! filter_var($m, FILTER_VALIDATE_EMAIL))
			{
				$this->response->error(Library_i18n::get('login.verify_account.errors.bad_data'), 400);
				return;
			}

			$member = Model_Users::getByEmail($m);

			if(empty($member)) {
				$this->response->error(Library_i18n::get('login.verify_account.errors.not_found'), 404);
				return;
			}

			$hashVerif = Library_String::hash($member->prop('email').$member->prop('username'));

			if($hashVerif !== $h) {
				$this->response->error(Library_i18n::get('login.verify_account.errors.cant_valid'), 400);
				return;
			}

			// All is OK, we can mark user as verified
			$id = $member->getId();
			Model_Users::emailVerified($id);

			// And we auto-connect him :)
			$_SESSION['connected_user_id'] = $member->prop('id');
			$this->_current_member = $member;

			Library_Messages::store(Library_i18n::get('login.verify_account.success'), Library_Messages::TYPE_SUCCESS);
			$this->_redirectToCurrentMemberProfile();
		}
	}