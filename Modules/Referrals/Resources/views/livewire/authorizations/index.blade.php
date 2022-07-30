<div>
    <div class="row">

{{--kk--}}
        <div class="col-lg-8">
            @if($showUploading)
                <form wire:submit.prevent="save" >

                    <div class="input-group">
                        <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model="newauth" name="newauth">
                        <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload new Authorization</button>
                    </div>
                    @error('newauth')<span class="alert-danger error">{{ $message }}</span> @enderror

                </form>
            @else
                <button type="button" class="btn btn-warning btn-sm float-end" wire:click="$emit('uploadAuth')"><i class="fas fa-plus"></i> <i class="fas fa-file-pdf"></i> Authorization</button>
            @endif

        </div>
        <div class="col-lg-4 float-end " >
            <div class="card">
                <input type="text" class="form-control" placeholder="Search..." wire:model="searchAuth">
            </div>
        </div>
    </div>
    <div class="row">

        @foreach($list as $auth)
            <!-- start auth card -->
            <div class="col-lg-4">
                <div class="card task-boxq" id="uptask-1">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-4">
                                <img class="img-thumbnail" id="uptask-1" alt="200x200" width="100" src="{{$auth->b64}}">
                            </div>

                            <div class="col-lg-6">
                                <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark" id="task-name">{{$auth->name}}</a></h5>
                                <p class="text-muted mb-4"><smal><i>Description:</i></smal><br> {{$auth->description}}</p>
                                <button type="button" class="btn btn-sm btn-outline-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal_auth{{$auth->id}}"><i class="bx bx-zoom-in font-size-16 align-middle "></i>View</button>
                                <a href="{{ url("/referrals/authorizations/show/$auth->id") }}" class="btn btn-sm btn-primary waves-effect waves-light me-2"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade modal_auth{{$auth->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">{{$auth->name}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{$auth->b64}}" class="img-fluid" alt="{{$auth->description}}">
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


            </div>
            <!-- end auth card -->
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12 float-end">
            {{$list->links()}}
        </div>
    </div>
    <div>
