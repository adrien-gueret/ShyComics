<?php

class Exception_API_NotFound extends Eliya\APIException {

	public function __construct($id_object) {

		$this->_data				=	[
			'errorCode'			=>	2,
			'errorStringCode'	=>	'NotFound',
			'developerMessage'	=>	'Id #'.$id_object.' was not found in the database',
			'userMessage'		=>	'Object not found',
			'status'			=>	404,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/2'
		];

		parent::__construct();
	}

} 