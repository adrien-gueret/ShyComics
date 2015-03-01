<?php
	class Library_i18n
	{
		protected static $_cached_fields	=	[];
		protected static $_lang				=	'fr_FR';

		const	LABEL_NONE		=	'none',
				LABEL_ONE		=	'one',
				LABEL_SEVERAL	=	'several',
				VARIABLE_TOTAL	=	'total';

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