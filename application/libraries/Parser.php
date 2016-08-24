<?php
	abstract class Library_Parser
	{
		public static function getButtons($baseURL, $textareaId)
		{
			$smileys = Model_Smileys::getAll();
			$tpl_smileys = '';
			foreach($smileys as $smiley)
			{
				$tpl_smileys = $tpl_smileys . \Eliya\Tpl::get('common/buttons/smiley', ['smiley' => $smiley, 'textareaId' => $textareaId]);
			}
			
			return \Eliya\Tpl::get('common/buttons/buttons', [
				'tpl_smileys' => $tpl_smileys,
				'textareaId' => $textareaId,
			]);
		}
		
		public static function parseQuotesRecursive($input)
		{
			if(is_array($input))
			{
				if(!empty($input[2]))
					$input = '<blockquote><cite>' . $input[2] . ' ' . Library_i18n::get('parser.quote.said') . ' :</cite><br /><span>' . $input[3] . '</span></blockquote>';
				else
					$input = '<blockquote><cite>' . Library_i18n::get('parser.quote.quote') . ' :</cite><br /><span>' . $input[3] . '</span></blockquote>';
			}
			$regex = '#\[quote(=(.*))?\]((?:[^[]|\[(?!/?quote(=(.*))?\])|(?R))+)\[/quote\]#isU';
			return preg_replace_callback($regex, 'self::parseQuotesRecursive', $input);
		}
		
		public static function parse($string, $baseURL)
		{
			$smileys = Model_Smileys::getAll();
			foreach($smileys as $smiley)
			{
				$string = preg_replace('#' . $smiley->prop('tag') . '#isU', '<img src="' . $baseURL . $smiley->getPath() . '" alt="' . $smiley->prop('tag') . '" />', $string);
			}
			
			$string = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $string);
			$string = preg_replace('#\[i\](.+)\[/i\]#isU', '<i>$1</i>', $string);
			$string = preg_replace('#\[u\](.+)\[/u\]#isU', '<u>$1</u>', $string);
			
			$string = self::parseQuotesRecursive($string); //Parsing quotes (possibility of quotes in quotes)
			
			return $string;
		}
	}
