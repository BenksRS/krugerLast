<x-layouts.app layout="horizontal">
	<!-- start page title -->
	
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0 font-size-18">{{$page->title}}</h4>
				
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						
						<li class="breadcrumb-item"><a href="{{$page->back}}">{{$page->back_title}}</a></li>
						<li class="breadcrumb-item active">{{$page->title}}</li>
					</ol>
				</div>
			
			</div>
		</div>
	</div>
	
	
	@switch($type)
		@case('open')
			@livewire('dashboard::list.open', key('dash_list_open'))
			@break
		@case('my_list')
		@livewire('dashboard::list.mylist', key('dash_list_my_list'))
		@break
		@case('message')
			@livewire('dashboard::list.messages', key('dash_list_message'))
			@break
		@case('late')
			@livewire('dashboard::list.late', key('dash_list_late'))
			@break
		@case('request_docusign')
			@livewire('dashboard::list.request-docsign', key('dash_list_request_docusign'))
			@break
		@case('nojobs')
			@livewire('dashboard::list.nojobs', key('dash_list_request_nojobs'))
			@break
		@case('schedulled')
			@livewire('dashboard::list.schedulled', key('dash_list_request_schedulled'))
			@break
		@case('docusign_sent')
			@livewire('dashboard::list.docsign-sent', key('dash_list_docsign-sent'))
			@break
		@case('message_sent')
			@livewire('dashboard::list.message-sent', key('dash_list_message-sent'))
			@break
		@case('readytobill')
			@livewire('dashboard::list.readytobill', key('dash_list_readytobill'))
			@break
		@case('collection')
			@livewire('dashboard::list.collection', key('dash_list_collection'))
			@break
		@case('takeactions')
			@livewire('dashboard::list.take-actions', key('dash_list_take_actions'))
			@break
		@case('followup')
			@livewire('dashboard::list.fallow-up', key('dash_list_followup'))
			@break
		@case('overdue')
			@livewire('dashboard::list.overdue', key('dash_list_overdue'))
		@break
	    @case('followup30')
	    @livewire('dashboard::list.fallowup30', key('dash_list_followup30'))
	    @break
	    @case('followup45')
	    @livewire('dashboard::list.fallowup45', key('dash_list_followup45'))
	    @break
		@case('followup60')
		@livewire('dashboard::list.fallowup60', key('dash_list_followup60'))
		@break
		@case('followup90')
		@livewire('dashboard::list.fallowup90', key('dash_list_followup90'))
		@break
		@case('revisebill')
			@livewire('dashboard::list.revisebill', key('dash_list_followup'))
			@break
		@case('revisetree')
		@livewire('dashboard::list.revisetree', key('dash_list_revisetree'))
		@break
		@case('landline')
			@livewire('dashboard::list.landline', key('dash_list_landline'))
			@break
		@case('thig')
			@livewire('dashboard::list.thig', key('dash_list_thig'))
			@break
		@case('univ')
			@livewire('dashboard::list.univ', key('dash_list_univ'))
			@break
		@case('jobstech')
		@livewire('dashboard::list.jobstech', key('dash_list_jobstech'))
		@break
		@case('clean_up')
	  		@livewire('dashboard::list.clean-up', key('dash_list_clean_up'))
	  		@break
	@case('extreme')
	  @livewire('dashboard::list.extreme', key('dash_list_extreme'))
	  @break
	@case('crane_needed')
	  @livewire('dashboard::list.crane-needed', key('dash_list_crane_needed'))
	  @break
	@case('nobody_was_home')
	  @livewire('dashboard::list.nobody-was-home', key('dash_list_nobody_was_home'))
	  @break
	@case('not_enough_time')
	  @livewire('dashboard::list.not-enough-time', key('dash_list_not_enough_time'))
	  @break
	@case('tree_done_need_tarp')
	  @livewire('dashboard::list.tree-done-need-tarp', key('dash_list_tree_done_need_tarp'))
	  @break
	@case('tree_easy')
	  @livewire('dashboard::list.tree-easy', key('dash_list_tree_easy'))
	  @break
	@case('not_confirmed')
	  @livewire('dashboard::list.not-confirmed', key('dash_list_not_confirmed'))
	  @break
	@case('tree_signed')
	  @livewire('dashboard::list.tree-signed', key('dash_list_tree_signed'))
	  @break
	@case('missing_assignment')
	  @livewire('dashboard::list.missing-assignment', key('dash_list_missing_assignment'))
	  @break
	@case('nadal_problem')
	  @livewire('dashboard::list.nadal-problem', key('dash_list_nadal_problem'))
	  @break
	@case('cynthia_review')
	  @livewire('dashboard::list.cynthia-review', key('dash_list_cynthia_review'))
	  @break
	@case('crane_approved')
	  @livewire('dashboard::list.crane-approved', key('dash_list_crane_approved'))
	  @break
		@case('magic_message_sent')
		@case('magic_docusign_sent')
		@case('magic_ready_to_install')
		@case('magic_thig')
			@livewire('dashboard::list.magic', ['type' => $type], key('dash_list_magic'))
			@break
		@default
			<h3>OPPSSSS!!!! No list found!! </h3>
	@endswitch


</x-layouts.app>