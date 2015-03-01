<?php
	class Controller_spritecomics_like extends Controller_main
	{
		use Trait_checkIdUser;

		public function post_index($id_file)
		{
			$file = Model_Files::getById(intval($id_file));
			
			if(empty($file))
				return $this->response->error('La page que vous cherchez à aimer est introuvable.', 404);
			
			$owner	=	$file->getUser();

			$redirect_url	=	$this->request->getBaseURL().'spritecomics/gallery/details/' . $file->getId();

			switch(Model_Files::addLike($this->_current_member, $file))
			{
				case Model_Files::LIKE_PROCESS_OK;
					Library_Messages::store('Le like a bien été envoyé.', Library_Messages::TYPE_SUCCESS);
					$this->response->redirect($redirect_url);
				break;
				
				case Model_Files::LIKE_ERROR_CONNECTED_USER;
					$this->response->error('Vous devez être connecté pour effectuer cette action.', 401);
				break;
				
				case Model_Files::LIKE_ERROR_SAME_USER;
					$this->response->error('Vous ne pouvez pas mettre de like à une de vos images.', 401);
				break;
				
				case Model_Files::LIKE_ERROR_FILE;
					$this->response->error('La page que vous cherchez à aimer est introuvable.', 404);
				break;
				
				case Model_Files::LIKE_ERROR_ALREADY;
					Library_Messages::store('Vous avez déjà liké cette page.', Library_Messages::TYPE_WARNING);
					$this->response->redirect($redirect_url);
				break;
			}
		}
	}