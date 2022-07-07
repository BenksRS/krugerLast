<div>
    @if($showEditAuth)

{{--    <h4 class="card-title mb-4">Edit Authorizathion  </h4>--}}
{{--        <input type="text" class="form-control" name="name"  wire:model.debounce.500ms="auth_name"  value="{{$field->height}}" >--}}
    <div class="card">
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-lg-5">
                    <label for="formrow-firstname-input" class="form-label">Authorizathion Name:</label>
                    <input type="text" class="form-control" id="auth_name" wire:model="auth_name_new" placeholder="" autocomplete="nope" value="{{$auth_name}}">
                </div>
                <div class="col-lg-5">
                    <label for="formrow-firstname-input" class="form-label">Description:</label>
                    <input type="text" class="form-control" id="auth_name" wire:model="auth_description" placeholder="" autocomplete="nope" value="{{$auth_description}}">
                </div>
                <div class="col-lg-auto">
                    <button type="button" class="btn btn-success float-end waves-effect waves-light mt-4"  wire:click="updateName" ><i class="bx bx-save"></i> Save</button>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-4">
                    <h4 class="card-title-desc mb-4">Custom Field </h4>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Field name</th>
                                <th>Width</th>
                                <th>Heigth</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($field_authorizations as $field)
                                <tr>
                                        <th class="card-title-desc" scope="row">{{$field->field}}</th>
                                        <td>
                                            <input type="number" class="form-control" name="length" wire:model.debounce.500ms="customFields.{{$field->id}}.length" placeholder="" name="length" autocomplete="nope" value="{{$field->length}}" >
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="height"  wire:model.debounce.500ms="customFields.{{$field->id}}.height"  placeholder="" name="height" autocomplete="nope" value="{{$field->height}}" >
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger float-end waves-effect waves-light" wire:click="removeField({{$field->id}})" ><i class="bx bx-trash"></i></button>
                                        </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <h4 class="card-title-desc mb-4">Add Field</h4>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Field Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fieldsOpen as $field)
                                <tr class="">
                                    <th class="card-title-desc" scope="row">{{$field}}</th>
                                    <td>
                                        <button type="button" class="btn btn-success float-end waves-effect waves-light"  wire:click="addField('{{$field}}')" ><i class="bx bx-plus"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-8">

                        <iframe id="iframe" width="760px" height="1100px" src="{{$url_pdf}}"></iframe>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@push('js')
    <script>
         document.addEventListener("livewire:load", function (event) {
            @this.on('reloadIframe', function () {
                 setTimeout(function() {
                    document.getElementById('iframe').contentWindow.location.reload();
                 },700);
            });
        });
    </script>
@endpush
