<?php
	abstract class Library_Email
	{
		public static function send($to, $subject, $message)
		{
			$expediteur = 'no-reply@shycomics.fr';
			$headers = 'From: Shy\'Comics <' . $expediteur . '>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mail($to, $subject, $message, $headers);
		}
	}