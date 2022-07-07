<h4 class="card-title mb-4">Contact Information</h4>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-nowrap mb-0">
                <tbody>
                <tr>
                    <th scope="row">ADDRESS :</th>
                    <td class="font-size-11"><a href="{{$referral->address->link}}" target="{{$referral->address->target}}" > {{$referral->address->message}} </a> </td>
                </tr>
                <tr>
                    <th scope="row">E-mail :</th>
                    <td>
                        <a href="javascript: void(0);" id="inline-username" data-type="text" data-pk="1" data-title="Enter username">{{$referral->email}}</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <h4 class="card-title  mb-4">Phones</h4>
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
        @if($referral->phones->isNotEmpty())

            <table class="table table-editable table-nowrap align-middle table-edits">
                <thead>
                <tr>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>Preferred</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($referral->phones as $phone)
                <tr data-id="1">
                    <td><small>{{$phone->contact}}</small>  </td>
                    <td>{{$phone->phone}}</td>
                    <td>@if($phone->preferred == 'Y')<i class="bx bx-star"></i>@endif</td>
                    <td><button type="button" class="btn btn-danger btn-sm waves-effect waves-light"><i class="bx bx-trash"></i></button></td>
                </tr>
                @endforeach

                </tbody>
            </table>

            @else
                <p>sem fones</p>
            @endif
        </div>
        <button type="button" class="btn btn-sm btn-success  waves-effect waves-light float-end"> <i class="bx bxs-bookmark-plus font-size-16 align-middle me-2"></i>Add Phone</button>

    </div>
</div>
