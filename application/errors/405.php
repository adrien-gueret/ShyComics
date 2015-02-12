<?php
	//An instance of this class is automatically called by Eliya when a 405 error is thrown
	//(same as 404)
	class Error_405
	{
		public function __construct(Eliya\Response $response)
		{
			$error_message	=	$response->error();

			//If default message for non-existed page
			if (substr($error_message, 0, 10) === 'Controller')
				$error_message	=	Eliya\Config('messages')->ERRORS['HTTP_405'];

			$response->set(
				Eliya\Tpl::get('errors', [
			   		'error_number'	=>	405,
					'message'		=>	$error_message,
				])
			);
		}
	}