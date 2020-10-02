@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
  <div class="d-flex justify-content-begin">
    <div class="content" >
      @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
      @endif
      <h2 class="content-title"><b>Available Room</b></h2>
    <div class="container d-flex justify-content-begin">
      <div class="col-12">
        <div class="row d-flex justify-content-begin" >
          {{-- {{$data}} --}}
          @if ($active == "[]")
            <div class="col">
              <span style="min-width: 200px" class="content-item-available">No available room</span>
            </div>
          @endif
          @foreach ($active as $row)
            <div class="col-4">
              <a href="{{url('timer')}}/{{$row->room_id}}" class="content-item-available">{{$row->room_id}}</a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <h2 class="content-title"><b>Room In Use</b></h2>
    <div class="container">
      <div class="col-12">
        <div class="row d-flex justify-content-begin">
          @if ($inactive == "[]")
            <div class="col">
              <span style="min-width: 200px" class="content-item-unavailable">No unavailable room</span>
            </div>
          @endif
          @foreach ($inactive as $row)
            <div class="col-4">
              <span class="content-item-unavailable">{{$row->room_id}}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <!-- <input type="time" class="form-control" value="13:00" >  -->

  </div>
@endsection
