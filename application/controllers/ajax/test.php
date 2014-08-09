<?php
	/*
		Extending Eliya\Controller_Ajax class provides some useful features for Ajax controllers
	*/
	class Controller_ajax_test extends Eliya\Controller_Ajax
	{
		//(./ajax/test/)
		public function get_index()
		{
			//By default, success() method send a JSON as response
			$this->success([
				'id'		=>	1,
				'firstname'	=>	'Jean',
				'lastname'	=>	'Peplu'
	   		]);
		}

		//(./ajax/test/error)
		public function get_error()
		{
			//In case of error, you should use error() method instead of success() (quite logical, isn't it?)
			$this->error([
				'code'		=>	666,
				'message'	=>	'It\'s the end of the world!',
			]);
		}

		//(./ajax/test/xml)
		public function get_xml()
		{
			//Eliya allows you to change response type.
			$this->response->type(\Eliya\Mime::XML);

			//In the case of XML, success() & error() will automatically send an XML instead of a JSON.
			$this->success([
				'id'		=>	1,
				'firstname'	=>	'Jean',
				'lastname'	=>	'Peplu'
			]);
		}
	}