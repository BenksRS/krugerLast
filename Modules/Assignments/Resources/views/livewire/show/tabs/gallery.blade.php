<div>
    <div class="row">
        <div class="col-lg-9">
            @livewire('assignments::show.tabs.gallery.images', ['assignment' => $assignment->id], key('assignment_show_gallery'))

        </div>
        <div class="col-lg-3">
            @livewire('assignments::show.tabs.gallery.links', ['assignment' => $assignment->id], key('assignment_show_gallery_links'))
        </div>
    </div>
</div>
