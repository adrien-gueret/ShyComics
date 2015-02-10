<?php
	class Controller_profile_index extends Controller_index
	{
		public function get_index($id_user = null)
		{
			//If users is on /profile (no id member)
			if(empty($id_user))
			{
				//We redirect him!
				$baseUrl	=	$this->request->getBaseURL() . 'profile/';

				if( ! empty($this->_current_member))
					$this->response->redirect($baseUrl . $this->_current_member->getId());
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

			if( ! empty($member))
			{
				\Eliya\Tpl::set([
					'page_title'		=>	'Profil de ' . $member->prop('username'),
				]);

				$data = [
					'user_id'		=> $member->getId(),
					'user_name'		=> $member->prop('username'),
				];
			}
			
			$view	=	\Eliya\Tpl::get('profile/index', $data);
			$this->response->set($view);
		}
	}