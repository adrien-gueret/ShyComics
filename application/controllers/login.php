<?php
	class Controller_login extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Se connecter',
			]);
			
			if(isset($_SESSION['id']))
				$view	=	\Eliya\Tpl::get('login/alreadyLogged');
			else
				$view	=	\Eliya\Tpl::get('login/index');
			
			$this->response->set($view);
		}
		
		public function get_subscription()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'S\'inscire',
			]);
			$this->response->set(\Eliya\Tpl::get('login/subscription'));
		}
		
		public function post_subscription($username = null, $password = null, $email = null)
		{
			$username = htmlspecialchars($username, ENT_QUOTES, 'utf-8');
			$email = htmlspecialchars($email, ENT_QUOTES, 'utf-8');
			$password = htmlspecialchars($password, ENT_QUOTES, 'utf-8');
			
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
						$message = 'Vous vous êtes inscrit avec succès sur Shy\'Comics ! Veuillez cliquer sur le lien ci-dessous pour valider votre inscription :<br /><a href="http://shycomics.fr/login/verifyAccount?m=' . $email . '&h=' . $hashVerif . '">http://shycomics.fr/login/verifyAccount?m=' . $email . '&h=' . $hashVerif . '</a>';
						
						Library_Email::send($email, $subject, $message);
						
						$this->response->set('Vous vous êtes inscrit avec succès. Cependant, rendez vous dans votre boîte mail fin de valider votre inscription une bonne fois pour toutes.');
					}
					else
					{
						$this->response->set('Cette adresse email est déjà utilisée.');
						$this->response->set(\Eliya\Tpl::get('login/subscription'));
					}
				}
				else
				{
					$this->response->set('Veuillez rentrer une adresse email valide.');
					$this->response->set(\Eliya\Tpl::get('login/subscription'));
				}
			}
			else
			{
				$this->response->set('Merci de renseigner tous les champs du formulaire !');
				$this->response->set(\Eliya\Tpl::get('login/subscription'));
			}
		}
		
		public function get_verifyAccount($m = null, $h = null)
		{
			if(!empty($m) AND !empty($h))
			{
				$m = htmlspecialchars($m, ENT_QUOTES, 'utf-8');
				$h = htmlspecialchars($h, ENT_QUOTES, 'utf-8');
				
				$results = Model_Users::getByEmail($m);
				if($results != null)
				{
					$id = $results->getId();
					
					$security = \Eliya\Config('main')->SECURITY;
					$salt = $security['SALT'];
					
					$hashVerif = Library_String::hash($results->getEmail() . $results->getUsername());
					
					if($hashVerif == $h)
					{
						Model_Users::emailVerified($id);
						$this->response->set('Vous avez validé votre compte avec succès. Vous pouvez profiter pleinement et dès à présent du site !');
					}
				}
			}
		}
	}
?>