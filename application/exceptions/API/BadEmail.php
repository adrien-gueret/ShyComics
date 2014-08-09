<?php

class Exception_API_BadEmail extends Eliya\APIException {

	public function __construct($email) {

		$this->_data				=	[
			'errorCode'			=>	5,
			'errorStringCode'	=>	'BadEmail',
			'developerMessage'	=>	'Value "'.$email.'" is not a valid email address.',
			'userMessage'		=>	'Please provide a valid email address.',
			'status'			=>	400,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/5'
		];

		parent::__construct();
	}

} 