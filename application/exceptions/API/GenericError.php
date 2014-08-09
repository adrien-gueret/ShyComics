<?php

class Exception_API_GenericError extends Eliya\APIException {

	public function __construct(\Exception $e) {

		$code	=	$e->getCode();

		$this->_data	=	[
			'errorCode'			=>	0,
			'errorStringCode'	=>	'GenericError',
			'developerMessage'	=>	$e->getMessage(),
			'userMessage'		=>	'A generic error has been thrown.',
			'status'			=>	empty($code) ? 500 : $code,
			'moreInfo'			=>	'http://www.example.gov/developer/path/to/help/for/0'
		];

		parent::__construct([], 0, $e->getPrevious());
	}

} 