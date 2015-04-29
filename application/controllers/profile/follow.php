<?php
	class Controller_profile_follow extends Controller_index
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null)
		{
			$member	=	Model_Users::getById($id_user);
			$redirect_url	=	$this->request->getBaseURL().'profile/'.$member->getId();

			if(empty($member))
				return;
			
			$this->_current_member->follow($member);
			
			$this->response->redirect($redirect_url, 200);
		}

		public function get_unfollow($id_user = null)
		{
			$member	=	Model_Users::getById($id_user);
			$redirect_url	=	$this->request->getBaseURL().'profile/'.$member->getId();

			if(empty($member))
				return;
			
			$this->_current_member->unfollow($member);
			
			$this->response->redirect($redirect_url, 200);
		}
	}