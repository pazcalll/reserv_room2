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
            @foreach ($data as $row)
              <a href="{{'myroom'}}/{{$row->room_id}}" class="content-item-available">{{$row->room_id}}</a>
            @endforeach
            @if ($data == "[]")
              <span href="#" style="width: 200px" class="content-item-available">No room in the queue is available</span>
            @endif
          </div>
        </div>
      </div>
    </div>
    <h2 class="content-title" style="min-width: 270px"><b>Pending Room</b></h2>
    <div class="container">
      <div class="col-12">
        <div class="row d-flex justify-content-begin">
          <div class="col-4">
            @foreach ($pending as $p)
              <a href="{{'myroom'}}/{{$row->room_id}}" class="content-item-unavailable">{{$p->room_id}}</a>
            @endforeach
            @if ($pending == "[]")
              <span href="#" style="width: 200px" class="content-item-unavailable">No room in the queue is available</span>
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- <input type="time" class="form-control" value="13:00" >  -->

  </div>
@endsection