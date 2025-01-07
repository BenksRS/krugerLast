<?php
	
	namespace Modules\Reports\Http\Controllers;
	
	use Illuminate\Contracts\Support\Renderable;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Controller;
	
	class ReportsController extends Controller {
		
		public function __construct()
		{
			$this->middleware('auth:user');
		}
		
		/**
		 * Display a listing of the resource.
		 * @return Renderable
		 */
		public function index()
		{
			return $this->getPageInfo('Reports Info');
		}
        public function mkt()
        {
            return $this->getPageInfo('Reports Mkt', 'mkt');
        }
		public function tags()
		{
			return $this->getPageInfo('Reports Tags', 'tags');
		}
		
		public function nadal()
		{
			return $this->getPageInfo('Reports Nadal', 'nadal');
		}
		
		protected function getPageInfo($title, $view = 'info', $back = 'reports', $back_title = 'Reports') {
		
			$page_info = (object) [
				'title'      => $title,
				'back'       => url($back),
				'back_title' => $back_title
			];
			\session()->flash('page', $page_info);
			$page = \session()->get('page');
			
			$view = 'reports::' . $view;
			
			return view($view, compact('page'));
		}
		
		/**
		 * Show the form for creating a new resource.
		 * @return Renderable
		 */
		public function create()
		{
			return view('reports::create');
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 *
		 * @return Renderable
		 */
		public function store(Request $request)
		{
			//
		}
		
		/**
		 * Show the specified resource.
		 *
		 * @param int $id
		 *
		 * @return Renderable
		 */
		public function show($id)
		{
			return view('reports::show');
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param int $id
		 *
		 * @return Renderable
		 */
		public function edit($id)
		{
			return view('reports::edit');
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param int     $id
		 *
		 * @return Renderable
		 */
		public function update(Request $request, $id)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 *
		 * @return Renderable
		 */
		public function destroy($id) {}
		
	}
