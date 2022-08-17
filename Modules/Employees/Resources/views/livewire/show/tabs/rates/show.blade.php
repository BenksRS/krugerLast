<div>
    <div class="row">

        <div class="col-lg-4 col-md-12">
            <h4 class="card-title mb-4">Rate Type</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Rate Type :</th>
                                <td> {{$rate->type_name}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <h4 class="card-title mb-4">Regular Rates Amount</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Regular Day:</th>
                                <td> ${{$rate->regular_day}} </td>
                            </tr>
                            <tr>
                                <th scope="row">Weekend Day:</th>
                                <td> ${{$rate->weekend_day}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <h4 class="card-title mb-4">Extras Rates Amount</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                            <tr>
                                <th scope="row">Sleep Out:</th>
                                <td> ${{$rate->sleep_out}} </td>
                            </tr>
                            <tr>
                                <th scope="row">Hurricane:</th>
                                <td> ${{$rate->hurricane}} </td>
                            </tr>
                            <tr>
                                <th scope="row">On call:</th>
                                <td> ${{$rate->oncall}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>



</div>
