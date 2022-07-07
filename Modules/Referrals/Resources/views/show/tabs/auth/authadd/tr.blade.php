<tr>
    <td>
        <img class="img-thumbnail" id="uptask-1" alt="200x200" width="100" src="{{$row->b64}}" data-holder-rendered="true">
    </td>
    <td> <p class="text-muted mb-4">{{$row->name}}</p></td>

    <td><a href="{{ route('referrals.ref_auth_sync') }}" type="button" class="btn btn-danger waves-effect waves-light vertical-center" data-id="{{$row->id}}" data-referral_id="{{$referral->id}}"  data-method="POST" data-action="add" data-target=".auth_list">ADD</a>	</td>
</tr>
