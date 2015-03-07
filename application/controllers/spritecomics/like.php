<?php
	class Controller_spritecomics_like extends Controller_main
	{
		public function post_index($id_file)
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error('Vous devez être connecté pour accéder à cette partie du site.', 401);
				return;
			}

			$file = Model_Files::getById(intval($id_file));
			
			if(empty($file))
			{
				$this->response->error('La planche que vous cherchez à aimer est introuvable.', 404);
				return;
			}

			switch($this->_current_member->like($file))
			{
				case Model_Users::ERROR_LIKE_ALREADY_LIKE:
					Library_Messages::store('Vous avez déjà aimé cette planche.');
				break;

				case Model_Users::ERROR_LIKE_USER_IS_OWNER:
					Library_Messages::store('Vous ne pouvez pas aimer vos propres planches.');
				break;

				case Model_Users::LIKE_SUCCESS:
					Library_Messages::store('Le like a bien été envoyé.', Library_Messages::TYPE_SUCCESS);
				break;
			}

			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();
			$this->response->redirect($redirect_url);
		}
	}