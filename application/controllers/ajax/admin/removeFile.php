<?php
	class Controller_ajax_admin_removeFile extends Eliya\Controller_Ajax
	{
		public function get_index($id = null)
		{
			$file = Model_Files::getById($id);
			$user = $file->getUser();
			if(!empty($file) && !empty($this->_current_member) && ($this->_current_member->getId() == $user->getId() || $this->_current_member->getPermission('can_remove')))
			{
				$path = $file->getPath();
				if(is_file($path))
				{
					if(unlink($path))
					{
						Model_Users::removeFile($id);
						
						$arrayInfo = [
							'infos_message' => 'L\'image a bien été supprimée.',
							'infos_message_status' => 'class="message infos success"',
						];
						$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
						
						$this->success([
							'infosMessage' => $infos_message,
						]);
					}
					else
					{
						$arrayInfo = [
							'infos_message' => 'Une erreur est survenue. L\'image n\'a pas pu être supprimée. Veuillez réessayer ou prévenir un administrateur.',
							'infos_message_status' => 'class="message infos error"',
						];
						$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
						
						$this->error([
							'infosMessage' => $infos_message,
						]);
					}
				}
				else
				{
					$arrayInfo = [
						'infos_message' => 'Une erreur est survenue. L\'image n\'a pas pu être trouvée. Veuillez réessayer ou prévenir un administrateur.',
						'infos_message_status' => 'class="message infos error"',
					];
					$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
					
					$this->error([
						'infosMessage' => $infos_message,
					]);
				}
			}
			else
			{
				$arrayInfo = [
					'infos_message' => 'Une erreur est survenue. Vous n\'avez pas les permissions nécessaires pour supprimer cette image.',
					'infos_message_status' => 'class="message infos error"',
				];
				$infos_message = \Eliya\Tpl::get('infos_message', $arrayInfo);
				
				$this->error([
					'infosMessage' => $infos_message,
				]);
			}
		}
	}