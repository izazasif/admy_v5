<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ !isset($title) ? 'MyBDApps' : $title }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/jvectormap/jquery-jvectormap.css') }}"> -->
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('assets/admin_lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <link rel="icon" type="image/gif/png" href="{{ asset('assets/images/foot-logo.png') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @yield('extra-head-scripts')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('portal.layouts.header')
    @include('portal.layouts.sidebar')

    @yield('content')

    @include('portal.layouts.footer')

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('assets/admin_lte/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/admin_lte/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/admin_lte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<!-- <script src="{{ asset('assets/admin_lte/bower_components/raphael/raphael.min.js') }}"></script> -->
<script src="{{ asset('assets/admin_lte/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/admin_lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('assets/admin_lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/admin_lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/admin_lte/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/admin_lte/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin_lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('assets/admin_lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/admin_lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('assets/admin_lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/admin_lte/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/admin_lte/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/admin_lte/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/admin_lte/dist/js/demo.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>

<script type="text/javascript">
    $(function () {
        $( "#unit_price, #amount" ).keyup(function() {
          var unit_price = $("#unit_price").val();
          var amount = $("#amount").val();
          $("#price").val(unit_price*amount);
        });

        // var dateNow = new Date();
        $('#datetimepicker1').datetimepicker({
          useCurrent:false,
          sideBySide:true,
          // minDate:new Date()
        });

        $('.datepicker').datepicker({

        });

        $('.daterangepicker').daterangepicker({
          // autoUpdateInput: false,
          autoApply: true,
        });

        $( "#category_id" ).change(function() {
          var category_id = $(this).val();
          $(".audio_clip").hide();
          $("#clip_msg").hide();
          $("#no_clip_msg").hide();

          if(category_id){
            var clip_nums = $(".cat"+category_id).length;

            if(clip_nums > 0){
              $(".cat"+category_id).show();
            }else{
              $("#no_clip_msg").show();
            }
          }else{
            $("#clip_msg").show();
          }

        });

        $("#remove-image-btn").click(function(){
            $(this).hide();
            $("#image-preview").hide();
            $("#image-input").show();
        });

        $(".deliver_btn").click(function(){
          var schedule_id = $(this).attr('data-id');
          $("#schedule_id").val(schedule_id);
        });
    });

    function getBaseURL() {
      var getURL = window.location;

      var _return = getURL.protocol + '//' + getURL.hostname + (location.port.length ? ':'+location.port : '');
      var tmp_pathname = getURL.pathname.split('/');

      if ( getURL.pathname.search(/mybdapps/i) > -1 ) {
        _return += '/'+tmp_pathname[1]+'/public';
      }
      return _return;
    }
</script>

@yield('extra-foot-scripts')
</body>
</html>
