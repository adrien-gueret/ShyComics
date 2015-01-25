<?php
	class Model_FriendsRequests extends EntityPHP\Entity
	{
		protected $id_emitter;
		protected $id_receiver;
		protected $date_sending;
		
		protected static $table_name = 'friends_requests';
		
		public function __construct($id_emitter = null, $id_receiver = null, $date_sending = null)
		{
			$this->emitter = $id_emitter;
			$this->receiver = $id_receiver;
			$this->date_sending = $date_sending;
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
