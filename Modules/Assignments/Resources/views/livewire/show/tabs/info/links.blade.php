<div>

   <h4 class="card-title  mb-4">Links</h4>
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-lg-12">
               <div class="">
                  @if($listLinks->isNotEmpty())
                     {{--// LIST IF HAVE linkS--}}
                     <table class="table table-editable table-nowrap table-edits">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Link</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($listLinks as $link)
                              <tr data-id="1" wire:key="link-{{$link->id}}">
                                 @if($edit_id == $link->id)
                                    <td>
                                       <input type="text" class="form-control" name="name" placeholder="Name" wire:model.lazy="name_edit">
                                    </td>
                                    <td>
                                       <input type="text" class="form-control" name="link" placeholder="Link" wire:model.lazy="link_edit">
                                       @error('link')
                                       <div class="invalid-feedback show">Please type a valid link.</div>
                                       @enderror
                                    </td>
                                    <td>
                                       <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" wire:click="updateLink"><i class="bx bx-save"></i> SAVE</button>
                                    </td>
                                 @else
                                    <td><small>{{$link->name}}</small></td>
                                    <td>
                                       <a href="{{ $link->link_view['hyperlink'] }}" target="_blank" rel="noopener noreferrer">
                                          {{ $link->link_view['label'] }}
                                       </a>
                                    </td>
                                    <td>
                                       <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" wire:click="deleteLink({{$link->id}})"><i class="bx bx-trash"></i></button>
                                       <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" wire:click="editLink({{$link->id}})"><i class="bx bx-edit"></i></button>
                                    </td>
                                 @endif
                              </tr>
                           @endforeach
                           @if($edit_id != $link->id)
                              <tr wire:key="new_form">
                                 <td>
                                    <input type="hidden" name="assignment_id" value="{{$assignment->id}}"> 
                                    <input type="text" class="form-control" name="name" placeholder="Add New Name" wire:model.lazy="name">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control" name="link" placeholder="Add New Link" wire:model.lazy="link">
                                    @error('link')
                                    <div class="invalid-feedback show">Please type a valid link.</div>
                                    @enderror
                                 </td>
                                 <td>
                                    <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" wire:click="addLink"><i class="bx bx-plus"></i> ADD</button>
                                 </td>
                              </tr>
                           @endif
                        </tbody>
                     </table>

                  @else
                     <div wire:key="formadd">
                        <table class="table table-editable table-nowrap table-edits">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Link</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td colspan="3"><div class="text-center">No links found ...</div></td>
                              </tr>
                              <tr>
                                 <td>
                                    <input type="text" class="form-control" name="name" placeholder="Add Name" wire:model.lazy="name">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control" name="link" placeholder="Add Link" wire:model.lazy="link">
                                    @error('link')
                                    <div class="invalid-feedback show">Please type a valid link.</div>
                                    @enderror
                                 </td>
                                 <td>
                                    <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" wire:click="addLink"><i class="bx bx-plus"></i> ADD</button>
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