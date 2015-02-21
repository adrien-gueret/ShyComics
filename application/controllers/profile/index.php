<?php
	class Controller_profile_index extends Controller_index
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null, $fromPage = null)
		{
			$member	=	$this->_getMemberFromId($id_user, 'profile/');

			if(empty($member))
				return;

			\Eliya\Tpl::set([
				'page_title'		=>	'Profil de ' . $member->prop('username'),
			]);

			$data = [
				'user_id'		=> $member->getId(),
				'user_name'		=> $member->prop('username'),
			];
			
			$view	=	\Eliya\Tpl::get('profile/index', $data);
			$this->response->set($view);
		}
	}