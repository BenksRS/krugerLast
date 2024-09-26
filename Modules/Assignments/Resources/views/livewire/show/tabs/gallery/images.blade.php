<div>
    <?php
    //    phpinfo();
    ?>
    <div  wire:sortable-group="updateTaskOrder" >
        <h4 class="card-title mb-4" >1# Picture Front  @if(!$showFront)<button type="button" class="btn btn-warning btn-sm float-end" wire:click="$emit('uploadPics', 'start_job')"><i class="fas fa-plus"></i> <i class="fas fa-images"></i></button>@endif

            @if($listGallery->where('type','start_job')->isNotEmpty())
                <smal style="font-size: 11px;">({{$listGallery->where('type','start_job')->last()->created_date}})</smal>
                @endif
        </h4>
        <div class="card"  wire:key="group-front" wire:sortable.item="start_job">
            <div class="card-body">

                <div class="card task-box">
                    <div class="card-body">
                        <div id="task-1"  >
                            <div id="front-gallery" class="pb-1 task-list" wire:sortable-group.item-group="start_job" style="min-height: 60px">

                                @if($showFront)
                                    @livewire('assignments::show.tabs.gallery.fileupload', ['assignment' => $assignment->id, 'type' => 'start_job'], key('assignment_gallery_fileupload_front'))

                                @else
                                    @if($listGallery->where('type','start_job')->isNotEmpty())
                                        @foreach($listGallery->where('type','start_job') as $imagem)


                                            {{--                                            ITEM --}}
                                            <div class="float-start position-relative">
                                                <div class="image_handler" >
                                                    <i class="fa fa-arrows-alt"></i>
                                                </div>
                                                <div class="delete_image">
                                                    <a class="btn btn-danger" wire:click.prevent="deleteImage({{$imagem->id}})" ><i class="fa fa-trash"></i></a>
                                                </div>
                                                <div class="zoom_image">
                                                    <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery{{$imagem->id}}"><i class="bx bx-zoom-in"></i></button>
                                                    {{--                                            <a class="btn btn-info" wire:click.prevent="deleteImage({{$imagem->id}})" ></a>--}}
                                                </div>
                                                <img class="img-thumbnail" id="upimagem-{{$imagem->id}}" wire:key="imagem-{{$imagem->id}}" wire:sortable-group.item="{{$imagem->id}}" alt="200x200"  src="{{$imagem->b64}}" data-holder-rendered="true">
                                            </div>
                                            {{--                                        MODAL --}}

                                            <div class="modal fade modal_gallery{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            {{--                                                        <h5 class="modal-title" id="myLargeModalLabel">{{$auth->name}}</h5>--}}
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{$imagem->b64}}" class="img-fluid">
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    @else
                                        <h6 class="text-center">No images found ...</h6>
                                    @endif{{-- end show images front --}}

                                @endif {{-- end show upload front --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="card-title mb-4" >2# Inside pictures of the damaged area @if(!$showInside)<button type="button" class="btn btn-warning btn-sm float-end" wire:click="$emit('uploadPics', 'pics_inside')"><i class="fas fa-plus"></i> <i class="fas fa-images"></i></button>@endif

            @if($listGallery->where('type','pics_inside')->isNotEmpty())
                <smal style="font-size: 11px;">({{$listGallery->where('type','pics_inside')->last()->created_date}})</smal>
            @endif
        </h4>
        <div class="card"  wire:key="group-inside" wire:sortable.item="pics_inside">
            <div class="card-body">


                <div class="card">
                    <div class="card-body">
                        <div id="task-1">
                            <div id="inside-gallery" class="pb-1 task-list" wire:sortable-group.item-group="pics_inside">
                                <div class="float-start">
                                    @if($showInside)
                                        @livewire('assignments::show.tabs.gallery.fileupload', ['assignment' => $assignment->id, 'type' => 'pics_inside'], key('assignment_gallery_fileupload_inside'))
                                    @else
                                        @if($listGallery->where('type','pics_inside')->isNotEmpty())
                                            @foreach($listGallery->where('type','pics_inside') as $imagem)
                                                <div class="float-start position-relative imagem_label">
                                                    <div class="col-lg-12">
                                                        <div class="image_handler" >
                                                            <i class="fa fa-arrows-alt"></i>
                                                        </div>
                                                        <div class="delete_image">
                                                            <a class="btn btn-danger" wire:click.prevent="deleteImage({{$imagem->id}})" ><i class="fa fa-trash"></i></a>
                                                        </div>
                                                        <div class="zoom_image">
                                                            <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery{{$imagem->id}}"><i class="bx bx-zoom-in"></i></button>
                                                            {{--                                            <a class="btn btn-info" wire:click.prevent="deleteImage({{$imagem->id}})" ></a>--}}
                                                        </div>
                                                        <div class="edit_image">
                                                            <button type="button" class="btn btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery_category{{$imagem->id}}"><i class="bx bx-edit-alt"></i></button>
                                                        </div>
                                                        <img class="img-thumbnail" id="upimagem-{{$imagem->id}}" wire:key="imagem-{{$imagem->id}}" wire:sortable-group.item="{{$imagem->id}}" alt="200x200"  src="{{$imagem->b64}}" data-holder-rendered="true">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <span style="padding-left: 5px;">{{$imagem->category->name}}</span>
                                                    </div>
                                                </div>
{{--                                            ZOOM MODAL--}}
                                                <div class="modal fade modal_gallery{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">

                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{$imagem->b64}}" class="img-fluid">
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                {{--                                            EDIT CATEGORY MODAL--}}
                                                <div class="modal fade modal_gallery_category{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">

                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">

                                                                        <label class="form-label">Select new Label:</label>
                                                                        <div class="row">
                                                                            @foreach($allCategorys as $row)
                                                                                <div class="col-auto float-start">
                                                                                    <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                                        @if($imagem->category->id == $row->id)
                                                                                            <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$row->id}}" value="{{$row->id}}"  checked="">
                                                                                        @else
                                                                                            <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$row->id}}" wire:click="changeLabel({{$row->id}}, {{$imagem->id}})" value="{{$row->id}}"  data-bs-dismiss="modal" aria-label="Close">
                                                                                        @endif
                                                                                        <label class="form-check-label" for="radio_{{$imagem->id}}_{{$row->id}}">
                                                                                            {{$row->name}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>



{{--                                                                <img src="{{$imagem->b64}}" class="img-fluid">--}}
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            @endforeach
                                        @else
                                            <h6 class="text-center">No images found ...</h6>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="card-title mb-4" >3# Pictures before @if(!$showBefore)<button type="button" class="btn btn-warning btn-sm float-end" wire:click="$emit('uploadPics', 'pics_before')"><i class="fas fa-plus"></i> <i class="fas fa-images"></i></button>@endif
            @if($listGallery->where('type','pics_before')->isNotEmpty())
                <smal style="font-size: 11px;">({{$listGallery->where('type','pics_before')->last()->created_date}})</smal>
            @endif
        </h4>
        <div class="card"  wire:key="group-before" wire:sortable.item="pics_before">
            <div class="card-body">


                <div class="card">
                    <div class="card-body">
                        <div id="task-1">
                            <div id="before-gallery" class="pb-1 task-list" wire:sortable-group.item-group="pics_before">
                                @if($showBefore)
                                    @livewire('assignments::show.tabs.gallery.fileupload', ['assignment' => $assignment->id, 'type' => 'pics_before'], key('assignment_gallery_fileupload_before'))
                                @else
                                    @if($listGallery->whereIn('type',['pics_before', 'pics_the_ladder'])->isNotEmpty())
                                        @foreach($listGallery->whereIn('type',['pics_before', 'pics_the_ladder']) as $imagem)
                                            <div class="float-start position-relative imagem_label">
                                                <div class="col-12">
                                                    <div class="image_handler" >
                                                        <i class="fa fa-arrows-alt"></i>
                                                    </div>
                                                    <div class="delete_image">
                                                        <a class="btn btn-danger" wire:click.prevent="deleteImage({{$imagem->id}})" ><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    <div class="zoom_image">
                                                        <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery{{$imagem->id}}"><i class="bx bx-zoom-in"></i></button>
                                                        {{--                                            <a class="btn btn-info" wire:click.prevent="deleteImage({{$imagem->id}})" ></a>--}}
                                                    </div>
                                                    <div class="edit_image">
                                                        <button type="button" class="btn btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery_category{{$imagem->id}}"><i class="bx bx-edit-alt"></i></button>
                                                    </div>
                                                    <img class="img-thumbnail" id="upimagem-{{$imagem->id}}" wire:key="imagem-{{$imagem->id}}" wire:sortable-group.item="{{$imagem->id}}" alt="200x200"  src="{{$imagem->b64}}" data-holder-rendered="true">
                                                </div>
                                                <div class="col-12">
                                                    <span style="padding-left: 5px;" class="text-uppercase">{{$imagem->label_format ?? ''}}</span>
                                                </div>
                                            </div>

                                            <div class="modal fade modal_gallery{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            {{--                                                        <h5 class="modal-title" id="myLargeModalLabel">{{$auth->name}}</h5>--}}
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{$imagem->b64}}" class="img-fluid">
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            {{--                                            EDIT CATEGORY MODAL--}}
                                            <div class="modal fade modal_gallery_category{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <label class="form-label">Select new Label:</label>
                                                                    <div class="row">
                                                                        @foreach($allTypes['pics_before'] as $label => $labelName)
                                                                            <div class="col-auto float-start">
                                                                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                                    @if($imagem->label == $label)
                                                                                        <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$label}}" value="{{$label}}"  checked="">
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$label}}" wire:click="changeTypeLabel('pics_before', '{{$label}}', {{$imagem->id}})" value="{{$label}}"  data-bs-dismiss="modal" aria-label="Close">
                                                                                    @endif
                                                                                    <label class="form-check-label text-uppercase" for="radio_{{$imagem->id}}_{{$label}}">
                                                                                        {{$labelName}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            {{--                                                                <img src="{{$imagem->b64}}" class="img-fluid">--}}
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    @else
                                        <h6 class="text-center">No images found ...</h6>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="card-title mb-4" >4# Pictures after @if(!$showAfter)<button type="button" class="btn btn-warning btn-sm float-end" wire:click="$emit('uploadPics', 'pics_after')"><i class="fas fa-plus"></i> <i class="fas fa-images"></i></button>@endif
            @if($listGallery->where('type','pics_after')->isNotEmpty())
                <smal style="font-size: 11px;">({{$listGallery->where('type','pics_after')->last()->created_date}})</smal>
            @endif
        </h4>
        <div class="card"  wire:key="group-after" wire:sortable.item="pics_after">
            <div class="card-body">

                <div class="card">
                    <div class="card-body">
                        <div id="task-1">
                            <div id="after-gallery" class="pb-1 task-list"  wire:sortable-group.item-group="pics_after">
                                @if($showAfter)
                                    @livewire('assignments::show.tabs.gallery.fileupload', ['assignment' => $assignment->id, 'type' => 'pics_after'], key('assignment_gallery_fileupload_after'))
                                @else
                                    @if($listGallery->where('type','pics_after')->isNotEmpty())
                                        @foreach($listGallery->where('type','pics_after') as $imagem)
                                            <div class="float-start position-relative imagem_label">
                                                    <div class="col-12">
                                                        <div class="image_handler" >
                                                            <i class="fa fa-arrows-alt"></i>
                                                        </div>
                                                        <div class="delete_image">
                                                            <a class="btn btn-danger" wire:click.prevent="deleteImage({{$imagem->id}})" ><i class="fa fa-trash"></i></a>
                                                        </div>
                                                        <div class="zoom_image">
                                                            <button type="button" class="btn btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery{{$imagem->id}}"><i class="bx bx-zoom-in"></i></button>
                                                            {{--                                            <a class="btn btn-info" wire:click.prevent="deleteImage({{$imagem->id}})" ></a>--}}
                                                        </div>
                                                        <div class="edit_image">
                                                            <button type="button" class="btn btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_gallery_category{{$imagem->id}}"><i class="bx bx-edit-alt"></i></button>
                                                        </div>
                                                        <img class="img-thumbnail" id="upimagem-{{$imagem->id}}" wire:key="imagem-{{$imagem->id}}" wire:sortable-group.item="{{$imagem->id}}" alt="200x200"  src="{{$imagem->b64}}" data-holder-rendered="true">
                                                    </div>
                                                    <div class="col-12">
                                                        <span style="padding-left: 5px;" class="text-uppercase">{{$imagem->label_format ?? ''}}</span>
                                                    </div>
                                           </div>

                                            <div class="modal fade modal_gallery{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{$imagem->b64}}" class="img-fluid">
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            {{--                                            EDIT CATEGORY MODAL--}}
                                            <div class="modal fade modal_gallery_category{{$imagem->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <label class="form-label">Select new Label:</label>
                                                                    <div class="row">
                                                                        @foreach($allTypes['pics_after'] as $label => $labelName)
                                                                            <div class="col-auto float-start">
                                                                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                                                    @if($imagem->label == $label)
                                                                                        <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$label}}" value="{{$label}}"  checked="">
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" id="radio_{{$imagem->id}}_{{$label}}" wire:click="changeTypeLabel('pics_after', '{{$label}}', {{$imagem->id}})" value="{{$label}}"  data-bs-dismiss="modal" aria-label="Close">
                                                                                    @endif
                                                                                    <label class="form-check-label text-uppercase" for="radio_{{$imagem->id}}_{{$label}}">
                                                                                        {{$labelName}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            {{--                                                                <img src="{{$imagem->b64}}" class="img-fluid">--}}
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    @else
                                        <h6 class="text-center">No images found ...</h6>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
