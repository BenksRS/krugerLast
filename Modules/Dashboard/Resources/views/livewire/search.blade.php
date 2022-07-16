<div>
    <form class="app-search d-lg-grid">
        <div class="position-relative col-lg-12">
            <input type="text" class="form-control input-group-lg" wire:model="searchAll" placeholder="Search here.. #Job ID  #Name" >
            <span class="bx bx-search-alt"></span>
        </div>

        @if($searchAll)
            <div class="search-box-result">
                <div class="card">
                    <div class="card-body">
<div class="row">
<div class="col-lg-12">

                        @if($jobs->isNotEmpty())
                            <div class="col-lg-3">
                            <h4>Jobs</h4>
                            <table class="table table-sm m-0">
                                <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <th scope="row"><a href="{{url('assignments/show/'.$job->id)}}">{{$job->full_name}}</a></th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        @endif


{{--                            @if($refs->isNotEmpty())--}}
{{--                            <div class="col-lg-3">--}}
{{--                                <h4>Referrals</h4>--}}
{{--                                <table class="table table-sm mt-2">--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($refs as $ref)--}}
{{--                                        <tr>--}}
{{--                                            <th scope="row"><a href="{{url('referrals/show/'.$ref->id)}}">{{$ref->full_name}}</a></th>--}}
{{--                                            <td>{{$ref->address->message}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            @endif--}}

{{--</div>--}}
</div>
{{--                            @if($invoices->isNotEmpty())--}}
{{--                                <h4>Invoice</h4>--}}
{{--                                <table class="table table-sm mt-2">--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($invoices as $inv)--}}
{{--                                        <tr>--}}
{{--                                            <th scope="row"><a href="{{url('assignments/show/'.$inv->assignment_id)}}">Invoice ID:{{$inv->invoice_id}}</a></th>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            @endif--}}



                    </div>
                </div>
            </div>
        @endif

    </form>
</div>
