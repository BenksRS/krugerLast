<div>
   <div class="">
      <div class="row g-4">
         <div class="col-12 col-md-8">
            @livewire('teams::team-list', [], key('team-list-'.$listKey))
         </div>
         <div class="col-12 col-md-4">
            @livewire('teams::team-setting', ['teamId' => $selectedTeamId, 'mode' => $mode], key('team-setting-'.$selectedTeamId.'-'.$mode))
         </div>
      </div>
   </div>
</div>

@push('css')
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
   <style>
       .btn-label {
           position: relative;
           padding-left: 42px;
           overflow: hidden;
           text-transform: uppercase;
           font-size: .8125rem;
           border-radius: .25rem;
       }
       .btn-label .label-icon {
           position: absolute;
           width: 32px;
           height: 100%;
           left: 0;
           top: 0;
           background-color: rgba(255, 255, 255, .1);
           border-right: 1px solid rgba(255, 255, 255, .1);
           font-size: 16px;
           display: flex;
           align-items: center;
           justify-content: center;
       }

       .card-disabled,
       .settings-disabled {
           position: relative;
       }

       .card-disabled::after,
       .settings-disabled::after {
           content: '';
           position: absolute;
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background-color: rgba(255, 255, 255, 0.5);
           z-index: 20;
           border-radius: inherit;
           cursor: not-allowed;
           pointer-events: all;
       }

       .card-disabled .btn,
       .settings-disabled .btn {
           visibility: hidden !important;
       }

       [data-component="settings"] .card-footer.sticky-bottom {
           position: sticky;
           bottom: 0;
       }

       [data-component="team"] .list-group-flush > .list-group-item:last-child{
           border-bottom: 1px solid #eff2f7;
       }
       [data-component="team"] .list-group-flush > .list-group-item .vr{
           background-color: #eff2f7;
           opacity: 1;
       }
   </style>
@endpush