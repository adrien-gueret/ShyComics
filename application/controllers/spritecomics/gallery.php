<?php
	class Controller_spritecomics_gallery extends Controller_main
	{
		public function get_index($id_user = null)
		{
			//If users is on /spritecomics/gallery (no id member)
			if(empty($id_user))
			{
				//We redirect him!
				$baseUrl	=	$this->request->getBaseURL() . 'spritecomics/';

				if( ! empty($this->_current_member))
					$this->response->redirect($baseUrl . 'gallery/' . $this->_current_member->getId());
				else
					$this->response->redirect($baseUrl);

				exit;
			}

			$member = Model_Users::getById($id_user);

			if(empty($member))
			{
				$this->response->error('Le membre souhaité ne semble pas exister.', 404);
				return;
			}

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
				if($file->prop('is_dir') == 0)
				{
					if(!empty($member))
					{
						$data = [
							'user_id'		=> $member->prop('id'),
							'user_name'		=> $member->prop('username'),
							'file'			=> $file,
						];
					}
					else
					{
						$data = [
							'user_id'		=> null,
							'user_name'		=> null,
							'file'			=> null,
						];
					}
				}
				else
				{
					if(!empty($member))
					{
						$data = [
							'user_id'		=> $member->prop('id'),
							'user_name'		=> $member->prop('username'),
							'user_files'	=> $member->getFiles($file->prop('id')),
						];
					}
					else
					{
						$data = [
							'user_id'		=> null,
							'user_name'		=> null,
							'user_files'	=> null,
						];
					}
				}
			}
			else
			{
				$arrayInfo = [
					'infos_message' => 'Cette image/ce dossier n\'existe pas.',
					'infos_message_status' => 'class="message infos error"',
				];
				$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
				$data['infos_message'] = $infos_message;
			}
			$view	=	\Eliya\Tpl::get('spritecomics/gallery/file', $data);
			$this->response->set($view);
		}
	}