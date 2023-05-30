<div>
    @foreach ($types as $type)
        @livewire('car::list.show.tabs.files.upload', ['type' => $type, 'car' => $car->id], key('car::files.upload.' . $type['key']))
    @endforeach
</div>
