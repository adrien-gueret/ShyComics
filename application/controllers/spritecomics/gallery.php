<?php
	class Controller_spritecomics_gallery extends Controller_index
	{
		public function get_index($id_user = null)
		{
			$id_user = intval($id_user);
			$membre = Model_Users::getById($id_user);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($membre))
			{
				\Eliya\Tpl::set([
					'user_id'		=> $membre->prop('id'),
					'user_name'		=> $membre->prop('username'),
					'user_files'	=> $membre->getFiles(),
				]);
			}
			
			$view	=	\Eliya\Tpl::get('spritecomics/gallery');
			$this->response->set($view);
		}
	}