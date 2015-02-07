<?php
	class Controller_login_verifyAccount extends Controller_index
	{
		public function get_index($m = null, $h = null)
		{
			if(!empty($m) AND !empty($h))
			{
				$m = htmlspecialchars($m, ENT_QUOTES, 'utf-8');
				$h = htmlspecialchars($h, ENT_QUOTES, 'utf-8');
				
				$results = Model_Users::getByEmail($m);
				if(!empty($results))
				{
					$id = $results->getId();
					
					$hashVerif = Library_String::hash($results->prop('email') . $results->prop('username'));
					
					if($hashVerif === $h)
					{
						Model_Users::emailVerified($id);
						
						$_SESSION['connected_user_id'] = $results->prop('id');
						$_SESSION['connected_user_username'] = $results->prop('username');
						
						$this->response->set('Vous avez validé votre compte avec succès et êtes automatiquement connecté. Vous pouvez profiter pleinement et dès à présent du site !');
					}
				}
			}
		}
	}