<div>
    {{--kk--}}
    <h4 class="card-title  mb-4">All AUthorizations</h4>
    <div class="card">
        <div class="card-body">

            <div class="col-lg-12 float-end">
               <input type="text" class="form-control" placeholder="Search..." wire:model="searchTerm">
            </div>

            <table class="table table-striped mb-0">

                <thead>
                <tr>
                    <th>Auth</th>
                    <th>Descritpion</th>
                    <th>ACTION</th>
                </tr>
                </thead>

                <tbody>

                @if(count($list) == 0)
                    <tr>
                        <td colspan="3">
                            <h5 class="font-size-15 text-center not_found"> No authorization found... </h5>
                        </td>
                        </td>
                    </tr>
                @else
                    @foreach($list as $row)
                        <tr>
                            <td>
                                <img class="img-thumbnail" id="authaddimg-{{$row->id}}" alt="200x200" height="100" src="{{$row->b64}}" data-holder-rendered="true">
                            </td>
                            <td> <p class="text-muted mb-4">{{$row->name}}</p></td>

                            <td>
                                <button type="button" class="btn btn-success  waves-effect waves-light vertical-center" wire:click.prevent="addAuth({{$row->id}})"><i class="fas fa-link"></i></button>
                            </td>
                        </tr>

                    @endforeach


                @endif
                </tbody>
            </table>
            <div class="float-end mt-4">
                {{$list->links()}}
            </div>


        </div>
    </div>



</div>
