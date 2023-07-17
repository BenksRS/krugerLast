<div>
    @foreach ($docs as $doc)
    @livewire('employees::show.tabs.docs.upload', ['type' => $doc, 'user' => $user->id], key('employees::docs.upload.' . $doc['key']))
    @endforeach
</div>