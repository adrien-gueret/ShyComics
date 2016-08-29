<?php
	class Controller_admin_users extends Controller_admin_main
	{
		public function get_index()
		{
			$users = Model_Users::getAllSorted();
			$this->response->set(\Eliya\Tpl::get('admin/users/index', ['users' => $users]));
		}
		
		public function get_details($id_user = null)
		{
			$user = Model_Users::getById($id_user);
			$groups = Model_UsersGroups::getAll();
			if($user)
				$this->response->set(\Eliya\Tpl::get('admin/users/details', ['user' => $user, 'groups' => $groups]));
			else
			{
				$this->response->error(Library_i18n::get('admin.errors.users.doesnt_exist'), 404);
				return;
			}
		}
		
		public function update_index($id_user = null, $banned = null, $id_group = null, $about = null)
		{
			$user = Model_Users::getById($id_user);
			$newGroup = Model_UsersGroups::getById($id_group);
			if($user && $newGroup)
			{
				$user->prop('user_group', $newGroup);
				$user->prop('is_banned', $banned);
				$user->prop('about', $about);
				
				$user->load('locale_website');
				
				Model_Users::update($user);
				
				Library_Messages::store(Library_i18n::get('admin.users_success'), Library_Messages::TYPE_SUCCESS);
				$this->response->redirect($this->request->getBaseURL() . 'admin/users/' . $user->getId());
			}
			else
			{
				$this->response->error(Library_i18n::get('admin.errors.users.bad_informations'), 403);
				return;
			}
		}
	}