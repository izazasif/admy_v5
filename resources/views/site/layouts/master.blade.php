<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ !isset($title) ? 'MyBDApps' : $title }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" href="{{ asset('assets/admy/css/first.css?v=2.1') }}">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/admy/css/font-admy.css') }}">
  <link rel="icon" type="image/gif/png" href="{{ asset('assets/images/foot-logo.png') }}">

  <style>
    .navbar-header{
      margin-left: 0px !important;
      margin-right: 0px !important;
    }
    .navbar-inverse .container-fluid{
      padding-left: 0px;
      padding-right: 0px;
    }
    .navbar-toggle {
      margin-right: 33px;
    }
  </style>
  @yield('extra-head-scripts')
</head>
<body>

@include('site.layouts.topbar')

@yield('content')

@include('site.layouts.footer')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <script>

  // Select all links with hashes
  $('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
      // On-page links
      if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
        &&
        location.hostname == this.hostname
      ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
          // Only prevent default if animation is actually gonna happen
          event.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top - 50
          }, 2000, function() {
            // Callback after animation
            // Must change focus!
            var $target = $(target);
            $target.focus();
            if ($target.is(":focus")) { // Checking if the target was focused
              return false;
            } else {
              $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
              $target.focus(); // Set focus again
            };
          });
        }
      }
    });

   AOS.init();
 </script>

<script>
    $(document).ready(function () {
        function test(){
            alert('okay')
        }
        // $("ts").click( function (){
        //     alert('okaye')
        // });
        // $("#getValBtnID").click(function () {
        //     var inputString = $("#userInputID").val();
        //     alert(inputString);
        // });
    });
</script>

@yield('extra-foot-scripts')

</body>
</html>
