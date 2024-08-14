@extends('admin.layout')

@section('content')
@if($errors->any())
<span style="color:red;font-weight:bold;">{{$errors->first()}}</span>
@endif
<form method="POST" action="{{ route('admin.login') }}">
  @csrf
  <span style="font-weight: bold;">Administrator Login</span>
  <table border="1" style="border-collapse: collapse;">
    <tr>
      <td>Email</td>
      <td>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
      </td>
    </tr>
    <tr>
      <td>Password</td>
      <td>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
      </td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center;">
        <button type="submit">Login</button>
      </td>
    </tr>
  </table>
  
</form>
@endsection