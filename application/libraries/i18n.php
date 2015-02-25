<?php
	class Library_i18n
	{
		protected static $_cached_fields	=	[];
		protected static $_lang				=	'fr_FR';

		public static function setLang($lang)
		{
			self::$_lang	=	$lang;
		}

		public static function get($field, $variables = null)
		{
			$segments		=	explode('.', $field);
			$main_field		=	array_shift($segments);
			$is_complete	=	true;

			if( ! isset(self::$_cached_fields[$main_field]))
			{
				$config	=	\Eliya\Config('i18n/'.self::$_lang);
				self::$_cached_fields[$main_field]	=	$config->$main_field;
			}

			$value	=	self::$_cached_fields[$main_field];

			foreach($segments as $segment)
			{
				if( ! isset($value[$segment]))
				{
					$value			=	$field;
					$is_complete	=	false;
					break;
				}
				else
					$value	=	$value[$segment];
			}

			if( ! $is_complete || $variables === null)
				return $value;

			if(is_scalar($variables))
				return sprintf($value, $variables);

			if(is_array($variables) && ! empty($variables))
			{
				uksort($variables, function($a, $b) { return strlen($b) - strlen($a); });

				$tokens		=	array_map(function($t) { return '{{'.$t.'}}'; }, array_keys($variables));
				$fragments	=	array_values($variables);

				return str_replace($tokens, $fragments, $value);
			}

			return $value;
		}
	}