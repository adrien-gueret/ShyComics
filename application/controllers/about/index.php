<?php
	class Controller_about_index extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('about.page_title'),
				'page_description'	=>	Library_i18n::get('about.page_description'),
			]);
			
			$tpl_form = \Eliya\Tpl::get('about/form');
			
			$this->response->set(\Eliya\Tpl::get('about/index', ['tpl_form' => $tpl_form]));
		}
		
		public function post_index($contact_list = null, $contact_username = null, $contact_email = null, $contact_subject = null, $contact_message = null)
		{
			if(!(empty($contact_list) || empty($contact_username) || empty($contact_email) || empty($contact_subject) || empty($contact_message)))
			{
				$mailContent = \Eliya\Tpl::get('about/mail_contact', [
					'global topic' => $contact_list,
					'message' => $contact_message
				]);
				Library_Email::sendMail('Shylink <guignard.morgan@gmail.com>', $contact_username, $contact_email, $contact_subject, $mailContent, ['Reply-to: ' . $contact_username . ' <' . $contact_email . '>']);
				
				Library_Messages::add(Library_i18n::get('about.contact_success'), Library_Messages::TYPE_SUCCESS);
			}
			
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('about.page_title'),
				'page_description'	=>	Library_i18n::get('about.page_description'),
			]);
			
			$tpl_form = \Eliya\Tpl::get('about/form');
			
			$this->response->set(\Eliya\Tpl::get('about/index', ['tpl_form' => $tpl_form]));
		}
	}