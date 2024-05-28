<?php
	
	namespace Modules\Scheduling\Http\Livewire\Techs;
	
	use Livewire\Component;
	use Modules\User\Entities\Techs;
	
	class Item extends Component {
		
		public $tech;
		public $active;
		
		protected $listeners = [
		
		];
		
		public function mount(Techs $tech)
		{
			$this->tech = $tech;
			$this->active = $this->tech->active == 'Y' ? true : false;
		}
		
		public function changeActive() {
			$this->tech->active = $this->active ? 'Y' : 'N';
			$this->tech->save();
		}
		
		public function updateTech ($data)
		{
			$this->tech->update($data);
		}
		
		
		public function render ()
		{
			return view('scheduling::livewire.techs.item');
		}
		
	}