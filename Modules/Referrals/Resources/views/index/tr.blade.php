<tr>
    <td>{{$row->id}}</td>
    <td><a href="{{url('referrals/show/'.$row->id)}}">{{"$row->company_entity ($row->company_fictitions) "}}</a></td>
    <td><small>{{$row->type->name}}</small></td>
    <td><span class="badge  bg-success">ACTIVe</span>	</td>
    <td><small>{{ empty($row->street) ? " no address ..."  :   "$row->street, $row->city, $row->state - $row->zipcode"}}</small></td>
{{--    <td><a href="javascript: void(0);">Pfaadt, Allen #29669</a></td>--}}
{{--    <td><p>ROOF TARP,<br> TREE REMOVAL</p></td>--}}
{{--    <td><span class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"> <small><i class="bx bx-calendar me-1 text-muted"></i>20 Oct, 2021</small></span> <small>04 PM</small> <br><i class="bx bx-user"></i> <small>Rafael</small></td>--}}
{{--    <td>Lakewood Ranch</td>--}}
{{--    <td>FL</td>--}}
{{--    <td><small>(504) 264-8448</small></td>--}}
{{--    <td></td>--}}
{{--    <td><small>Kyle Bauer</small></td>--}}
{{--    <td><h5 class="font-size-14" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Dol Date"><small><i class="bx bx-calendar me-1 text-muted"></i>20 Oct, 2021</h5></small></td>--}}
</tr>
