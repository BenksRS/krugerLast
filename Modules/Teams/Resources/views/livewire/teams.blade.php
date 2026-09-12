<div>
   <div class="row">
      <div class="col-lg-8">
         @livewire('teams::team-list', [], key('team-list-'.$listKey))
      </div>
      <div class="col-lg-4">
         @livewire('teams::team-setting', ['teamId' => $selectedTeamId], key('team-setting-'.$selectedTeamId))
      </div>
   </div>
</div>