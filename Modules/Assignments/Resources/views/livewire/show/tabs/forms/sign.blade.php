<div>
    <h4 class="card-title mb-4">Signatures</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-nowrap align-middle table-hover mb-0">

                    <tbody>
                    @if($listSigns->isNotEmpty())
                        @foreach($listSigns as $sign)
                            <tr>
                                <td>
                                    <img class="img-thumbnail-sign" alt="200x200"  src="{{$sign->b64}}" data-holder-rendered="true">

                                </td>
                                <td>
                                    <h2>{{$sign->date_signed}}</h2>
                                </td>
                                <td>
                                    @if($sign->preferred == 'Y')
                                        <h6 class="float-end">SELECTED</h6>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm float-end"   wire:click="$emit('selectSign', {{$sign->id}})" wire:loading.remove>SELECT</button>

{{--                                        <button type="button"  wire:click="$emit('selectSign', '{{$sign->id}}')"  class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end"> </button>--}}
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <h6 class="text-center">No signture for this job ...</h6>
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
