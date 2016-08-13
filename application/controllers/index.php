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
			
			$this->response->set(\Eliya\Tpl::get('index/index', ['tpl_last_boards' => $tpl_last_boards]));
		}
	}