<?php
	//Main controller class for Ajax: all Ajax controllers should inherit from it
	abstract class Controller_ajax extends Eliya\Controller_Ajax
	{
		use Trait_currentMember;

		public function __init($type = \Eliya\Mime::JSON)
		{
			parent::__init($type);
			$this->_checkCurrentMember();
		}
	}