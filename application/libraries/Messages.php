<?php
	abstract class Library_Messages
	{
		const	COOKIE_NAME		=	'__stored_messages',

				TYPE_SUCCESS	=	'success',
				TYPE_WARNING	=	'warning',
				TYPE_ERROR		=	'error';

		public static $_messages = [];
		protected static $_stored_messages = [];

		protected static function _constructArray($content, $type = self::TYPE_ERROR)
		{
			return [
				'content'	=>	$content,
				'type'		=>	$type,
			];
		}

		public static function add($content, $type = self::TYPE_ERROR)
		{
			self::$_messages[]	=	self::_constructArray($content, $type);
		}

		public static function store($content, $type = self::TYPE_ERROR)
		{
			self::$_stored_messages[]	=	self::_constructArray($content, $type);
		}

		public static function registerStoredMessages()
		{
			if(empty(self::$_stored_messages))
				return;

			// Store all messages into a cookie for displaying them in next page
			setcookie(self::COOKIE_NAME, json_encode(self::$_stored_messages), $_SERVER['REQUEST_TIME'] + 60, '/', null, false, true);
			self::$_stored_messages	=	[];
		}

		public static function fetchStoredMessages()
		{
			if(empty($_COOKIE[self::COOKIE_NAME]))
				return;

			self::$_messages	=	json_decode($_COOKIE[self::COOKIE_NAME], true);

			// Don't forget to remove messages from cookies!
			setcookie(self::COOKIE_NAME, null, -1, '/', null, false, true);
		}

		public static function display()
		{
			$template	=	null;

			foreach(self::$_messages as $message)
				$template	.=	\Eliya\Tpl::get('index/messages', $message);

			return $template;
		}
	}
