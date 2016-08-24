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
		
		public static function parse($string)
		{
			return $string;
		}
	}
