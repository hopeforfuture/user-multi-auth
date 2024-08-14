@extends('lead.layout')

@section('content')
<a class="btn btn-info" href="{{ route('lead.start') }}">Sign In</a>
@if($errors->any())
  <ul>
  @foreach ($errors->all() as $error)
    <li style="color: red;">{{$error}}</li>
  @endforeach
 </ul>
@endif
<form method="POST" action="{{ route('lead.save') }}">
  @csrf
  <span style="font-weight: bold;">Lead Signup</span>
  <table border="1" style="border-collapse: collapse;">
    <tr>
      <td>Name</td>
      <td>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}">
      </td>
    </tr>

    <tr>
      <td>Email</td>
      <td>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
      </td>
    </tr>

    <tr>
      <td>Password</td>
      <td>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
      </td>
    </tr>

    <tr>
      <td>Confirm Password</td>
      <td>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype Password">
      </td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone No" value="{{ old('phone') }}">
      </td>
    </tr>

    <tr>
      <td>Address</td>
      <td>
        <textarea name="address" id="address" cols="30" rows="5">{{ old('address') }}</textarea>
      </td>
    </tr>

    <tr>
      <td colspan="2" style="text-align: center;">
        <button type="submit">Signup</button>
      </td>
    </tr>

  </table>
  
</form>
@endsection