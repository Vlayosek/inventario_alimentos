<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIMED</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->


<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


<link rel="stylesheet" href="{{ asset('adminlte3/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<link rel="stylesheet" href="{{ asset('adminlte3/plugins/toastr/toastr.min.css') }}">

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2486ad !important;
        border: 1px solid #393131;
        border-radius: 4px;
        box-sizing: border-box;
        display: inline-block;
        margin-left: 5px;
        margin-top: 5px;
        padding: 0;
        padding-left: 0px;
        padding-left: 20px;
        position: relative;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: bottom;
        white-space: nowrap;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
        cursor: pointer;
        font-size: 1em;
        font-weight: bold;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        cursor: pointer;
        font-size: 1em;
        font-weight: bold;
    }

    .titulo {
        background-color: #00c3f2;
        padding: 20px;
        text-align: center;
        color: #ffffff;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .hidden {
        display: none;
    }

    .nav-pills>.nav-item {
        width: 100%;
    }

    .table-striped tbody tr:nth-of-type(2n+1) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .swal2-actions {
        width: 100% !important;
    }

    .swal2-deny {
        width: 25% !important;
        background-color: #ccc !important;
    }

    .swal2-confirm {
        width: 25% !important;

    }

    .swal2-icon {
        display: none !important;
    }

    .dataTables_empty {
        text-align: center;
    }

    .btnTop {
        top: 10px;
    }

    .hidden {
        display: none !important;
    }
</style>
<link href="{{ url('npm\select2\dist\css\select2.min.css') }}" rel="stylesheet" type="text/css">

@yield('css')
