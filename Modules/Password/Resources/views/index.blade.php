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
   @if(isset($admin) && $admin == TRUE)
        @livewire('password::show-admin', key('password-show-admin'))
   @else
      @livewire('password::show', key('password-show'))
   @endif
</x-layouts.app>