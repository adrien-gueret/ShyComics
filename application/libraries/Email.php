<?php
	abstract class Library_Email
	{
		const MIME = 'MIME-Version: 1.0',
              CONTENT_TYPE = 'Content-Type: text/html; charset=UTF-8';

        public static function sendMail($to, $fromName = '', $fromEmail = '', $subject = '', $message = '', $extraHeaders = [])
        {
            $headers = ['From: ' . $fromName . ' <' . $fromEmail . '>', self::MIME, self::CONTENT_TYPE];
            $headers = array_merge($headers, $extraHeaders);

            return mail($to, $subject, $message, implode($headers, "\r\n"));
        }

        public static function sendFromShyComics($to, $subject, $message)
        {
            return self::sendMail($to, 'Shy\'Comics', 'no-reply@shycomics.fr', $subject, $message);
        }
    }