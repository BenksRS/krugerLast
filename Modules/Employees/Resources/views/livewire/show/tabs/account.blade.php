<div>
    <h4 class="card-title mb-4">Account
    
    </h4>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save" >
                
                <div class="row">

                    <div class="col-lg-6 col-md-12">

                        <div class="mb-3">
                            <label  class="form-label">New Password</label>
                            <input type="password" class="form-control"  name="password" wire:model="password" required>

                        </div>
    
                        <button type="submit" class="btn btn-success btn-sm float-start m-1" >
                            <i class="fas fa-save"></i> save</button>
                    </div>
                </div>
            
            </form>
        
        </div>
    
    </div>
</div>
