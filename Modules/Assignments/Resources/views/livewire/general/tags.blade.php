<div>
    <div class="row">
        <div class="col-lg-6">

            <h4 class="card-title mb-4">TAGS <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="addTags"> <i class="bx bx-plus font-size-16 align-middle "></i> NEW TAG</button></h4>
            @if($addTag)
                <div class="row mb-3">
                    <div class="col-md-10">
                        <label  class="form-label">Tag name</label>
                        <input type="text" class="form-control "  name="new_tag" placeholder="new tag name" wire:model="new_tag"  required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        @error('street')
                        <div class="invalid-feedback">
                            Please type a valid option.
                        </div>
                        @enderror
                    </div>
                    <div  class="col-md-2 ">
                        <button class="btn  btn-lg btn-success mt-4 float-start" {{isset($new_tag) ? ' ': 'disabled'}} wire:click.prevent="addNewTag"  type="button"   >ADD</button>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            @foreach($tags->sortByDesc('id') as $tag)
                                <tr>
                                    <th scope="row"><label class="form-check-label" for="tag{{$tag->id}}">{{$tag->name}}</label> </th>
                                    <td class="font-size-11">

                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input wire:change="changeTags({{$tag->id}})" class="form-check-input" {{$tag->active == 'Y' ? 'checked' : ''}} type="checkbox" id="tag{{$tag->id}}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <h4 class="card-title mb-4">EVENTS <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click.prevent="addEvents"> <i class="bx bx-plus font-size-16 align-middle "></i> NEW EVENT</button></h4>
            @if($addEvent)
                <div class="row mb-3">
                    <div class="col-md-10">
                        <label  class="form-label">Event name</label>
                        <input type="text" class="form-control "  name="new_event"
                               placeholder="new event name" wire:model="new_event"  required>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        @error('street')
                        <div class="invalid-feedback">
                            Please type a valid option.
                        </div>
                        @enderror

                    </div>
                    <div  class="col-md-2 ">
                        <button class="btn  btn-lg btn-success mt-4 float-start" {{isset($new_event) ? ' ': 'disabled'}}  wire:click.prevent="addNewEvent"  type="button"   >ADD</button>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            @foreach($events->sortByDesc('id') as $event)
                                <tr>
                                    <th scope="row"><label class="form-check-label" for="tag{{$event->id}}">{{$event->name}}</label> </th>
                                    <td class="font-size-11">

                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input wire:change="changeEvents({{$event->id}})" class="form-check-input" {{$event->active == 'Y' ? 'checked' : ''}} type="checkbox" id="tag{{$event->id}}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
