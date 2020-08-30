@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
    <div class="d-flex justify-content-begin">
        <div class="content" >
          <h2 class="content-title"><b>{{$room_id}}</b></h2>
        <div class="container d-flex justify-content-begin">
          <div class="col-12">
            <div class="row d-flex justify-content-begin" >
                <p style="color: black;  margin-left: -30px; margin-top: -20px">This room is being used, do you want to finish your borrowing session?</p><br>
              <div class="col-4">
                <a href="{{url('cancelroom')}}" class="content-item-unavailable">Yes</a>
              </div>
              <div class="col-4">
                <a href="{{url('myroom')}}" class="content-item-available">No</a>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection