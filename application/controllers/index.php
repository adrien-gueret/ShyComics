<?php
	/*
		Controller_index is the default controller called on the website root
	*/
	class Controller_index extends Controller_main
	{
		public function get_index()
		{
			$documents = Model_Files::getLastBoards(10);
			$tpl_last_boards = '';
			foreach($documents as $document)
			{
				$tpl_last_boards	.=	\Eliya\Tpl::get('spritecomics/gallery/file', ['document' => $document]);
			}
			
			$random = Model_Files::getRandom();
			(!empty($random)) ? $tpl_random = \Eliya\Tpl::get('spritecomics/gallery/file', ['document' => $random]) : '';
			
			$comments = Model_Comments::getLastComments(10);
			$tpl_last_comments = \Eliya\Tpl::get('index/last_comments', ['comments' => $comments]);
			
			$this->response->set(\Eliya\Tpl::get('index/index', ['tpl_last_boards' => $tpl_last_boards,
																'tpl_last_comments' => $tpl_last_comments,
																'tpl_random' => $tpl_random]));
		}
	}