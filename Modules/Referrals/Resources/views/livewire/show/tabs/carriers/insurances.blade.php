<div>

        <h4 class="card-title  mb-4">Insurance List</h4>
        <div class="card" >
            <div class="card-body">

                <div class="col-lg-8 float-end">
                    <input type="text" class="form-control" placeholder="Search..." wire:model="searchTerm">
                </div>

                <table class="table table-striped mb-0">

                    <thead>
                    <tr>
                        <th>Company Entity (Fictitions)</th>
                        <th>Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $insurance)
                        <tr>
                            <td> {{$insurance->company_entity}}({{$insurance->company_fictitions}})</th>
                            <td>
                                <button type="button" class="btn btn-success btn-sm waves-effect waves-light" wire:click.prevent="addCarrier({{$insurance->id}})" wire:loading.attr="disabled"><i class="fas fa-link"></i></button>
                            </td>

                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="float-end mt-4">
                    {{$list->links()}}
                </div>


            </div>
        </div>



</div>
