<?php
	//A sample controller for API feature
	/*
	 	GET ./api/users/ => calls __getAll() (accepted params: limit, offset)
		GET ./api/users/X => calls __getById() with X as parameter

		These both GET requests can also accept "callback" parameter for handling JSONP

		POST ./api/users/ => calls __createObject with $_POST values as parameter
		PUT ./api/users/X => calls __updateObject for updating items with ID X
		DELETE ./api/users/X => calls __deleteObject for deleting items with ID X
	 */
	class Controller_api_users extends Eliya\Controller_API
	{
		//Default number of items to return in single response
		const DEFAULT_LIMIT			=	2;

		//Maximum items to return in single response
		const MAX_LIMIT				=	3;

		//If response type is XML, we can change the root tag name
		const XML_OBJECT_TAG_NAME	=	'user';

		//For example only: storing some data
		protected static $_users	=	[
			['firstname' => 'Jean', 'lastname' => 'Peplu', 'email' => 'jean@peplu.com'],
			['firstname' => 'Mona', 'lastname' => 'Bruti', 'email' => 'mona@bruti.com'],
			['firstname' => 'Homer', 'lastname' => 'Dalor', 'email' => 'homer@dalor.com'],
			['firstname' => 'Théo', 'lastname' => 'Bligé', 'email' => 'theo@blige.com'],
			['firstname' => 'Marie', 'lastname' => 'Tournel', 'email' => 'marie@tournel.com'],
			['firstname' => 'Emma', 'lastname' => 'Tome', 'email' => 'emma@tome.com'],
		];

		//Abstract method, must be defined
		//Must return an array defining checking rules on fields
		protected function __getCheckingRules()
		{
			return [
				'firstname'	=>	function ($value)
				{
					if(empty($value))
						throw new Exception_API_MissingParam('firstname');
				},
				'lastname'	=>	function ($value)
				{
					if(empty($value))
						throw new Exception_API_MissingParam('lastname');
				},
				'email'	=>	function ($value)
				{
					if(empty($value))
						throw new Exception_API_MissingParam('email');

					if( ! filter_var($value, FILTER_VALIDATE_EMAIL))
						throw new Exception_API_BadEmail($value);
				}
			];
		}

		//Abstract method, must be defined
		//Must return the total of items which can be retrieved via this API controller
		protected function __getTotal()
		{
			return count(self::$_users);
		}

		//Abstract method, must be defined
		//Must return an array containing all items according to $limit & $offset params
		protected function __getAll($limit, $offset)
		{
			if($limit > self::MAX_LIMIT)
				throw new Exception_API_LimitExceeded($limit, self::MAX_LIMIT);

			return array_splice(self::$_users, $offset, $limit);
		}

		//Abstract method, must be defined
		//Must return an associative array containing data of item with given id
		//If item is not found, an exception must be thrown
		protected function __getById($id)
		{
			if( ! empty(self::$_users[$id]))
				return self::$_users[$id];

			throw new Exception_API_NotFound($id);
		}

		//Abstract method, must be defined
		//Must create a new item thanks to received $props and return new item ID
		//No needs to perform checks, Eliya automatically checks fields before calling this method thanks to __getCheckingRules()
		protected function __createObject(array $props)
		{
			self::$_users[]	=	$props;

			return count(self::$_users) - 1;
		}

		//Abstract method, must be defined
		//Must update the received item via $props data and return its ID
		//No needs to perform checks, Eliya automatically checks fields before calling this method thanks to __getCheckingRules()
		protected function __updateObject(&$object, array $props, $object_id)
		{
			foreach($props as $key => $value)
				$object[$key]	=	$value;

			return $object_id;
		}

		//Abstract method, must be defined
		//Must delete the received item
		//No needs to perform checks, Eliya automatically calls __getById()
		protected function __deleteObject(&$object, $object_id)
		{
			array_splice($object, $object_id, 1);
		}
	}