<div>


    @if($showUploading)
        <h4 class="card-title mb-4">DocSign List <button type="button" class="btn btn-sm btn-secondary  waves-effect waves-light  me-2 float-end" wire:click="reloadForms"> <i class="fas fa-arrow-left  align-middle "></i> Back</button></h4>
        <form wire:submit.prevent="save"  >

            <div class="input-group">
                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="newauth" name="newauth">
                <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04" wire:loading.attr="disabled">Upload DocSign</button>
            </div>
            @error('newauth')<span class="alert-danger error">{{ $message }}</span> @enderror
            <div wire:loading wire:target="newauth"><i class="fa fa-spinner"></i> Uploading...</div>
        </form>
        <hr>
    @else
        <h4 class="card-title mb-4">DocSign List
{{--            <button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click="addFormQueue('forms')"> <i class="fas fa-file-upload  align-middle "></i> Send Gdrive</button>--}}
            <button type="button" class="btn btn-warning btn-sm me-2  float-end" wire:click="$emit('uploadAuth')"><i class="fas fa-plus"></i> <i class="fas fa-file-pdf"></i> DocuSign</button></h4>
    @endif
    <div class="card">
        <div class="card-body">

{{--            @if( isset($quee_forms->status) &&  in_array($quee_forms->status, ['pending', 'processing']))--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12" wire:poll.1s="reloadInfo">--}}
{{--                        <h5 class="font-size-10 mt-2">Syncing all Docusign Google Drive:</h5><span>{{$quee_forms->status}}</span>--}}
{{--                        <div  class="alert alert-warning">--}}
{{--                            <p> {!! nl2br($quee_forms->history) !!}</p>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}




            <div class="table-responsive">
                <table class="table table-nowrap align-middle table-hover mb-0">
                    <tbody>
                    @if($listAuth->isNotEmpty())
                        @foreach($listAuth as $auth)
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                   <i class="bx bxs-file-pdf"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-10 mb-1">{{$auth->name}}</h5>
                                </td>
                                <td>
                                    <div class="float-end">
                                            <a target="_blank" href="{{ url("/assignments/docsignfile/$auth->id") }}" class="text-dark"><i class="bx bx-link-alt h3 m-0"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <h6 class="text-center">No DocSign`s for this job ...</h6>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <br>
                {{--                <button type="button" class="btn btn-warning  waves-effect waves-light  me-2 float-end"> <i class="bx bx-loader-alt font-size-16 align-middle me-2"></i>Update files</button>--}}
            </div>
        </div>
    </div>
</div>
