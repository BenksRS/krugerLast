<div>
    <h4 class="card-title  mb-4">Phones</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        @if($referral->phones->isNotEmpty())

                            <table class="table table-editable table-nowrap table-edits">
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
                                    <tr data-id="1" wire:key="phone-{{$phone->id}}">

                                        @if($edit_id == $phone->id)
                                            {{-- EDIT PHONE --}}


                                                <td>

                                                    <input type="text" class="form-control"  name="contact"
                                                           placeholder="Contact"  wire:model="contact_edit"   required>
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control"   wire:model="phone_edit" name="phone"
                                                           placeholder="Phone"  required>
                                                </td>
                                                <td>
                                                    <button wire:click="update" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bx-save"></i> SAVE</button>
                                                </td>


                                        @else
                                            {{-- SHOW PHONE --}}
                                        <td><small>{{$phone->contact}}</small>  </td>
                                        <td>{{$phone->phone}}</td>
                                        <td>@if($phone->preferred == 'Y')<i class="bx bx-star"></i>@endif</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" wire:click.prevent.lazy="deletePhone({{$phone->id}})"><i class="bx bx-trash"></i></button>
                                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" wire:click.prevent.lazy="editPhone({{$phone->id}})"><i class="bx bx-edit"></i></button>
                                        </td>

                                        @endif

                                    </tr>
                                @endforeach
                                @if($edit_id != $phone->id)

                                <tr wire:key="new_form">
                                    <form class="needs-validation  was-validated" method="post" wire:submit.prevent="addPhone(Object.fromEntries(new FormData($event.target)))"  novalidate>
                                    <td>
                                            <input type="hidden" name="referral_id" value="{{$referral->id}}">
                                        <input type="text" class="form-control"  name="contact"
                                               placeholder="Contact"   wire:model.lazy="contact" required>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="form-control"  name="phone"
                                               placeholder="Phone" wire:model.lazy="phone"  required>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bx-plus"></i> ADD</button>
                                    </td>
                                    </form>
                                </tr>
                                @endif
                                </tbody>
                            </table>

                        @else

                        <div wire:key="formadd">
                            <p>No phones found ...</p>
                            <form class="needs-validation  was-validated"  wire:submit.prevent="addPhone"  novalidate>
                                <td>
                                    <input type="text" class="form-control"  name="contact"
                                           placeholder="Contact"   wire:model="contact" required>
                                </td>
                                <td colspan="2">
                                    <input type="text" class="form-control"  name="phone"
                                           placeholder="Phone" wire:model="phone"  required>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bx-plus"></i> ADD</button>
                                </td>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

            </div>



        </div>
    </div>

</div>
