<x-layouts.app layout="horizontal">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Passwords</h4>

            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                  <li class="breadcrumb-item active">Passwords</li>
               </ol>
            </div>

         </div>
      </div>
   </div>
   @livewire('password::show', ['is_admin' => $admin ?? false], key('password-show'))
</x-layouts.app>