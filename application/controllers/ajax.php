<?php
	//Main controller class for Ajax: all Ajax controllers should inherit from it
	abstract class Controller_ajax extends Eliya\Controller_Ajax
	{
		use Trait_CurrentMember;

		public function __init()
		{
			$this->_checkCurrentMember();
		}
	}