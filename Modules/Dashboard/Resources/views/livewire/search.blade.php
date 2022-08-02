<div>
    <form class="app-search d-none d-lg-block">
        <form class="app-search d-lg-grid">
            <div class="position-relative col-lg-12">
                <input type="text" class="form-control input-group-lg" wire:model="searchAll" placeholder="Search here.. #Job ID  #Name #Claim Number" >
                <span class="bx bx-search-alt"></span>
            </div>

            @if($searchAll)
                <div class="search-box-result">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    @if($jobs->isNotEmpty())
                                        <div class="col-lg-6">
                                            <h4>Jobs</h4>
                                            <table class="table table-sm m-0">
                                                <tbody>
                                                @foreach($jobs as $job)
                                                    <tr>
                                                        <td ><a href="{{url('assignments/show/'.$job->id)}}">{{$job->full_name}}</a> </td>
                                                        <td > {{$job->claim_number}} </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                </div>




                            </div>
                        </div>
                    </div>
            @endif

        </form>
    </form>
    <div class="dropdown d-inline-block d-lg-none ms-2">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 {{(isset($searchAll)) ? ' show' : ' '}}"
             aria-labelledby="page-header-search-dropdown">

            <form class="p-3">
                <div class="form-group m-0">
                    <div class="input-group">
                        {{--                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Search input">--}}
                        <input type="text" class="form-control" wire:model="searchAll" placeholder="Search here.. #Job ID  #Name" >
                    </div>
                    @if($searchAll)

                        @foreach($jobs as $job)
                            <div class="mt-2">
                            <a href="{{url('assignments/show/'.$job->id)}}">{{$job->full_name}}</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>
</div>
