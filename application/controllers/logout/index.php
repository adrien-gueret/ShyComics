<?php
	class Controller_logout_index extends Controller_main
	{
		public function get_index($token = null)
		{
			if(isset($_SESSION['connected_user_id']) && !empty($token) && $token == $_SESSION['token_logout'])
			{
				session_destroy();

				Library_Messages::store('Vous vous êtes correctement déconnecté. A très bientôt !', Library_Messages::TYPE_SUCCESS);
			}
			else
			{
				Library_Messages::store('Il n\'a pas été possible de vous déconnecter...', Library_Messages::TYPE_WARNING);
			}
			
			$this->response->redirect('login/index');
		}
	}