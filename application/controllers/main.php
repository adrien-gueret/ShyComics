<?php
	//Main controller class of the site: all controllers should inherit from it
	abstract class Controller_main extends Eliya\Controller
	{
		use Trait_CurrentMember;

		public function __init()
		{
			$this->_checkCurrentMember();
		}
	}