<?php
	abstract class Library_Gallery
	{
		public static function getFolderTemplate(Model_Users $owner, $id_parent, $on_own_gallery = false, $name, $tags = null, $baseURL = null)
		{
			$tpl_gallery		=	null;
			$tpl_delete			=	null;
			$tpl_adding_form	=	null;
			$documents			=	$owner->getDocuments($id_parent); // Get folders AND files
			
			$hierarchy = '';
			$parent = Model_Files::getById($id_parent);
			if(!empty($parent))
			{
				while($parent = $parent->getParentFile())
				{
					$hierarchy = ' >> <a href="' . $baseURL . 'spritecomics/gallery/details/' . $parent->getId() . '">' . $parent->prop('name') . '</a>' . $hierarchy;
				}
				$hierarchy = '<a href="' . $baseURL . 'spritecomics/gallery/' . $owner->getId() . '">' . Library_i18n::get('spritecomics.gallery.details.root') . '</a>' . $hierarchy;
			}
			
			if($documents->isEmpty())
				$tpl_gallery	=	\Eliya\Tpl::get('spritecomics/gallery/empty');
			else
			{
				foreach($documents as $document)
				{
					$type			=	$document->prop('is_dir') ? 'folder' : 'file';
					$tpl_gallery	.=	\Eliya\Tpl::get('spritecomics/gallery/'.$type, ['document' => $document]);
				}
			}

			if($on_own_gallery)
			{
				$tpl_adding_form	=	\Eliya\Tpl::get('spritecomics/gallery/add', ['parent_file_id' => $id_parent]);

				if( ! empty($id_parent))
					$tpl_delete			=	\Eliya\Tpl::get('spritecomics/gallery/delete', ['id_to_delete' => $id_parent]);
			}
			
			$tpl_tags	=	\Eliya\Tpl::get('spritecomics/gallery/tags', ['tags' => $tags, 'is_index' => empty($id_parent)]);

			return \Eliya\Tpl::get('spritecomics/gallery', [
				'tpl_gallery' 		=>	$tpl_gallery,
				'tpl_delete'	 	=>	$tpl_delete,
				'tpl_adding_form' 	=>	$tpl_adding_form,
				'tpl_tags'			=>	$tpl_tags,
				'on_own_gallery'	=>	$on_own_gallery,
				'owner'				=>	$owner,
				'folder_name'		=>	$name,
				'hierarchy'			=>	$hierarchy,
			]);
		}
	}
