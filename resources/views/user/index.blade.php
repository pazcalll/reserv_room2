<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{URL::asset('css/main.css')}}" >
    <link rel="stylesheet" href="{{URL::asset('css/time.css')}}">
    <link href="{{URL::asset('webcodecamjs-master/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('webcodecamjs-master/css/style.css')}}">
    <script src="{{URL::asset('js/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</head>
@yield('content')
  <div id="sidebar">
    <a class="toggle-btn" onclick="toggleSidebar()" href="#">
      <span></span>
      <span></span>
      <span></span>
    </a>
    <p>{{ Auth::user()->name }}</p>
    <p style="padding-top: 0px;">{{ Auth::user()->id }}</p>
    <ul>
      <a href="{{route('index')}}" style="color: rgba(255,230,230,0.9)";><li>List of Rooms</li></a>
      <a href="{{route('usermanagement')}}" style="color: rgba(255,230,230,0.9)";><li>User Management</li></a>
      <a href="{{ route('myroom') }}" style="color: rgba(255,230,230,0.9)";><li>My Room</li></a>
      <a href="{{route('logout')}}" style="color: rgba(255,230,230,0.9)"; onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <li>{{ __('Logout') }}</li>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </ul>
  </div>
    <script type="text/javascript" async src="{{URL::asset('webcodecamjs-master/js/filereader.js')}}"></script>
  <!-- Using jquery version: -->
  <!--
      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/qrcodelib.js"></script>
      <script type="text/javascript" src="js/webcodecamjquery.js"></script>
      <script type="text/javascript" src="js/mainjquery.js"></script>
  -->
  <script type="text/javascript" async src="{{URL::asset('webcodecamjs-master/js/qrcodelib.js')}}"></script>
  <script type="text/javascript" async src="{{URL::asset('webcodecamjs-master/js/webcodecamjs.js')}}"></script>
  <script type="text/javascript" async src="{{URL::asset('webcodecamjs-master/js/main.js')}}"></script>
</body>
</html>