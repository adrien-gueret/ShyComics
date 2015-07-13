<?php
	class Controller_search_index extends Controller_main
	{
		public function post_index($search = null)
		{
			$result = Model_Files::search($search);
			var_dump($result);
		}
	}