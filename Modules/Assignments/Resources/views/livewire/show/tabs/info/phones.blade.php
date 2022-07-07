<div>

    <h4 class="card-title  mb-4">Phones</h4>
    <div class="card">
        <div class="card-body">











            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        @if($listPhones->isNotEmpty())
{{--// LIST IF HAVE PHONES--}}
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
                                @foreach($listPhones as $phone)
                                    <tr data-id="1" wire:key="phone-{{$phone->id}}">

                                        @if($edit_id == $phone->id)
                                            {{-- EDIT PHONE --}}
                                            <td>

                                                <input type="text" class="form-control"  name="contact"
                                                       placeholder="Contact"  wire:model="contact_edit"   required>
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="form-control"  wire:model.debounce.500ms="phone_edit" name="phone"
                                                       placeholder="Add Phone"  required>
                                            </td>
                                            <td>
                                                <button wire:click.prevent.lazy="update" class="btn btn-success btn-sm waves-effect waves-light"><i class="bx bx-save"></i> SAVE</button>
                                            </td>
                                        @else
                                            {{-- SHOW PHONE --}}
                                            <td><small>{{$phone->contact}}</small>  </td>
                                            <td>{{$phone->phone}}</td>
                                            <td>@if($phone->preferred == 'Y')<i class="bx bx-star"></i>@endif</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" wire:click="deletePhone({{$phone->id}})"><i class="bx bx-trash"></i></button>
                                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" wire:click="editPhone({{$phone->id}})"><i class="bx bx-edit"></i></button>
                                            </td>

                                        @endif

                                    </tr>
                                @endforeach
                                @if($edit_id != $phone->id)

                                    <tr wire:key="new_form">

                                            <td>
                                                <input type="hidden" name="assignment_id" value="{{$assignment->id}}">
                                                <input type="text" class="form-control"  name="contact"
                                                       placeholder="Add New Contact"   wire:model.lazy="contact" required>
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="form-control"  name="phone" placeholder="Add new Phone" wire:model.debounce.500ms="phone"  required>
                                                @error('phone')
                                                <div class="invalid-feedback show">
                                                    Please type a valid Phone number.
                                                </div>
                                                @enderror


                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" wire:click="addPhone" ><i class="bx bx-plus"></i> ADD</button>
                                            </td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        @else
{{--// LIST IF NO HAVE PHONES--}}
                            <div wire:key="formadd">



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
                                        <tr>
                                        <td colspan="4">  <p class="text-center">No phones found ...</p>  </td>
                                        </tr>
                                        <tr>

                                            <td>
                                                <input type="text" class="form-control"  name="contact"
                                                       placeholder="Add Contact"   wire:model="contact" >
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="form-control"  name="phone" placeholder="Add Phone" wire:model.debounce.500ms="phone"  required>
                                                @error('phone')
                                                    <div class="invalid-feedback show">
                                                        Please type a valid Phone number.
                                                    </div>
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" wire:click="addPhone" ><i class="bx bx-plus"></i> ADD</button>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>


                            </div>
                        @endif
                    </div>
                </div>

            </div>



        </div>
    </div>

</div>
