<?php
	class Controller_login_register extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('login.register.page_title'),
				'page_description'	=>	Library_i18n::get('login.register.page_description'),
			]);

			if($this->_current_member->isConnected())
				$this->_redirectToCurrentMemberProfile();
			else
				$this->response->set(\Eliya\Tpl::get('login/register'));
		}
		
		public function post_index($username = null, $password = null, $email = null)
		{
			try
			{
				if(empty($username) || empty($password) || empty($email))
					throw new Exception(Library_i18n::get('login.register.errors.empty_fields'));

				$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
				$email = htmlspecialchars($email, ENT_QUOTES, 'utf-8');

				if( ! filter_var($email, FILTER_VALIDATE_EMAIL))
					throw new Exception(Library_i18n::get('login.register.errors.bad_email'));

				$existingMember = Model_Users::getByEmail($email);

				if( ! empty($existingMember))
					throw new Exception(Library_i18n::get('login.register.errors.email_used', $email));

				// Date filtered: we can now save new user in database
				$user = new Model_Users($username, $email, $password);
				Model_Users::add($user);

				// Send verification email
				$hashVerif = Library_String::hash($email.$username);
				$subject = Library_i18n::get('login.mail_confirm.subject');

				$url	=	$this->$request->getBaseURL();
				$url	.=	'login/verifyAccount?m='.$email.'&h='.$hashVerif;

				$mail_content = Eliya\Tpl::get('login/mail_confirm', ['url_confirm' => $url]);
				Library_Email::send($email, $subject, $mail_content);

				// Display page confirmation
				Library_Messages::add(Library_i18n::get('login.register_success.flash_message'), Library_Messages::TYPE_SUCCESS);
				$this->response->set(\Eliya\Tpl::get('login/register_success', ['email' => $email]));
			}
			catch(Exception $e)
			{
				Library_Messages::add($e->getMessage());
				$this->response->append(\Eliya\Tpl::get('login/register'));
			}
		}
	}