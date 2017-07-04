<?php
	class Controller_search_index extends Controller_main
	{
		public function post_index($search = null, $search_files, $search_dirs, $search_users)
		{
			$result = Model_Files::search($search, isset($search_files), isset($search_dirs), isset($search_users));

            $view	=	\Eliya\Tpl::get('search/index', [
                'resultsUsers' => $result[0],
                'resultsFiles' => $result[1],
                'resultsDirs' => $result[2],
            ]);
            $this->response->set($view);
		}
	}