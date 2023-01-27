<div>
    <h4 class="card-title mb-4">Maintenance log
        @if($show)
            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="$emit('addMaintenance')"> <i class="bx bx-plus font-size-16 align-middle "></i> NEW</button>
        @endif
    </h4>

    @if(!$show)
        {{--    form create a new one     --}}
        @livewire('car::list.show.tabs.manutencao.add', ['car' => $car->id], key('car_manutencao_add'))
    @else
        {{--    show list     --}}
        @livewire('car::list.show.tabs.manutencao.list-all', ['car' => $car->id], key('car_manutencao_list_all'))
    @endif

</div>
