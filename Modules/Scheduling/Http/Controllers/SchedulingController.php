<?php
	
	namespace Modules\Scheduling\Http\Controllers;
	
	use Illuminate\Routing\Controller;
	
	class SchedulingController extends Controller {
		
		public function __construct ()
		{
			$this->middleware('auth:user');
		}
		
		/**
		 * Display a listing of the resource.
		 * @return Renderable
		 */
		public function index ()
		{
			return view('scheduling::new');
		}
		
		public function new ()
		{
		
		}
		
		public function techs ()
		{
			return view('scheduling::techs');
		}
		
	}
