<?php
	/*
		Controller_index is the default controller called on the website root
	*/
	class Controller_index extends Controller_main
	{
		public function get_index()
		{
			$adresse = $this->request->getBaseURL() . 'public/txt/news.txt';
			$news = file_get_contents($adresse);
			
			$documents = Model_Files::getLastBoards(10);
			$tpl_last_boards = '';
			foreach($documents as $document)
			{
				$tpl_last_boards	.=	\Eliya\Tpl::get('spritecomics/gallery/file', ['document' => $document]);
			}
			
			$random = Model_Files::getRandom();
			(!empty($random)) ? $tpl_random = \Eliya\Tpl::get('spritecomics/gallery/file', ['document' => $random]) : $tpl_random = '';
			
			$comments = Model_Comments::getLastComments(10);
			$tpl_last_comments = \Eliya\Tpl::get('index/last_comments', ['comments' => $comments]);
			
			$populars = Model_Files::getPopulars();
			$tpl_populars = '';
			if(is_array($populars))
			{
				foreach($populars as $popular)
				{
					$tpl_populars	.=	\Eliya\Tpl::get('spritecomics/gallery/file', ['document' => Model_Files::getById($popular->id)]);
				}
			}
            
			\Eliya\Tpl::set([
				'additional_style'	=> '<link rel="stylesheet" type="text/css" href="' . $this->request->getBaseURL() . 'public/css/index.css" />',
            ]);
            
			$this->response->set(\Eliya\Tpl::get('index/index', [
				'tpl_last_boards'	=> $tpl_last_boards,
				'tpl_last_comments' => $tpl_last_comments,
				'tpl_random'		=> $tpl_random,
				'tpl_populars'		=> $tpl_populars,
				'news'				=> Library_Parser::parse($news, $this->request->getBaseURL())
			]));
		}
	}