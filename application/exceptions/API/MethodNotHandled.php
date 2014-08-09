<?php

class Exception_API_MethodNotHandled extends Eliya\APIException {

	public function __construct($className, $type, $action) {

		$this->_data				=	[
			'errorCode'			=>	1,
			'errorStringCode'	=>	'MethodNotHandled',
			'developerMessage'	=>	'Controller "' . $className . '" does not have method "' . $type . '_'.$action.'"',
			'userMessage'		=>	'This path can\'t be requested with '.strtoupper($type).' method',
			'status'			=>	405,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/1'
		];

		parent::__construct();
	}

} 