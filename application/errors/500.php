<?php
	//Custom class for 500 errors
	class Error_500
	{
		public function __construct(Eliya\Response $response)
		{
			$response->set(
				Eliya\Tpl::get('errors', [
			   		'error_number'	=>	500,
					'message'		=>	$response->error()
				])
			);
		}
	}