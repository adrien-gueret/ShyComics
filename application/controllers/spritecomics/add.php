<?php
	class Controller_spritecomics_add extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function post_index($name = null, $description = null, $parent_file = null)
		{
			$return = Model_Files::addFile($name, $description, $parent_file);
			
			if($return == 0)
			{
				$member = Model_Users::getById($_SESSION['connected_user_id']);
				
				\Eliya\Tpl::set([
					'page_title'		=>	'Sprites Comics &bull; Galerie',
				]);
				
				if(!empty($member))
				{
					$data = [
						'user_id'		=> $member->prop('id'),
						'user_name'		=> $member->prop('username'),
						'user_files'	=> $member->getFiles(),
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
				
				$view	=	\Eliya\Tpl::get('spritecomics/gallery', $data);
				$this->response->set($view);
			}
			elseif($return == 1)
			{
				echo "Erreur &bull; Le document dépasse la limite de taille/mémoire imposée.";
			}
			else
			{
				echo "Erreur &bull; Le document n'a pas, ou a mal, été envoyé. Une erreur est donc survenue. Veuillez réessayer.";
			}
		}
	}