<?php
	class Controller_admin_news extends Controller_admin_main
	{
		public function get_index()
		{
			$adresse = $this->request->getBaseURL() . 'public/txt/news.txt';
			$news = file_get_contents($adresse);
			
			$this->response->set(\Eliya\Tpl::get('admin/news', ['news' => $news]));
		}
		
		public function update_index($news = null)
		{
			file_put_contents('public/txt/news.txt', htmlspecialchars($news, ENT_QUOTES));
			
			$this->response->redirect($this->request->getBaseURL() . 'admin/news');
		}
	}