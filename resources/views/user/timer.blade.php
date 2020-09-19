@extends('user/index')
@section('content')
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

<body style="margin-bottom: 300px;">
  {{-- <form action="{{url('index')}}/{{$room_id}}/{{'scan'}}" method="get"> --}}
  <form action="{{url('saveroom')}}" method="post">
    @csrf
    
    <div class="d-flex justify-content-begin">
      <div class="content" >
        @if ($errors != "[]")
          <div class="alert alert-danger" role="alert">
              {{$errors}}
          </div>
        @endif
        {{-- @if (session()->get('end'))
          start: {{session()->get('start')}} <br>
          end: {{session()->get('end')}}
        @endif --}}
        <h2 class="content-title" for="start"><b>Start Time</b></h2>
      <div class="container d-flex justify-content-begin">
        <div class="col-12">
          <div class="row d-flex justify-content-begin" >
            {{-- <input type="text" id="start" name="start" class="form-control" > --}}
            {{-- <div>
              <input style="border: none; text-align: center" type="number" name="start1" min="0" max="23" placeholder="00">:
              <input style="border: none; text-align: center" type="number" name="start2" min="0" max="59" placeholder="00">
            </div> --}}
            <select name="starth" id="starth" style="border: none">
              <?php for ($i=0; $i < 24; $i++) { 
                echo "<option value=$i>$i</option>";
              } ?>
            </select>:
            <select name="startm" id="startm" style="border: none">
              <?php for ($i=0; $i < 24; $i++) { 
                echo "<option value=$i>$i</option>";
              } ?>
            </select>
          </div>
        </div>
      </div>
      <h2 class="content-title" for="start"><b>End Time</b></h2>
      <div class="container">
        <div class="col-12">
          <div class="row d-flex justify-content-begin">
            {{-- <input type="text" id="end" name="end" class="form-control" > --}}
            {{-- <div>
              <input style="border: none; text-align: center" type="number" name="start1" min="0" max="23" placeholder="00">:
              <input style="border: none; text-align: center" type="number" name="start2" min="0" max="59" placeholder="00">
            </div> --}}
            <select name="endh" id="endh" style="border: none">
              <?php for ($i=0; $i < 24; $i++) { 
                echo "<option value=$i>$i</option>";
              } ?>
            </select>:
            <select name="endm" id="endm" style="border: none">
              <?php for ($i=0; $i < 24; $i++) { 
                echo "<option value=$i>$i</option>";
              } ?>
            </select>
          </div>
        </div>
        <input type="hidden" name="room_id" id="room_id" value="{{$room_id}}">
        <br><br>
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


  {{-- <div>
    <input type="number" min="0" max="23" placeholder="23">:
    <input type="number" min="0" max="59" placeholder="00">
  </div>
  <style>
      div {
        background-color: white;
        display: inline-flex;
        border: 1px solid #ccc;
        color: #555;
      }
      
      input {
        border: none;
        color: #555;
        text-align: center;
        width: 60px;
      }

  </style>
  <script>
    document.querySelectorAll('input[type=number]')
      .forEach(e => e.oninput = () => {
        // Always 2 digits
        if (e.value.length >= 2) e.value = e.value.slice(0, 2);
        // 0 on the left (doesn't work on FF)
        if (e.value.length === 1) e.value = '0' + e.value;
        // Avoiding letters on FF
        if (!e.value) e.value = '00';
      });

  </script> --}}
  <script>
    var timepicker = new TimePicker('start', {
      lang: 'en',
      theme: 'dark'
    });
    timepicker.on('change', function(evt) {
      
      var value = (evt.hour || '00') + ':' + (evt.minute || '00');
      evt.element.value = value;

    });
    var timepicker = new TimePicker('end', {
      lang: 'en',
      theme: 'dark'
    });
    timepicker.on('change', function(evt) {
      
      var value = (evt.hour || '00') + ':' + (evt.minute || '00');
      evt.element.value = value;

    });

  </script>
@endsection