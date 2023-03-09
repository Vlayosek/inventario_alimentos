  <meta charset="utf-8">
  <title>
      SIDMED
  </title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <link href="{{ url('js/jquery/jqueryuitime.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ url('adminlte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('adminlte/css/AdminLTE.min.css') }}" rel="stylesheet">
  <link href="{{ url('adminlte/plugins/notifications/pnotify.custom.min.css') }}" rel="stylesheet">
  <link href="{{ url('adminlte/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('adminlte/plugins/datatables/jquery.dataTables2.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('adminlte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css">


  <link href="{{ url('adminlte/plugins/datatables/select.dataTables.min.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ url('adminlte/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('adminlte/plugins/datatables/colReorder.dataTables.min.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ url('web-fonts-with-css/css/fontawesome-all.min.css') }}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ url('adminlte/plugins/daterange/daterangepicker.css') }}" />
  <link href="{{ url('adminlte/plugins/datetimepicker/datetimepicker.css') }}" rel="stylesheet">

  <style>
      .user-panel>.image>img {
          width: 30px;
          max-width: 50px;
          height: 30px;
      }

      .delt {
          float: right;
          background-color: #dd4b3900;
          border-color: #d7392500;
          border-radius: 80%;
      }

      .cabecera {
          background: #E9ECEF;
          text-align: center;
          padding-top: 7px;
      }

      .btnTop {
          margin-top: 10px;
      }

      .inputSFC {
          border: 1px solid #ccc;
          border-radius: 7px;
          padding-left: 10px;
      }
  </style>
  <style>
      /*INICIO radio HORIZONTALES*/
      .dbgOuter {
          border: solid 1px #888;
          border-radius: 4px;
          padding: 3px 8px 0px 14px;
          width: 340px;
          margin: 0 auto;
          font-size: 10.5pt;
      }

      .dbgCont {
          display: inline-block;
          height: 24px;
          margin-left: 6px;
      }

      /* Base for label styling */
      .dbgCheck:not(:checked),
      .dbgCheck:checked {
          position: absolute;
          left: -9999px;
      }

      .dbgCheck:not(:checked)+label,
      .dbgCheck:checked+label {
          display: inline-block;
          position: relative;
          padding-left: 25px;
          cursor: pointer;
      }

      /* checkbox aspect */
      .dbgCheck:not(:checked)+label:before,
      .dbgCheck:checked+label:before {
          content: '';
          position: absolute;
          left: 0;
          top: 1px;
          width: 17px;
          height: 17px;
          border: 1px solid #aaa;
          background: #f8f8f8;
          border-radius: 3px;
          box-shadow: inset 0 1px 3px rgba(0, 0, 0, .3)
      }

      /* checkmark aspect */
      .dbgCheck:not(:checked)+label:after,
      .dbgCheck:checked+label:after {
          content: '✔';
          position: absolute;
          top: 2px;
          left: 5px;
          font-size: 14px;
          color: #09ad7e;
          transition: all .2s;
      }

      /* checked mark aspect changes */
      .dbgCheck:not(:checked)+label:after {
          opacity: 0;
          transform: scale(0);
      }

      .dbgCheck:checked+label:after {
          opacity: 1;
          transform: scale(1);
      }

      /* disabled checkbox */
      .dbgCheck:disabled:not(:checked)+label:before,
      .dbgCheck:disabled:checked+label:before {
          box-shadow: none;
          border-color: #bbb;
          background-color: #ddd;
      }

      .dbgCheck:disabled:checked+label:after {
          color: #999;
      }

      .dbgCheck:disabled+label {
          color: #aaa;
      }

      /* accessibility */
      .dbgCheck:checked:focus+label:before,
      .dbgCheck:not(:checked):focus+label:before {
          border: 1px dotted blue;
      }

      .dbgCheck {
          display: inline-block;
          width: 90px;
          height: 24px;
          margin: 1em;
      }


      .txtcenter {
          margin-top: 4em;
          font-size: .9em;
          text-align: center;
          color: #aaa;
      }

      .copy {
          margin-top: 2em;
      }

      .copy a {
          text-decoration: none;
          color: #4778d9;
      }

      /*FIN radio HORIZONTALES*/
      /* Style the tab */
      .tab {
          overflow: hidden;
          border: 0px solid #ccc;
          background-color: #f1f1f1;
      }

      /* Style the buttons that are used to open the tab content */
      .tab button {
          background-color: inherit;
          float: left;
          border: none;
          outline: none;
          cursor: pointer;
          padding: 14px 16px;
          transition: 0.3s;
      }

      /* Change background color of buttons on hover */
      .tab button:hover {
          background-color: #cfe0f6;
      }

      /* Create an active/current tablink class */
      .tab button.active {
          background-color: #cfe0f6;
      }

      /* Style the tab content */
      .tabcontent {
          display: none;
          padding: 6px 12px;
          /* border: 1px solid #ccc;*/
          border-top: none;
      }

      .modal {
          display: none;
          position: fixed;
          padding-top: 8px;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          overflow: auto;
          background-color: rgb(0, 0, 0);
          background-color: rgba(0, 0, 0, 0.62);
      }

      .modal-footer {
          margin: 10px;
          border-top-color: #ccc;
      }

      .modal-content {
          background-color: #fefefe;
          margin: auto;
          padding: 0px;
          border: 1px solid #888;
          width: 80%;
      }

      .modal-header {
          padding: 5px;
          border-bottom: 1px solid #000000;
          background-color: #2da986 !important;
          color: #ffffff;
      }

      .select2-container .select2-selection--single {
          box-sizing: border-box;
          cursor: pointer;
          display: block;
          height: 25px !important;
          user-select: none;
          -webkit-user-select: none;
      }

      .form-control {
          height: 25px !important;
          font-size: 12px !important;
          //text-transform: uppercase!important;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
          color: #444;
          line-height: 18px !important;
          font-size: 12px !important;
          //text-transform: uppercase!important;

      }

      .select2-container--default .select2-results>.select2-results__options {
          //text-transform: uppercase!important;
          font-size: 12px !important;

      }

      .select2-search--dropdown .select2-search__field {
          //text-transform: uppercase!important;
          text-align: right;
      }

      .switch {
          position: relative;
          display: inline-block;
          width: 50px;
          height: 20px;
      }

      .switch input {
          opacity: 0;
          width: 0;
          height: 0;
      }

      .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #c3c3c3;
          -webkit-transition: .4s;
          transition: .4s;
      }


      .slider:before {
          position: absolute;
          content: "";
          height: 14px;
          width: 14px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .6s;
      }

      input:checked+.slider {
          background-color: #2196F3;
      }

      input:focus+.slider {
          box-shadow: 0 0 1px #2196F3;
      }

      input:checked+.slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
      }

      /* Rounded sliders */
      .slider.round {
          border-radius: 34px;
      }

      .slider.round:before {
          border-radius: 50%;
      }

      p {
          font-family: Arial, Helvetica, sans-serif !important;
      }

      .dot {
          height: 10px;
          width: 10px;
          background-color: #bbb;
          border-radius: 50%;
          display: inline-block;
      }

      /* .dataTables_wrapper .dataTables_length {

          float: none !important
              ;}*/
      .dataTables_wrapper .dataTables_length {

          margin-right: 25px;
      }

      .select2-container--default.select2-container--disabled .select2-selection--single {
          background-color: #f7f7f7 !important;
      }

      .form-control-t {

          height: 40px !important;
          width: 100%;

      }

      .panel-default>.panel-heading {
          color: #fff;
          background-color: #1f7b76;
          border-color: #ddd;
      }


      .timeline-footer {
          padding: 2px !important;
      }


      .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 18px;
           !important;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow b {

          margin-top: -4px !important;
      }

      .form-group {
          margin-bottom: 2px !important;
      }

      .col-xs-1,
      .col-sm-1,
      .col-md-1,
      .col-lg-1,
      .col-xs-2,
      .col-sm-2,
      .col-md-2,
      .col-lg-2,
      .col-xs-3,
      .col-sm-3,
      .col-md-3,
      .col-lg-3,
      .col-xs-4,
      .col-sm-4,
      .col-md-4,
      .col-lg-4,
      .col-xs-5,
      .col-sm-5,
      .col-md-5,
      .col-lg-5,
      .col-xs-6,
      .col-sm-6,
      .col-md-6,
      .col-lg-6,
      .col-xs-7,
      .col-sm-7,
      .col-md-7,
      .col-lg-7,
      .col-xs-8,
      .col-sm-8,
      .col-md-8,
      .col-lg-8,
      .col-xs-9,
      .col-sm-9,
      .col-md-9,
      .col-lg-9,
      .col-xs-10,
      .col-sm-10,
      .col-md-10,
      .col-lg-10,
      .col-xs-11,
      .col-sm-11,
      .col-md-11,
      .col-lg-11,
      .col-xs-12,
      .col-sm-12,
      .col-md-12,
      .col-lg-12 {
          position: relative;
          min-height: 1px;
          padding-left: 2px !important;
          padding-right: 5px !important;
          padding-top: 0px !important;
          padding-bottom: 0px !important;

      }

      .main-sidebar,
      .left-side {
          position: fixed !important;
      }

      .sweet-alert h2 {
          font-size: 20px !important;
      }

      .sweet-alert {
          width: 400px !important;
          left: 55% !important;
      }

      .select2[disabled],
      .form-control[disabled],
      .form-control[readonly],
      fieldset[disabled] .form-control {
          background-color: #f7f7f7 !important;
      }

      .select2-selection--disabled {
          background-color: #f7f7f7 !important;
          border: 0px !important;
      }

      .select2-container--default .select2-selection--multiple .select2-selection__choice {
          background-color: #5fa9d4 !important;

      }

      .table-striped>tbody>tr:nth-of-type(odd) {
          background-color: #dbecf566 !important;
      }

      table.dataTable tbody tr {
          background-color: #ffffff00 !important;
      }

      .tablacorta {
          font-size: 12px !important;
          line-height: normal !important;
      }
  </style>
  <style>
      .tooltip {
          position: relative;
          display: inline-block;
          /* border-bottom: 1px dotted black;*/
          z-index: 100 !important;
      }

      .tooltip {
          opacity: 1 !important;
      }

      .tooltip .tooltiptext {
          visibility: hidden;
          width: 120px;
          background-color: #262626;
          color: #fff;
          text-align: center;
          border-radius: 6px;
          padding: 5px 0;
          position: absolute;
          z-index: 1;
          bottom: 125%;
          left: 50%;
          margin-left: -60px;
          opacity: 0;
          transition: opacity 0.3s;
      }

      .tooltip .tooltiptext::after {
          content: "";
          position: absolute;
          top: 100%;
          left: 50%;
          margin-left: -5px;
          border-width: 5px;
          border-style: solid;
          border-color: #555 transparent transparent transparent;
      }

      .tooltip:hover .tooltiptext {
          visibility: visible;
          opacity: 1;
      }

      .main-header .sidebar-toggle::before {
          content: none;
      }

      .form-control {
          color: #76838f;
          background-color: #fff;
          background-image: none;
          border: 1px solid #e4eaec;
      }

      .form-control {
          border-radius: 3px;
      }

      .form-control {
          transition: box-shadow .25s linear, border .25s linear, color .25s linear, background-color .25s linear;
      }

      .form-control {
          box-shadow: none;
      }

      .form-control {
          width: 100%;
          height: 34px;
          padding: 6px 12px;
      }

      .form-control,
      output {
          font-size: 14px;
          line-height: 1.42857143;
          display: block;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
          color: #444;
          line-height: 28px;
      }

      .select2-container .select2-selection--single .select2-selection__rendered {
          display: block;
          padding-left: 8px;
          padding-right: 20px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
      }

      .select2-container--default .select2-selection--single {
          background-color: #fff;
          border: 1px solid #aaaaaa52;
          border-radius: 4px;
      }

      .select2-container .select2-selection--single {
          box-sizing: border-box;
          cursor: pointer;
          display: block;
          height: 35px;
          user-select: none;
          -webkit-user-select: none;
      }

      .form-control-i {
          height: 25px !important;
          font-size: 12px !important;
          //text-transform: uppercase!important;
          color: #76838f;
          background-color: #fff;
          background-image: none;
          border: 1px solid #e4eaec;
          width: 100%;
      }

      .list-group-item span {
          font-size: 10px !important;
      }
  </style>

  <style media="print">
      /*@import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");*/
      body {
          width: 792px !important;
          margin: 0px;
          padding: 0px;
          line-height: 1.1 !important;
      }
  </style>
  <style type="text/css">
      @media print {
          @page {
              margin: 0;
          }

          body {
              margin: 1.6cm;
          }
      }

      .form-control {
          height: 35px !important;
          font-size: 12px !important;
          //text-transform: uppercase !important;
      }

      .form-control-t {
          min-height: 100px !important;
          width: 100%;
      }

      .row {
          margin-right: 0px;
          margin-left: 0px;
      }

      .modal-header {
          padding: 5px;
          border-bottom: 1px solid #000000;
          background-color: #528eea !important;
          color: #ffffff;
      }

      .skin-blue {
          padding-right: 0px !important;
      }
  </style>


  @yield('css')
