<?php
	//An instance of this class is automatically called by Eliya when a 400 error is thrown
	class Error_400
	{
		public function __construct(Eliya\Response $response)
		{
			$response->set(
				Eliya\Tpl::get('errors', [
			   		'error_number'	=>	400,
					'message'		=>	$response->error()
				])
			);
		}
	}