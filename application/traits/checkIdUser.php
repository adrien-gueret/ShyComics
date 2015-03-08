<?php

trait Trait_checkIdUser
{
	protected function _getMemberFromId($id_user, $path_to_redirect_if_empty_id)
	{
		if(empty($id_user))
		{
			$url	=	$this->request->getBaseURL() . $path_to_redirect_if_empty_id;

			// We can redirect only if users is connected
			if($this->_current_member->isConnected())
			{
				$this->response->redirect($url . $this->_current_member->getId());
				exit;
			}

			$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
			return null;
		}

		$member = Model_Users::getById($id_user);

		if(empty($member))
		{
			$this->response->error(Library_i18n::get('errors.global.member_not_found'), 404);
			return null;
		}

		return $member;
	}
}