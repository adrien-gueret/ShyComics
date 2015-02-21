<?php
	class Controller_spritecomics_gallery extends Controller_main
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null)
		{
			$member	=	$this->_getMemberFromId($id_user, 'spritecomics/gallery/');

			if(empty($member))
				return;

			$is_own_gallery	=	false;

			if( ! empty($this->_current_member))
				$is_own_gallery	=	$this->_current_member->equals($member);

			\Eliya\Tpl::set([
				'page_title'		=>	'Galerie de ' . $member->prop('username'),
			]);

			$this->response->set(Library_Gallery::getFolderTemplate($member, null, $is_own_gallery));
		}

		public function post_index($name = null, $description = null, $parent_file_id = null, $is_dir = 1)
		{
			if(empty($this->_current_member))
			{
				$this->response->error('Vous devez être connecté pour effectuer cette action.', 401);
				return;
			}

			$parent	=	null;

			if( ! empty($parent_file_id))
			{
				$parent	=	Model_Files::getById($parent_file_id);

				if(empty($parent))
				{
					$this->response->error('Le dossier où créer le nouveau document ne semble pas exister.', 404);
					return;
				}

				$parent_owner	=	$parent->getUser();

				if( ! $this->_current_member->equals($parent_owner))
				{
					$this->response->error('Vous ne pouvez pas ajouter du contenu dans ce dossier.', 403);
					return;
				}
			}

			$success	=	false;

			if(empty($name))
				Library_Messages::add('Veuillez indiquer un nom à votre document.');
			else
			{
				if($is_dir)
				{
					Model_Files::addFolder($this->_current_member, $name, $description, $parent);
					$success	=	true;
				}
				else
					$success	=	$this->_newFile($name, $description, $parent);
			}

			if( ! $success)
			{
				if(empty($parent_file_id))
					$this->get_index();
				else
					$this->get_details($parent_file_id);
			}
			else
			{
				$url	=	$this->request->getBaseURL().'spritecomics/gallery/';

				if( ! empty($parent_file_id))
					$url	.=	'details/'.$parent_file_id;

				$this->response->redirect($url);
			}
		}

		public function get_details($id_document = null)
		{
			$document = Model_Files::getById($id_document);

			if(empty($document))
			{
				$this->response->error('Ce document n\'existe pas.', 404);
				return;
			}

			\Eliya\Tpl::set([
				'page_title'	=>	$document->prop('name') ?: 'Galerie',
			]);

			$owner	=	$document->getUser();

			$is_own_gallery	=	false;

			if( ! empty($this->_current_member))
				$is_own_gallery	=	$this->_current_member->equals($owner);

			if($document->prop('is_dir') == 1)
				$template	=	Library_Gallery::getFolderTemplate($owner, $document->getId(), $is_own_gallery);
			else
			{
				// @TODO : display a better view for SCs
				$data = [
					'file'				=>	$document,
					'is_own_gallery'	=>	$is_own_gallery,
				];

				$template	=	\Eliya\Tpl::get('spritecomics/gallery/details/file', $data);
			}


			$this->response->set($template);
		}

		protected function _newFile($name, $description = null, Model_Files $parent = null)
		{
			$upload_error	=	true;

			switch(Model_Files::addFile($this->_current_member, $name, $description, $parent))
			{
				case Model_Files::ERROR_SIZE:
					Library_Messages::add('Le fichier est trop gros : il dépasse la limite de taille imposée.');
				break;

				case Model_Files::ERROR_UPLOAD:
					Library_Messages::add('Le fichier n\'a pas été uploadé correctement sur notre serveur.');
				break;

				case Model_Files::ERROR_TYPE:
					Library_Messages::add('Le fichier n\'a pas été enregistré car son type n\'est pas autorisé.');
					break;

				case Model_Files::ERROR_SAVE:
					Library_Messages::add('Une erreur inconnue est survenue lors de la sauvegarde du fichier.');
					break;

				case Model_Files::PROCESS_OK:
					Library_Messages::store('Le fichier a bien été enregistré !', Library_Messages::TYPE_SUCCESS);
					$upload_error	=	false;
				break;
			}

			return ! $upload_error;
		}
	}