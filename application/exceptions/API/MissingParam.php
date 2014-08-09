<?php

class Exception_API_MissingParam extends Eliya\APIException {

	public function __construct($param_name) {

		$this->_data				=	[
			'errorCode'			=>	4,
			'errorStringCode'	=>	'MissingParam',
			'developerMessage'	=>	'Parameter "'.$param_name.'" is empty',
			'userMessage'		=>	'Please provide a value for "'.$param_name.'"',
			'status'			=>	400,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/4'
		];

		parent::__construct();
	}

} 