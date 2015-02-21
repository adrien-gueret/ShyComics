<?php
	class Controller_login_register extends Controller_main
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'S\'inscire',
			]);

			if(!empty($this->_current_member))
				$this->_redirectToCurrentMemberProfile();
			else
				$this->response->set(\Eliya\Tpl::get('login/register'));
		}
		
		public function post_index($username = null, $password = null, $email = null)
		{
			try
			{
				if(empty($username) || empty($password) || empty($email))
					throw new Exception('Merci de renseigner tous les champs du formulaire.');

				$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
				$email = htmlspecialchars($email, ENT_QUOTES, 'utf-8');

				if( ! filter_var($email, FILTER_VALIDATE_EMAIL))
					throw new Exception('Veuillez rentrer une adresse email valide.');

				$existingMember = Model_Users::getByEmail($email);

				if( ! empty($existingMember))
					throw new Exception('L\'adresse email <em>'.$email.'</em> est déjà utilisée.');

				// Date filtered: we can now save new user in database
				$user = new Model_Users($username, $email, $password);
				Model_Users::add($user);

				// Send verification email
				$hashVerif = Library_String::hash($email.$username);
				$subject = 'Votre inscription sur Shy\'Comics !';

				$mail_content = Eliya\Tpl::get('login/mail_confirm', [
					'email' => $email,
					'hashVerif' => $hashVerif
				]);
				Library_Email::send($email, $subject, $mail_content);

				// Display page confirmation
				Library_Messages::add('Inscription réussie !', Library_Messages::TYPE_SUCCESS);
				$this->response->set(\Eliya\Tpl::get('login/register_success', ['email' => $email]));
			}
			catch(Exception $e)
			{
				Library_Messages::add($e->getMessage());
				$this->response->append(\Eliya\Tpl::get('login/register'));
			}
		}
	}