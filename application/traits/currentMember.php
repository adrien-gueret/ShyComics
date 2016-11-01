<?php

trait Trait_currentMember
{
	protected $_current_member	=	null;

	protected function _checkCurrentMember()
	{
		if(isset($_SESSION['connected_user_id']))
		{
			$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);
			$this->_current_member->prop('last_login', date('Y-m-d H:i:s'));
            Model_Users::update($this->_current_member);
            
			if($this->_current_member->prop('is_banned'))
				$this->_current_member = new Model_Users();
		}
		else
			$this->_current_member = new Model_Users();

		Library_i18n::defineLocale($this->_current_member);

		\Eliya\Tpl::set(['current_member' => $this->_current_member]);

		if(!isset($_SESSION['token_logout']))
			$_SESSION['token_logout'] = uniqid(rand(), true); //Protection contre les failles CSRF
	}

	protected function _redirectToCurrentMemberProfile()
	{
		$this->response->redirect($this->request->getBaseUrl().'profile/'.$this->_current_member->getId());
		exit;
	}
}