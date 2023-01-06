@extends('layouts/index')
@section('content')
<div class="mp-split-pane ">
 
  
    <!-- <img src="{{ Request::route()->getName() == 'admin' ? 'assets/images/bg-admin.svg' : 'assets/images/bg-member.svg'}}" alt="UPPFI"> -->
  
  <div class="mp-split-pane__left">
       <div class="transition-background">

        </div>
    <div class="container-fluid mp-pt3 mp-pb5 mp-mvauto mp-mhauto" id="loginform">
      
      <div class="row align-items-center justify-content-center">
        <div class="col-12 col-sm-10">
         
          @section('loginForm')
          @show
         
        </div>
      </div>
    </div>
    <div id="registrationform" hidden="hidden" class="container-fluid">
      @section('registrationform')
      @show
    </div>
  </div>
  <div class="mp-split-pane__right">
@section('right')
@show
  </div>
</div>
<script>
  $(document).on('click', '#register', function(e) {
      $("#loginform").attr("hidden", true);
      // var $ids = $('[id="loginForm"]');

      // $ids.each(function(i, e) {
      //     $(e).attr("hidden", true);
      // });
      $("#registrationform").removeAttr("hidden");
      // var $ids = $('[id="registrationform"]');
      // $ids.each(function(i, e) {
      //     $(e).removeAttr("hidden");
      // });
  })
  $(document).on('click', '#back', function(e) {
      $("#registrationform").attr("hidden", true);
      // var $ids = $('[id="loginForm"]');

      // $ids.each(function(i, e) {
      //     $(e).attr("hidden", true);
      // });
      $("#loginform").removeAttr("hidden");
      // var $ids = $('[id="registrationform"]');
      // $ids.each(function(i, e) {
      //     $(e).removeAttr("hidden");
      // });
  })

  $(document).on('click', '#forgot_password', function(e) {
      $("#loginform").attr("hidden", true);
      // var $ids = $('[id="loginForm"]');

      // $ids.each(function(i, e) { 
      //     $(e).attr("hidden", true);
      // });
      $("#registrationform").removeAttr("hidden");
      // var $ids = $('[id="registrationform"]');
      // $ids.each(function(i, e) {
      //     $(e).removeAttr("hidden");
      // });
  })
  $(document).on('click', '#back', function(e) {
      $("#registrationform").attr("hidden", true);
      // var $ids = $('[id="loginForm"]');

      // $ids.each(function(i, e) {
      //     $(e).attr("hidden", true);
      // });
      $("#loginform").removeAttr("hidden");
      // var $ids = $('[id="registrationform"]');
      // $ids.each(function(i, e) {
      //     $(e).removeAttr("hidden");
      // });
  })
</script>
@endsection