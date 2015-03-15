<?php
	class Library_i18n
	{
		const	DEFAULT_LOCALE	=	'fr_FR',

				LABEL_NONE		=	'none',
				LABEL_ONE		=	'one',
				LABEL_SEVERAL	=	'several',
				VARIABLE_TOTAL	=	'total';

		protected static $_SUPPORTED_LANGUAGES	=	[
			'fr'	=>	'fr_FR',
			'en'	=>	'en_US'
		];

		protected static $_cached_fields	=	[];
		protected static $_locale			=	self::DEFAULT_LOCALE;

		protected static function _getPluralizationValue(Array $i18n_value, $total_variable)
		{
			if($total_variable === 0)
			{
				if(isset($i18n_value[self::LABEL_NONE]))
					return  $i18n_value[self::LABEL_NONE];

				throw new Exception(self::LABEL_NONE);
			}

			if($total_variable === 1)
			{
				if(isset($i18n_value[self::LABEL_ONE]))
					return  $i18n_value[self::LABEL_ONE];

				throw new Exception(self::LABEL_ONE);
			}

			if(isset($i18n_value[self::LABEL_SEVERAL]))
				return  $i18n_value[self::LABEL_SEVERAL];

			throw new Exception(self::LABEL_SEVERAL);
		}

		protected static function _tryGettingPluralisationValue(Array $i18n_value, $total_variable, $field)
		{
			try
			{
				return self::_getPluralizationValue($i18n_value, $total_variable);
			}
			catch(Exception $e)
			{
				return $field.'.'.$e->getMessage();
			}
		}

		protected static function _getLangFromBrowser()
		{
			$main_lang	=	strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

			return isset(self::$_SUPPORTED_LANGUAGES[$main_lang]) ? self::$_SUPPORTED_LANGUAGES[$main_lang] : null;
		}

		public static function defineLocale(Model_Users $user)
		{
			$lang	=	null;

			if($user->isConnected())
				$lang	=	$user->prop('locale_website')->prop('name');
			else
				$lang	=	self::_getLangFromBrowser();

			if( ! in_array($lang, self::$_SUPPORTED_LANGUAGES))
				$lang	=	null;

			self::$_locale	=	$lang ?: self::DEFAULT_LOCALE;
		}

		public static function getLocale()
		{
			return self::$_locale;
		}

		public static function setLocale($locale)
		{
			self::$_locale	=	$locale;
		}

		public static function get($field, $variables = null)
		{
			$segments		=	explode('.', $field);
			$main_field		=	array_shift($segments);
			$is_complete	=	true;

			$cache_key		=	self::$_locale.':'.$main_field;

			if( ! isset(self::$_cached_fields[$cache_key]))
			{
				$config	=	\Eliya\Config('i18n/'.self::$_locale);
				self::$_cached_fields[$cache_key]	=	$config->$main_field;
			}

			$value	=	self::$_cached_fields[$cache_key];

			if(empty($value))
				return $field;

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
			{
				if(is_array($value))
					$value	=	self::_tryGettingPluralisationValue($value, $variables, $field);

				return sprintf($value, $variables);
			}

			if(is_array($variables) && ! empty($variables))
			{
				if(is_array($value))
				{
					if(isset($variables[self::VARIABLE_TOTAL]))
						$value	=	self::_tryGettingPluralisationValue($value, $variables[self::VARIABLE_TOTAL], $field);
					else
						throw new Exception('Can\'t find key "'.self::VARIABLE_TOTAL.'" in values used for label "'.$field.'"');
				}

				uksort($variables, function($a, $b) { return strlen($b) - strlen($a); });

				$tokens		=	array_map(function($t) { return '{{'.$t.'}}'; }, array_keys($variables));
				$fragments	=	array_values($variables);

				return str_replace($tokens, $fragments, $value);
			}

			return $value;
		}
	}