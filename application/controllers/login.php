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
			$view	=	\Eliya\Tpl::get('login/subscription');
			$this->response->set($view);
		}
		
		public function post_subscription($username = null, $password = null, $email = null)
		{
			$username = htmlspecialchars($username);
			$email = htmlspecialchars($email);
			$password = htmlspecialchars($password);
			
			if(!empty($username) AND !empty($password) AND !empty($email))
			{
				if(preg_match('#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $email))
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
					}
				}
				else
				{
					$this->response->set('Veuillez rentrer une adresse email valide.');
				}
			}
			else
			{
				$this->response->set('Vous n\'avez pas renseigné de pseudo et/ou de mot de passe et/ou d\'adresse email !');
			}
		}
		
		public function get_verifyAccount($m = null, $h = null)
		{
			if(!empty($m) AND !empty($h))
			{
				$m = htmlspecialchars($m);
				$h = htmlspecialchars($h);
				
				$results = Model_Users::getByEmail($m);
				if($results != null)
				{
					$id = $results->getId();
					
					$security = \Eliya\Config('main')->SECURITY;
					$salt = $security['SALT'];
					
					$hashVerif = sha1($results->getEmail() . $results->getUsername() . $salt);
					
					if($hashVerif == $h)
					{
						Model_Users::emailVerified($id);
						$this->response->set('Vous avez validé votre compte avec succès. Vous pouvez profiter pleinement et dés à présent du site !');
					}
				}
			}
		}
	}
?>