<?php
	class Controller_spritecomics_gallery extends Controller_main
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null)
		{
			$member	=	$this->_getMemberFromId($id_user, 'spritecomics/gallery/');

			if(empty($member))
				return;

			$is_own_gallery	=	false;

			if($this->_current_member->isConnected())
				$is_own_gallery	=	$this->_current_member->equals($member);

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('spritecomics.gallery.page_title', $member->prop('username')),
				'page_description'	=>	Library_i18n::get('spritecomics.gallery.page_description', $member->prop('username')),
			]);

			$this->response->set(Library_Gallery::getFolderTemplate($member, null, $is_own_gallery, null, null, null, false, false));
		}

		public function post_index($name = null, $description = null, $parent_file_id = null, $is_dir = 1, $thumbnail_data_url = null, $tags = null)
		{
			if( ! $this->_current_member->isConnected())
			{
				$this->response->error(Library_i18n::get('errors.global.need_connection'), 401);
				return;
			}

			$parent	=	null;

			if( ! empty($parent_file_id))
			{
				$parent	=	Model_Files::getById($parent_file_id);

				if(empty($parent))
				{
					$this->response->error(Library_i18n::get('spritecomics.gallery.add.errors.parent_not_found'), 404);
					return;
				}

				$parent_owner	=	$parent->getUser();

				if( ! $this->_current_member->equals($parent_owner))
				{
					$this->response->error(Library_i18n::get('spritecomics.gallery.add.errors.forbidden'), 403);
					return;
				}
			}
			
			$success	=	false;
			
			if(empty($name))
				Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.empty_name'));
			else
			{
				if($is_dir)
				{
					Model_Files::addFolder($this->_current_member, $name, $description, $parent, $tags);
					$success	=	true;
				}
				else
				{
					if(empty($thumbnail_data_url))
						Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.empty_thumbnail'));
					else
						$success	=	$this->_newFile($thumbnail_data_url, $name, $description, $parent, $tags);
				}
			}

			if( ! $success)
			{
				if(empty($parent_file_id))
					$this->get_index($this->_current_member->getId());
				else
					$this->get_details($parent_file_id);
			}
			else
			{
				$url	=	$this->request->getBaseURL().'spritecomics/gallery/';

				if( ! empty($parent_file_id))
					$url	.=	'details/'.$parent_file_id;

				Library_Messages::store(Library_i18n::get('spritecomics.gallery.add.success'), Library_Messages::TYPE_SUCCESS);

				$this->response->redirect($url);
			}
		}

		public function get_details($id_document = null)
		{
			$document = Model_Files::getById($id_document);

			if(empty($document))
			{
				$this->response->error(Library_i18n::get('spritecomics.gallery.details.not_found'), 404);
				return;
			}

			$tags = $document->load('tags');
			$page_title = $document->prop('name') ?: Library_i18n::get('spritecomics.gallery.details.default_page_title');
			
			\Eliya\Tpl::set([
				'page_title'	=>	$page_title,
				'page_description'	=>	$document->prop('description') ?: null,
			]);

			$owner	=	$document->getUser();

			$is_own_gallery	=	false;
			$has_liked		=	false;
			
			if($this->_current_member->isConnected())
			{
				$is_own_gallery	=	$this->_current_member->equals($owner);
				$has_liked 		=	$document->isLikedByUser($this->_current_member);
				$has_viewed		=	$this->_current_member->hasViewedFileToday($document);
			}
			
			if($document->prop('is_dir') == 1)
				$template	=	Library_Gallery::getFolderTemplate($owner, $document->getId(), $is_own_gallery, $document->prop('name'), $tags, $this->request->getBaseURL(), $this->_current_member->can(Model_UsersGroups::PERM_EDIT_OTHERS_TAGS), $this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_FILES));
			else
			{
				$tpl_delete	=	null;
				$tpl_like	=	null;
				
				if($this->_current_member->isConnected() && ! $is_own_gallery && ! $has_viewed)
				{
					$newView = new Model_Views($this->_current_member, $document);
					Model_Views::add($newView);
				}
				
				$imagePath = $this->request->getBaseURL() . $document->getPath();
				$URL = $this->request->getBaseURL() . 'spritecomics/gallery/details/' . $id_document;
				
				$hierarchy = '';
				$parent = $document;
				while($parent = $parent->getParentFile())
				{
					$hierarchy = ' >> <a href="' . $this->request->getBaseURL() . 'spritecomics/gallery/details/' . $parent->getId() . '">' . $parent->prop('name') . '</a>' . $hierarchy;
				}
				$hierarchy = '<a href="' . $this->request->getBaseURL() . 'spritecomics/gallery/' . $owner->getId() . '">' . Library_i18n::get('spritecomics.gallery.details.root') . '</a>' . $hierarchy;
				
                //Navigation arrows
                $tpl_arrows = '';
				
				$previous = $document->getPrevious();
				$next 	  = $document->getNext();
                
                if(!empty($previous))
                    $tpl_arrows .= '<div class="left-nav"><a href="' . $this->request->getBaseURL() . 'spritecomics/gallery/details/' . $previous->getId() . '"><button class="orange"><i class="fa fa-arrow-left" aria-hidden="true"></i>  ' .Library_i18n::get('spritecomics.gallery.details.previous') . '</button></a></div><br />';
                if(!empty($next))
                    $tpl_arrows .= '<div class="right-nav"><a href="' . $this->request->getBaseURL() . 'spritecomics/gallery/details/' . $next->getId() . '"><button class="orange right-nav"><i class="fa fa-arrow-right" aria-hidden="true"></i>  ' . Library_i18n::get('spritecomics.gallery.details.next') . '</button></a></div><br />';
				
                \Eliya\Tpl::set([
					'social_NW_meta'	=>	'<meta property="og:title" content="' . $page_title . '">
											<meta property="og:type" content="article">
											<meta property="og:site_name" content="Shy Comic\'s">
											<meta property="fb:admins" content="81657339196">
											<meta property="og:description" content="' . Library_i18n::get('spritecomics.like.FB.description', $owner->prop('username')) . '">
											<meta property="og:image" content="' . $imagePath . '">
											<meta property="og:url" content="' . $URL . '">'
				]);
				
				//Delete file
				$can_remove_other_files	=	$this->_current_member->isConnected() &&
											$this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_FILES);

				if($is_own_gallery || $can_remove_other_files)
					$tpl_delete	=	\Eliya\Tpl::get('spritecomics/gallery/delete', [
						'id_to_delete' => $document->getId(),
						'message' => addslashes(Library_i18n::get('spritecomics.gallery.details.delete'))
					]);
				
				//Likes
				if($this->_current_member->isConnected())
				{
					if(! $this->_current_member->equals($owner))
					{
						$tpl_like = \Eliya\Tpl::get('spritecomics/gallery/details/like', [
							'has_liked'	=>	$has_liked,
							'id_file'	=>	$document->getId(),
							'nbr_likes'	=>	$document->getNbrOfLikes(),
						]);
					}
				}
				
				//Tags
				$can_edit_tags = $this->_current_member->can(Model_UsersGroups::PERM_EDIT_OTHERS_TAGS) || $is_own_gallery;
				$tpl_tags = \Eliya\Tpl::get('spritecomics/gallery/tags', [
					'id' => $document->getId(),
					'tags' => $tags,
					'is_index' => false,
					'can_edit' => $can_edit_tags
				]);
				
				//Comments
				$can_remove_other_comments = $this->_current_member->can(Model_UsersGroups::PERM_REMOVE_OTHERS_COMMENTS);
				$comments = $document->getComments();
				
				$tpl_comment = \Eliya\Tpl::get('spritecomics/gallery/details/comment', [
					'id_file'	 => $document->getId(),
					'comments'	 => $comments->getArray(),
					'can_remove'  => $can_remove_other_comments,
					'tpl_buttons' => Library_Parser::getButtons($this->request->getBaseURL(), 'content-comment')
				]);
				
				//Description
				$can_edit_desc	=	$this->_current_member->can(Model_UsersGroups::PERM_EDIT_OTHERS_DESCS) || $is_own_gallery;
				$tpl_description = \Eliya\Tpl::get('spritecomics/gallery/details/description', [
					'id'			=>	$document->getId(),
					'description'	=>	$document->prop('description'),
					'can_edit'	=>	$can_edit_desc
				]);
				
				//Views
				$tpl_nbr_views = \Eliya\Tpl::get('spritecomics/gallery/details/nbr_views', ['nbr_views' => Model_Views::count('document.id=?', [$id_document])]);
				
				//Social Networks
				$tpl_social_NW = \Eliya\Tpl::get('spritecomics/gallery/details/social_NW', ['URL' => $URL]);

				$template	=	\Eliya\Tpl::get('spritecomics/gallery/details/file', [
					'file'				=>	$document,
					'imagePath'			=>	$imagePath,
					'tpl_nbr_views'		=>	$tpl_nbr_views,
					'tpl_social_NW'		=>	$tpl_social_NW,
					'tpl_delete'		=>	$tpl_delete,
					'tpl_like'			=>	$tpl_like,
					'tpl_comment'		=>	$tpl_comment,
					'tpl_tags'			=>	$tpl_tags,
					'tpl_description'	=>	$tpl_description,
					'tpl_arrows'		=>	$tpl_arrows,
					'hierarchy'			=>	$hierarchy,
                    'on_own_gallery'	=>	$is_own_gallery,
                    'owner' 			=>	$owner,
				]);
			}
			
			$this->response->set($template);
		}

		protected function _newFile($thumbnail_data_url, $name, $description = null, Model_Files $parent = null, $tags = null)
		{
			if( ! isset($_FILES['file']) || $_FILES['file']['error'] != 0)
			{
				Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.bad_upload'));
				return false;
			}

			$upload_error	=	true;

			switch(Model_Files::addFile($this->_current_member, $_FILES['file'], $thumbnail_data_url, $name, $description, $parent, $tags))
			{
				case Model_Files::ERROR_SIZE:
					Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.file_too_big'));
				break;

				case Model_Files::ERROR_TYPE:
					Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.bad_type'));
				break;

				case Model_Files::ERROR_SAVE:
					Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.unknown'));
				break;

				case Model_Files::ERROR_THUMB:
					Library_Messages::add(Library_i18n::get('spritecomics.gallery.add.errors.thumb'), Library_Messages::TYPE_WARNING);
				break;

				case Model_Files::PROCESS_OK:
					$upload_error	=	false;
				break;
			}

			return ! $upload_error;
		}
	}