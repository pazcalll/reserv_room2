@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
  <div class="d-flex justify-content-begin">
    <div class="content" >
      <h2 class="content-title" style="padding-bottom: 10px"><b>Set Up New Password</b></h2>
    <div class="container d-flex justify-content-begin">
      <div class="col-12">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif
        @if (session()->get('message'))
            <div class="alert alert-success"alert">
                <b>Success: </b> {{session()->get('message')}}
            </div>
        @endif
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach
        <div class="row d-flex justify-content-begin" >
          <div class="col-4">
            <style>
              table{
                /* margin-left: -20px; */
                width: 400px;
              }
              table tr{
                  height: 40px;
              }
              @media (max-width: 500px){
                table{
                    width: 280px;
                }
              }
              .alert .alert-danger{
                  width: 400px;
                  margin-left: -20px;
              }
            </style>
            
            <table style="border: none;">

                <form action="{{'newpw'}}" method="POST" class="form-control">
                    @csrf
                    <tr>
                      <td>Old Password&emsp;</td>
                      <td>:&emsp;</td>
                      <td><input class="form-control" type="password" name="oldpw" id="oldpw" required></td>
                    </tr>
                    <tr>
                      <td>New Password&emsp;</td>
                      <td>:&emsp;</td>
                      <td><input class="form-control" type="password" name="newpw" id="newpw" required></td>
                    </tr>
                    <tr>
                      <td>Confirm New Password&emsp;</td>
                      <td>:&emsp;</td>
                      <td><input class="form-control" type="password" name="newpw_confirmation" id="newpw_confirmation" required></td>
                    </tr>
                    <tr style="height: 90px">
                      <td></td>
                      <td></td>
                      <td><button class="btn btn-success" type="submit">Confirm</button></td>
                    </tr>
                </form>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection