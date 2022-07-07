<link href="{{ themes('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ themes('libs/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ themes('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ themes('libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ themes('libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ themes('libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ themes('libs/@chenfengyuan/datepicker/datepicker.min.css') }}">

@include('flatpickr::components.style')

<!-- Plugins css -->
{{--<link href="{{ themes('libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />--}}
<!-- DataTables -->

<link href="{{ themes('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ themes('libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ themes('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ themes('libs/jquery-ui-dist/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Bootstrap Css -->
<link href="{{ themes('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ themes('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ themes('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- Custom Css -->
<link href="{{ themes('modules/css/modules.css') }}" rel="stylesheet" type="text/css" />

@stack('css')

