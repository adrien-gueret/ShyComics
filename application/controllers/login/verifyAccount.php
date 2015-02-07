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
						$this->_current_member = Model_Users::getById($_SESSION['connected_user_id']);
						\Eliya\Tpl::set(['current_member' => $this->_current_member]);
						
						$arrayInfo = [
							'infos_message' => 'Vous avez validé votre compte avec succès et êtes automatiquement connecté. Vous pouvez profiter pleinement et dès à présent du site !',
							'infos_message_status' => 'class="message infos sucess"',
						];

						$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
						$data['infos_message'] = $infos_message;
						
						$this->response->set($data['infos_message']);
					}
				}
			}
		}
	}