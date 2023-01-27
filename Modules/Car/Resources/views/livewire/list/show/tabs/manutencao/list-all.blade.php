<div>

    <div class="card-body">
        @if(count($carLogs) > 0)
            @foreach($carLogs->sortByDesc('date') as $log)
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row" colspan="1">Date:</th>
                                    <td colspan="1"> {{$log->date}}</td>
                                    <th scope="row" colspan="1">Miles:</th>
                                    <td colspan="1">{{$log->miles}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="1">Changes made:</th>
                                    <td colspan="3">
                                        @foreach($carChanges as $change)
                                            @if(in_array($change->id, explode(',',$log->changes)))
                                                {{$change->name}} /
                                            @endif
                                        @endforeach

                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="1">Checklist:</th>
                                    <td colspan="3">
                                        <strong>Oil:</strong>
                                        <span>{{$log->check_oil}}</span> /
                                        <strong>Oil Filter:</strong>
                                        <span>{{$log->check_oil_filter}}</span> /
                                        <strong>Fuel Filter:</strong>
                                        <span>{{$log->check_fuel_filter}}</span> /
                                        <strong>Air Filter:</strong>
                                        <span>{{$log->check_air_filter}}</span> /
                                        <strong>Break:</strong>
                                        <span>{{$log->check_break}}</span> /
                                        <strong>Windshield:</strong>
                                        <span>{{$log->check_windshield}}</span> /
                                        <strong>Tire Pressure:</strong>
                                        <span>{{$log->check_tire_pressure}}</span> /
                                        <strong>Front Tires:</strong>
                                        <span>{{$log->check_front_tires}}</span> /
                                        <strong>Rear Tires:</strong>
                                        <span>{{$log->check_rear_tires}}</span>
                                    </td>

                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <th scope="row" colspan="1">Created by:</th>
                                    <td colspan="1">{{$log->user->name}}</td>
                                    <th scope="row" colspan="1">Updated by:</th>
                                    <td colspan="1">{{$log->edited->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="1">Text:</th>
                                    <td colspan="3"><p>{{$log->text}}</p></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body">
                    <h5>No logs were found for this Vehicle...</h5>
                </div>
            </div>

        @endif
    </div>

</div>
