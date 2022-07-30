<div>
    <h4 class="card-title mb-4">General Information @if(!$edit)<button type="button" class="btn btn-sm btn-primary  waves-effect waves-light  me-2 float-end" wire:click="tooglleedit"> <i class="bx bx-file font-size-16 align-middle "></i> EDIT</button>@endif</h4>

    <div class="card">
        <div class="card-body">
            {{--kk--}}
            @if(!$edit)
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <tbody>
                    <tr>
                        <th scope="row">Marketing Rep.:</th>
                        <td>

                                @if($referral->marketing)
                                    {{$referral->marketing->name}}
                                @else
                                    -
                                @endif


                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Created by :</th>
                        <td>
                            @if($referral->user_created)
                                {{$referral->user_created->name}}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Create at:</th>
                        <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$referral->created_date}}</h5></td>
                    </tr>
                    <tr>
                        <th scope="row">Last update by :</th>
                        <td>
                            @if($referral->user_updated)
                                {{$referral->user_updated->name}}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Last update at:</th>
                        <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><i class="bx bx-calendar me-1 text-muted"></i>{{$referral->created_date}}</h5></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @else
                <div class="col-lg-12">
                    <div class="mb-3" >
                        <label class="form-label">Marketing Rep.</label>
                        <select class=" form-control select2-multiple select_carrier"
                        wire:model="marketing_id" name="marketing_id" data-placeholder="Select ...">
                            <option selected>chose...</option>
                            @foreach($marketingList as $row)
                                    <option {{$marketingSelected == $row->id ? ' selected': ' '}}  value="{{$row->id}}">{{$row->user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div  class="col-lg-12 ">
                    <button class="btn btn-lg btn-success mt-2 float-end" wire:click="updateMarketing" type="button" >SAVE</button>
                </div>
            @endif
        </div>
    </div>
</div>
