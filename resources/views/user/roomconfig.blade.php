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
                {{-- <a href="{{url('cancelroom')}}/{{$room_id}}" class="content-item-unavailable">Yes</a> --}}
                
                <!-- Button trigger modal -->
                <button type="button" class="content-item-unavailable" data-toggle="modal" data-target="#exampleModalCenter">
                  Yes
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        ...
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <a href="{{url('myroom')}}" class="content-item-available">No</a>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection