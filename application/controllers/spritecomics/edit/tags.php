<?php
	class Controller_spritecomics_edit_tags extends Controller_main
	{
		public function update_index($id = null, $content = null)
		{
			$redirect_url = $this->request->getBaseURL().'spritecomics/gallery/';

			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}
			
			$file = Model_Files::getById($id);

			if(empty($file))
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.file.errors.not_found_in_db'), 404);
				return;
			}

			$owner			=	$file->getUser();
			$can_edit_tags	=	$this->_current_member->can(Model_UsersGroups::PERM_EDIT_OTHERS_TAGS);

			if( ! $this->_current_member->equals($owner) && ! $can_edit_tags)
			{
				$this->response->error(Library_i18n::get('spritecomics.edit.file.errors.forbidden'), 403);
				return;
			}
			
			$arrayTags	=	explode(' ', $content);
			$arrayNewTags = [];
			
			if(empty($content))//0 tags
			{
				$arrayTagsInstances = [];
			}
			elseif(strpos($content, ' ') === false)//Only 1 tag
			{
				$tagAlreadyExist = Model_Tags::getTag($content);
				if(empty($tagAlreadyExist))
				{
					$newTag = new Model_Tags($content);
					Model_Tags::add($newTag);
					$arrayTagsInstances = [$newTag];
				}
				else
					$arrayTagsInstances = [$tagAlreadyExist];
			}
			else//More than 1 tag
			{
				$tagsAlreadyExist = Model_Tags::getExistingTags($content);
				$namesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return $tag->name;}, $tagsAlreadyExist) : [];
				$instancesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return Model_Tags::getTag($tag->name);}, $tagsAlreadyExist) : [];
				
				$tagsDontExist = array_diff($arrayTags, $namesTagsAlreadyExist);
				$instancesTagsDontExist = array_map(function($tagName){return new Model_Tags($tagName);}, $tagsDontExist);
				if(!empty($tagsDontExist))
					(count($tagsDontExist) == 1) ? Model_Tags::add(reset($instancesTagsDontExist)) : Model_Tags::addMultiple($instancesTagsDontExist);
				
				$arrayTagsInstances = array_merge($instancesTagsAlreadyExist, $instancesTagsDontExist);
			}
			
			$file->prop('tags', $arrayTagsInstances);
			$file->getParentFile();
			Model_Files::update($file);
			
			$redirect_url .= 'details/'.$file->getId();

			Library_Messages::store(Library_i18n::get('spritecomics.edit.file.success'), Library_Messages::TYPE_SUCCESS);
			$this->response->redirect($redirect_url, 200);
		}
	}