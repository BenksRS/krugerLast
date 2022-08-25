<div>
	<div class="menu-builder">
		@include('menu::build.tabs-menu')
	</div>
	
{{--	@include('menu::build.modal')--}}
	
	@push('css')
		<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
		<style>
			.nav-tabs-custom {
				border-width : 1px;
				border-color : #eff2f7;
			}
			
			.nav-tabs-custom .nav-item .nav-link {
				padding : 1.2rem 1.5rem;
			}
			
			.dd-list .dd-list {
				padding-left : 55px;
				
			}
			
			.dd-list:first-child > .dd-item,
			.dd-list:first-child > .dd-placeholder{
				margin-bottom : 35px;
			}
			
			.dd-empty,
			.dd-placeholder,
			.dd-item {
				margin   : 6px 0;
				position : relative;
			}
			
			
			.dd-collapse {
				display : none;
			}
			
			
			.dd-handle {
				position        : absolute;
				left            : 0;
				top             : 0;
				margin          : 0;
				padding         : 0;
				border          : 0;
				width           : 55px;
				height          : 55px;
				z-index         : 10;
				box-shadow      : none !important;
				display         : flex;
				align-items     : center;
				justify-content : center;
				cursor          : pointer;
				font-size       : 22px;
				color           : #858585;
			}
			
			.dd-handle:before {
				font-family : boxicons !important;
				font-weight : 100;
				content     : "\ea6e";
			}
			
			.dd-header {
				position    : relative;
				min-height  : 55px;
				margin-left : 55px;
				padding     : 0 1.2rem;
				display     : flex;
				align-items : center;
				cursor      : pointer;
			}
			
			
			.dd-header i {
				font-size : 18px;
			}
			
			.dd-header .dd-header-collapse {
				position    : absolute;
				left        : 0;
				right       : 0;
				top         : 0;
				bottom      : 0;
				display     : flex;
				align-items : center;
				z-index: 9;
			}
			
			.dd-header .dd-header-collapse:before {
				font-family : boxicons !important;
				font-weight : 100;
				content     : "\e9e2";
				position    : absolute;
				right       : 1.4rem;
				font-size   : 22px;
			}
			
			.dd-header .dd-header-collapse[aria-expanded='true']:before {
				content : "\e9e9";
			}
			
			.dd-header-actions {
				position: relative;
				z-index: 10;
			}
			
			.dd-header-actions .action-group {
			
			}
			
			.dd-header-actions .action-item {
				display : flex;
			}
		
		
		</style>
	@endpush
	
	@push('js')
		<script src="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
		<script>
            $(document).ready(function () {
                $('.dd').nestable({
                    /*                    json:     '[{"id":1},{"id":2},{"id":3,"children":[{"id":4},{"id":5,"foo":"bar"}]}]',*/
                    maxDepth: 2
                }).on('change', function () {
                    var serialized = $(this).nestable('serialize')
                    console.log(serialized)
                })

                $('.form-check-input').on('click', function (e) {
                    // stop the event from bubbling.
                    e.stopPropagation()
                })
                /*
								
								const menuActions = window.document.querySelectorAll('[data-menu-action]');
				
								menuActions.forEach(function (element, index, array) {
									element.addEventListener('click', function (event) {
										event.preventDefault();
										console.log(event.target);
									});
								});*/
            })
		</script>
	@endpush
</div>
