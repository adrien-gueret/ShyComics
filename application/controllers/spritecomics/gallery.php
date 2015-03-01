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

			if($this->_current_member->isConnected())
				$is_own_gallery	=	$this->_current_member->equals($member);

			\Eliya\Tpl::set([
				'page_title'		=>	'Galerie de ' . $member->prop('username'),
			]);

			$this->response->set(Library_Gallery::getFolderTemplate($member, null, $is_own_gallery));
		}

		public function post_index($name = null, $description = null, $parent_file_id = null, $is_dir = 1)
		{
			if( ! $this->_current_member->isConnected())
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

				Library_Messages::store('Le document a bien été ajouté !', Library_Messages::TYPE_SUCCESS);

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
			$has_liked = false;
			
			if($this->_current_member->isConnected())
				$is_own_gallery	=	$this->_current_member->equals($owner);
				$has_liked = Model_Likes::hasLiked($this->_current_member, $document);
			}

			if($document->prop('is_dir') == 1)
				$template	=	Library_Gallery::getFolderTemplate($owner, $document->getId(), $is_own_gallery);
			else
			{
				$tpl_delete	=	null;
				$tpl_like	=	null;
				$can_remove_other_files	=	$this->_current_member->isConnected() &&
											$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_FILES);

				if($is_own_gallery || $can_remove_other_files)
					$tpl_delete	=	\Eliya\Tpl::get('spritecomics/gallery/delete', ['id_to_delete' => $document->getId()]);
				if($this->_current_member->isConnected() AND !$this->_current_member->equals($owner))
					$tpl_like = \Eliya\Tpl::get('spritecomics/gallery/details/like', $data);

				// @TODO : display a better view for SCs
				$data = [
					'file'				=>	$document,
					'is_own_gallery'	=>	$is_own_gallery,
					'has_liked'			=>	$has_liked,
					'file'			=>	$document,
					'tpl_delete'	=>	$tpl_delete,
					'tpl_like'	=>	$tpl_like,
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
					$upload_error	=	false;
				break;
			}

			return ! $upload_error;
		}
	}