<?php
	//Main controller class of the site: all controllers should inherit from it
	abstract class Controller_main extends Eliya\Controller
	{
		use Trait_currentMember;

		public function __init()
		{
			Library_Messages::fetchStoredMessages();
			$this->_checkCurrentMember();
		}

		public function __destruct()
		{
			Library_Messages::registerStoredMessages();
		}
	}