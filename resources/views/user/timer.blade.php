@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
  <form action="{{$room_id}}/{{'scan'}}" method="get">
    <div class="d-flex justify-content-begin">
      <div class="content" >
        @if (session('error'))
          <div class="alert alert-danger" role="alert">
              {{session('error')}}
          </div>
        @endif
        @if (session()->get('end'))
          start: {{session()->get('start')}} <br>
          end: {{session()->get('end')}}
        @endif
        <h2 class="content-title" for="start"><b>Start Time</b></h2>
      <div class="container d-flex justify-content-begin">
        <div class="col-12">
          <div class="row d-flex justify-content-begin" >
            <input type="time" id="start" name="start" class="form-control" value="-" >
          </div>
        </div>
      </div>
      <h2 class="content-title" for="start"><b>End Time</b></h2>
      <div class="container">
        <div class="col-12">
          <div class="row d-flex justify-content-begin">
            <input type="time" id="end" name="end" class="form-control" value="-" >
          </div>
        </div>
        <button type="submit" class="btn btn-success"
        style="
          height: 50px;
          width: 100px;
          font-size: 25px;
        "
        >Next</button>
      </div>
    </div>
  </form>
@endsection