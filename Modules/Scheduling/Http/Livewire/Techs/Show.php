<?php
	
	namespace Modules\Scheduling\Http\Livewire\Techs;
	
	use Livewire\Component;
	use Modules\User\Entities\Techs;
	
	class Show extends Component {
		
		public    $techs;
		
		public    $isModalOpen = FALSE;
		
		public    $editTech;
		
		protected $listeners   = [
		
		];
		
		public function mount ()
		{
			$this->techs = $this->getTechs();
		}
		
		private function getTechs ()
		{
			return Techs::with('user')->orderBy('order')->get();
		}
		
		public function updateOrder ($list)
		{
			foreach ( $list as $item ) {
				Techs::find($item['value'])->update(['order' => $item['order']]);
			}
			$this->techs = $this->getTechs();
		}

		
		public function render ()
		{
			return view('scheduling::livewire.techs.show');
		}
		
	}