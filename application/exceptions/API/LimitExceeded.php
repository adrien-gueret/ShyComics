<?php

class Exception_API_LimitExceeded extends Eliya\APIException {

	public function __construct($limit, $max) {

		$this->_data				=	[
			'errorCode'			=>	3,
			'errorStringCode'	=>	'LimitExceeded',
			'developerMessage'	=>	'$limit parameter (value: '.$limit.') is higher than max limitation (value: '.$max.')',
			'userMessage'		=>	'You can\'t request for more than '.$max.' objects',
			'status'			=>	400,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/3'
		];

		parent::__construct();
	}

} 