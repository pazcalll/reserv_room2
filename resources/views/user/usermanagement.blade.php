@extends('user/index')
@section('content')
<body style="margin-bottom: 300px;">
  <div class="d-flex justify-content-begin">
    <div class="content" >
      <h2 class="content-title" style="padding-bottom: 30px"><b>User Identity</b></h2>
    <div class="container d-flex justify-content-begin">
      <div class="col-12">
        <div class="row d-flex justify-content-begin" >
          <div class="col-4">
            <style>
              table{
                margin-left: -20px;
              }
            </style>
            <table style="border: none;">
              <tr>
                <td>Name&emsp;</td>
                <td>:&emsp;</td>
                <td>{{Auth::user()->name}}</td>
              </tr>
              <tr>
                <td>Nim&emsp;</td>
                <td>:&emsp;</td>
                <td>{{Auth::user()->id}}</td>
              </tr>
              <tr>
                <td>Email&emsp;</td>
                <td>:&emsp;</td>
                <td>{{Auth::user()->email}}</td>
              </tr>
              <tr style="height: 90px">
                <td></td>
                <td></td>
                <td><a href="#" class="btn btn-warning" style="outline: none;">Change Password</a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection