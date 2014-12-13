<?php
	class Controller_login_register extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'S\'inscire',
			]);
			$this->response->set(\Eliya\Tpl::get('login/register'));
		}
		
		public function post_index($username = null, $password = null, $email = null)
		{
			$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
			$email = htmlspecialchars($email, ENT_QUOTES, 'utf-8');
			
			if(!empty($username) AND !empty($password) AND !empty($email))
			{
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$results = Model_Users::getByEmail($email);
					if($results === null)
					{
						$user = new Model_Users($username, $email, $password);
						
						Model_Users::add($user);
						
						$hashVerif = Library_String::hash($email . $username);
						$subject = 'Votre inscription sur Shy\'Comics !';
						$data = [
							'email' => $email,
							'hashVerif' => $hashVerif
						];
						$message = Eliya\Tpl::get('login/mail_confirm', $data);
						
						Library_Email::send($email, $subject, $message);
						
						$this->response->set('Vous vous êtes inscrit avec succès. Cependant, rendez vous dans votre boîte mail afin de valider votre inscription une bonne fois pour toutes.');
					}
					else
					{
						$this->response->set('Cette adresse email est déjà utilisée.');
						$this->response->append(\Eliya\Tpl::get('login/register'));
					}
				}
				else
				{
					$this->response->set('Veuillez rentrer une adresse email valide.');
					$this->response->append(\Eliya\Tpl::get('login/register'));
				}
			}
			else
			{
				$this->response->set('Merci de renseigner tous les champs du formulaire !');
				$this->response->append(\Eliya\Tpl::get('login/register'));
			}
		}
	}