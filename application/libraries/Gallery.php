<?php
	abstract class Library_Gallery
	{
		public static function getFolderTemplate(Model_Users $owner, $id_parent = null, $on_own_gallery = false)
		{
			$tpl_gallery		=	null;
			$tpl_delete			=	null;
			$tpl_adding_form	=	null;
			$documents			=	$owner->getDocuments($id_parent); // Get folders AND files

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

			return \Eliya\Tpl::get('spritecomics/gallery', [
				'tpl_gallery' 		=>	$tpl_gallery,
				'tpl_delete'	 	=>	$tpl_delete,
				'tpl_adding_form' 	=>	$tpl_adding_form,
				'on_own_gallery'	=>	$on_own_gallery,
				'owner'				=>	$owner,
			]);
		}
	}
