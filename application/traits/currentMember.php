<?php

trait Trait_CurrentMember
{
	protected $_current_member	=	null;

	protected function _checkCurrentMember()
	{
		if(isset($_SESSION['connected_user_id']))
		{
			$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);
			\Eliya\Tpl::set(['current_member' => $this->_current_member]);
		}
		else
		{
			\Eliya\Tpl::set(['current_member' => null]);
		}

		if(!isset($_SESSION['token_logout']))
			$_SESSION['token_logout'] = uniqid(rand(), true); //Protection contre les failles CSRF
	}
}