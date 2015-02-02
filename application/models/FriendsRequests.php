<?php
	class Model_FriendsRequests extends EntityPHP\Entity
	{
		protected $emitter;
		protected $receiver;
		
		protected static $table_name = 'friends_requests';
		
		public function __construct($emitter = null, $receiver = null)
		{
			$this->emitter = $emitter;
			$this->receiver = $receiver;
			$this->date_sending = $_SERVER['REQUEST_TIME'];
		}
		
		public static function __structure()
		{
			return [
				'emitter' => 'Model_Users',
				'receiver' => 'Model_Users',
				'date_sending' => 'DATETIME',
			];
		}
	}
?>
