<div>
    <h4 class="card-title mb-4">Google Drive Folders &  Files</h4>
    <div class="card">
        <div class="card-body">
            {{--            @dump($gdrive)--}}
            @if($gdrive)
                <div>
                    @if( isset($quee_files->status) &&  in_array($quee_files->status, ['pending', 'processing']))
                        <div class="row">
                            <div class="col-lg-12" wire:poll.1s="reloadInfo">
                                <h5 class="font-size-10 mt-2">Syncing all files Google Drive:</h5><span>{{$quee_files->status}}</span>
                                <div  class="alert alert-warning">
                                    <p> {!! nl2br($quee_files->history) !!}</p>

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <button wire:click="addFilesQueue" type="button" class="btn btn-warning  waves-effect waves-light  me-2 float-end"> <i class="bx bx-loader-alt font-size-16 align-middle me-2"></i>Update files</button>
                            </div>
                        </div>
                        <hr>
                    @endif

                    <div class="col-lg-12">
                    <table class="table  table-hover mb-0">
                        <tbody>

                        @if($gdrive->job_link)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-folder-open"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-12 mb-1">Google Drive</h5>


                                </td>
                                <td>
                                    <div class="text-center">
                                        {{--                                    <a href="javascript: void(0);" class="text-dark"><i class="bx bx-copy h3 m-2"></i></a>--}}
                                        <a href="{{$gdrive->job_link}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @if($gdrive->kruger_pictures_link)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-folder-open"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-12 mb-1">Kruger Pictures</h5>


                                </td>
                                <td>
                                    <div class="text-center">
                                        {{--                                    <a href="javascript: void(0);" class="text-dark"><i class="bx bx-copy h3 m-2"></i></a>--}}
                                        <a href="{{$gdrive->kruger_pictures_link}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @if($gdrive->pics_link)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-folder-open"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-12 mb-1">Pics Only</h5>


                                </td>
                                <td>
                                    <div class="text-center">
                                        {{--                                    <a href="javascript: void(0);" class="text-dark"><i class="bx bx-copy h3 m-2"></i></a>--}}
                                        <a href="{{$gdrive->pics_link}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @if($gdrive->forms_link)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-folder-open"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-12 mb-1">Forms</h5>


                                </td>
                                <td>
                                    <div class="text-center">
                                        {{--                                    <a href="javascript: void(0);" class="text-dark"><i class="bx bx-copy h3 m-2"></i></a>--}}
                                        <a href="{{$gdrive->forms_link}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="width: 45px;">
                                <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-file-pdf"></i>
                                </span>
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-12 mb-1">Kruger Labeled Pics</h5>


                            </td>
                            <td>
                                <div class="text-center">
                                    <a href="{{url("/assignments/pdfgallerylabel/$assignment->id")}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45px;">
                                <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-file-pdf"></i>
                                </span>
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-12 mb-1">Kruger Pics</h5>


                            </td>
                            <td>
                                <div class="text-center">

                                    <a href="{{url("/assignments/pdfgallery/$assignment->id")}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45px;">
                                <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-file-pdf"></i>
                                </span>
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-12 mb-1">Before Pics</h5>


                            </td>
                            <td>
                                <div class="text-center">

                                    <a href="{{url("/assignments/pdfgallerybefore/$assignment->id")}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 45px;">
                                <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                    <i class="bx bxs-file-pdf"></i>
                                </span>
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-12 mb-1">After Pics</h5>


                            </td>
                            <td>
                                <div class="text-center">

                                    <a href="{{url("/assignments/pdfgalleryafter/$assignment->id")}}" target="_blank" class="text-dark"><i class="bx bx-link-alt h3 m-2"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>


                </div>
            @else

                @if( isset($quee_dir->status) &&  in_array($quee_dir->status, ['pending', 'processing']))
                <div class="row">
                    <div class="col-lg-12" wire:poll.1s="reloadInfo">
                        <h5 class="font-size-12 mt-2">Creating directory :</h5><span>{{$quee_dir->status}}</span>
                        <div  class="alert alert-warning">
                            {!! nl2br($quee_dir->history) !!}
                        </div>
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="font-size-12 mt-2">Google Drive not found!</h5>

                        </div>
                        <div class="col-lg-6">
                            <button wire:click="addDirQuee" type="button" class="btn btn-primary  waves-effect waves-light  me-2 float-end"> <i class="bx bx-add-to-queue font-size-16 align-middle me-2"></i>Create Gdrive</button>
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>

</div>
