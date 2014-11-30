<?php
	class Controller_spritecomics_gallery extends Controller_index
	{
		public function get_index($id_user = null)
		{
			$member = Model_Users::getById($id_user);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($member))
			{
				$data = [
					'user_id'		=> $member->prop('id'),
					'user_name'		=> $member->prop('username'),
					'user_files'	=> $member->getFiles(),
					'user_dirs'	    => $member->getFilesDirs(),
					'user_dirs_all'	=> $member->getFilesDirsAll(),
				];
			}
			else
			{
				$data = [
					'user_id'		=> null,
					'user_name'		=> null,
					'user_files'	=> null,
					'user_dirs'	    => null,
					'user_dirs_all'	=> null,
				];
			}
			
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
				$member = Model_Users::getById($file->prop('id_user'));
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