<div>
    @if(session()->has('reloadForms'))
        <div  class="alert alert-{{session('reloadForms')['class']}}" x-init="setTimeout(() => show = false, 3000)">
            {!! nl2br(session('reloadForms')['message']) !!}
        </div>
        <script>
            setTimeout(function() {
                $('.alert-success').fadeOut('fast');
                // $('.alert-success').fadeOut('fast');
            }, 2000);
        </script>
    @endif
    <h4 class="card-title mb-4">Forms List <button type="button" class="btn btn-sm btn-warning  waves-effect waves-light  me-2 float-end" wire:click="reloadForms"> <i class="fas fa-undo-alt font-size-16 align-middle "></i> Reload</button></h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-nowrap align-middle table-hover mb-0">
                    <tbody>
                    @if($listAuth->isNotEmpty())
                        @foreach($listAuth as $auth)
                            <!--                        --><?php //dd($auth)?>
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                   <i class="bx bxs-file-pdf"></i>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 mb-1">{{$auth->name}}</h5>

                                </td>
                                <td>
                                    <div class="float-end">

                                        @if(count($assignment->signs) > 0)
                                            <a target="_blank" href="{{ url("/assignments/pdfauth/$assignment->id/$auth->id") }}" class="text-dark"><i class="bx bx-link-alt h3 m-0"></i></a>
                                        @else
                                            <small>Waiting signture.</small>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <h6 class="text-center">No forms assigned for this job ...</h6>
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
