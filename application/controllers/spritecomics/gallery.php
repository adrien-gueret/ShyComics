<?php
	class Controller_spritecomics_gallery extends Controller_main
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null)
		{
			$member	=	$this->_getMemberFromId($id_user, 'spritecomics/gallery/');

			if(empty($member))
				return;

			\Eliya\Tpl::set([
				'page_title'		=>	'Galerie de ' . $member->prop('username'),
			]);

			$data = [
				'user_id'		=> $member->prop('id'),
				'user_name'		=> $member->prop('username'),
				'user_files'	=> $member->getFiles(),
				'user_dirs'	    => $member->getFilesDirs(),
				'user_dirs_all'	=> $member->getFilesDirsAll(),
			];

			$view	=	\Eliya\Tpl::get('spritecomics/gallery', $data);
			$this->response->set($view);
		}
		
		public function get_file($id_file = null)
		{
			$file = Model_Files::getById($id_file);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($file))
			{
				$member = $file->getUser();
				$parentFileId = $file->getParentFileId();
				if( ! empty($parentFileId))
				{
					// If parent file exist, we stock its direction into a variable
					$parent_url = 'file/' . $parentFileId;
				}
				else
				{
					// Else, we stock direction to the user's gallery
					$parent_url = $member->getId();
				}
				
				if($file->prop('is_dir') == 0)
				{
					$data = [
						'user_id'		=> $member->prop('id'),
						'user_name'		=> $member->prop('username'),
						'file'			=> $file,
						'parent_url'	=> $parent_url,
					];
					
					$view	=	\Eliya\Tpl::get('spritecomics/gallery/file', $data);
				}
				else
				{
					$memberFiles = $member->getFiles($file->prop('id'));
					if( ! empty($memberFiles))
					{
						$data = [
							'user_id'		=> $member->getId(),
							'user_name'		=> $member->prop('username'),
							'user_files'	=> $member->getFiles($file->getId()),
							'parent_url'	=> $parent_url,
						];
						
						$view	=	\Eliya\Tpl::get('spritecomics/gallery/document', $data);
					}
					else
					{
						$arrayInfo = [
							'infos_message' => 'Ce dossier ne contient aucun fichier.<br /><a href="' . $this->request->getBaseURL() . 'spritecomics/gallery/' . $parent_url . '">Remonter la galerie</a>',
							'infos_message_status' => 'class="message infos"',
						];
						
						$view = \Eliya\Tpl::get('infos_message', $arrayInfo);
					}
				}
			}
			else
			{
				$this->response->error('Cette image/ce dossier n\'existe pas.', 404);
				return;
			}
			$this->response->set($view);
		}
	}