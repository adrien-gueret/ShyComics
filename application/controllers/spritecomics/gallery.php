<?php
	class Controller_spritecomics_gallery extends Controller_index
	{
		public function get_index($id_user = null)
		{
			$id_user = intval($id_user);
			$resultMembre = Model_Users::getById($id_user);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($resultMembre))
			{
				\Eliya\Tpl::set([
					'user_id'		=>	$resultMembre->prop('id'),
					'user_name'		=>	$resultMembre->prop('username'),
				]);
			}
			
			$view	=	\Eliya\Tpl::get('spritecomics/gallery');
			$this->response->set($view);
		}
	}