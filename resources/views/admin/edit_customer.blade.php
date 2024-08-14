@extends('admin.layout-dashboard')

@section('content')
@if($errors->any())
  <ul>
  @foreach ($errors->all() as $error)
    <li style="color: red;">{{$error}}</li>
  @endforeach
 </ul>
@endif
<form method="POST" action="{{ route('admin.update.customer', [$customer->id]) }}">
  @csrf
  <span style="font-weight: bold;">Edit Customer</span>
  <table border="1" style="border-collapse: collapse;">
    <tr>
      <td>Name</td>
      <td>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $customer->name }}" required>
      </td>
    </tr>

    <tr>
      <td>Email</td>
      <td>
        <input required type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $customer->email }}">
      </td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>
        <input required type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone No" value="{{ $customer->phone ?? old('phone') }}">
      </td>
    </tr>

    <tr>
      <td>Address</td>
      <td>
        <textarea required name="address" id="address" cols="30" rows="5">{{ $customer->address }}</textarea>
      </td>
    </tr>

    <tr>
      <td colspan="2" style="text-align: center;">
        <button class="btn btn-info" type="submit">Update</button>
        <a class="btn btn-info" style="color:lightyellow !important;" href="{{ route('admin.customer.list') }}">Back</a>
      </td>
    </tr>

  </table>
  
</form>
@endsection