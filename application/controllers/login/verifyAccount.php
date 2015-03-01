<?php
	class Controller_login_verifyAccount extends Controller_main
	{
		public function get_index($m = null, $h = null)
		{
			if($this->_current_member->isConnected())
				$this->_redirectToCurrentMemberProfile();

			if(empty($m) || empty($h))
			{
				$this->response->error('Des informations sont manquantes pour accéder à cette page.', 400);
				return;
			}

			if( ! filter_var($m, FILTER_VALIDATE_EMAIL))
			{
				$this->response->error('Les données reçues sont incorrectes.', 400);
				return;
			}

			$member = Model_Users::getByEmail($m);

			if(empty($member)) {
				$this->response->error('Le membre à valider n\'a pas été trouvé.', 404);
				return;
			}

			$hashVerif = Library_String::hash($member->prop('email').$member->prop('username'));

			if($hashVerif !== $h) {
				$this->response->error('Impossible de valider le compte.', 400);
				return;
			}

			// All is OK, we can mark user as verified
			$id = $member->getId();
			Model_Users::emailVerified($id);

			// And we auto-connect him :)
			$_SESSION['connected_user_id'] = $member->prop('id');
			$this->_current_member = $member;

			Library_Messages::store('Votre compte a été validé avec succès !<br />Notez que cela vous a connecté automatiquement.', Library_Messages::TYPE_SUCCESS);
			$this->_redirectToCurrentMemberProfile();
		}
	}