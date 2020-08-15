
@section('sidebar')
  <div id="sidebar">
    <a class="toggle-btn" onclick="toggleSidebar()" href="#">
      <span></span>
      <span></span>
      <span></span>
    </a>
    <p>{{ Auth::user()->name }}</p>
    <p style="padding-top: 0px;">{{ Auth::user()->id }}</p>
    <ul>
      <a href="#" style="color: rgba(255,230,230,0.9)";><li>List of Rooms</li></a>
      <a href="#" style="color: rgba(255,230,230,0.9)";><li>User Management</li></a>
      <a href="#" style="color: rgba(255,230,230,0.9)";><li>My Room</li></a>
      <a href="{{route('logout')}}" style="color: rgba(255,230,230,0.9)"; onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <li>{{ __('Logout') }}</li>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </ul>
  </div>
  @endsection
