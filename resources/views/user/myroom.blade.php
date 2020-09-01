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
              {{-- <a href="{{'myroom'}}/{{$row->room_id}}" class="content-item-available">{{$row->room_id}}</a> --}}
              <button type="button" class="content-item-available" data-toggle="modal" data-target="#exampleModalCenter">
                {{$row->room_id}}
              </button>

              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5><b style="font-size: 25px">Confirmation</b></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      This room is being used, do you want to finish your borrowing session?
                    </div>
                    <div class="modal-footer">
                      <a class="btn btn-secondary" style="color: white" data-dismiss="modal">No</a>
                      <a href="{{url('cancelroom')}}/{{$row->room_id}}/{{$row->borrow_id}}" class="btn btn-danger">Yes</a>
                    </div>
                  </div>
                </div>
              </div>
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
              <a href="{{'myroom'}}/{{$p->room_id}}" class="content-item-unavailable">{{$p->room_id}}</a>
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