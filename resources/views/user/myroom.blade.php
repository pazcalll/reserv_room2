@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
  <div class="d-flex justify-content-begin">
    <div class="content" >
      <h2 class="content-title"><b>Active Room</b></h2>
    <div class="container d-flex justify-content-begin">
      <div class="col-12">
        <div class="row d-flex justify-content-begin" >
          <div class="col-4">
            <a href="#" class="content-item-available">Room Name</a>
          </div>
          <div class="col-4">
            <a href="#" class="content-item-available">Room Name</a>
          </div>
          <div class="col-4">
            <a href="#" class="content-item-available">Room Name</a>
          </div>
        </div>
      </div>
    </div>
    <h2 class="content-title"><b>Pending Room</b></h2>
    <div class="container">
      <div class="col-12">
        <div class="row d-flex justify-content-begin">
          <div class="col-4">
            <a href="#" class="content-item-unavailable">Room Name</a>
          </div>
          <div class="col-4">
            <a href="#" class="content-item-unavailable">Room Name</a>
          </div>
          <div class="col-4">
            <a href="#" class="content-item-unavailable">Room Name</a>
          </div>
        </div>
      </div>
    </div>
    <!-- <input type="time" class="form-control" value="13:00" >  -->

  </div>
@endsection