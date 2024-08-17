@extends('admin.layout-dashboard')

@section('content')
@if($errors->any())
  <ul>
  @foreach ($errors->all() as $error)
    <li style="color: red;">{{$error}}</li>
  @endforeach
 </ul>
@endif
<form method="POST" action="{{ route('admin.update.lead', [$lead->id]) }}">
  @csrf
  <span style="font-weight: bold;">Edit Lead</span>
  <table border="1" style="border-collapse: collapse;">
    <tr>
      <td>Name</td>
      <td>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $lead->name }}" required>
      </td>
    </tr>

    <tr>
      <td>Email</td>
      <td>
        <input required type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $lead->email }}">
      </td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>
        <input required type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone No" value="{{ $lead->phone ?? old('phone') }}">
      </td>
    </tr>

    <tr>
      <td>Address</td>
      <td>
        <textarea required name="address" id="address" cols="30" rows="5">{{ $lead->address }}</textarea>
      </td>
    </tr>

    <tr>
      <td>Customer</td>
      <td>
        <select name="customer_id" id="customer_id" required>
          <option value="">---Select Customer---</option>
          @foreach ($customers as $cust_id => $cust_name)
          <option @if((!empty($lead->customer->id)) && ($lead->customer->id == $cust_id)) selected @endif value="{{ $cust_id }}">{{ $cust_name }}</option>  
          @endforeach
        </select>
      </td>
    </tr>

    <tr>
      <td>Status</td>
      <td>
        <select name="status" id="status">
          <option value="">---Select Status---</option>
          @foreach ($options as $k=>$v)
          <option @if($lead->status == $k) selected @endif value="{{ $k }}">{{ $v }}</option>  
          @endforeach
        </select>
      </td>
    </tr>

    <tr>
      <td colspan="2" style="text-align: center;">
        <button class="btn btn-info" type="submit">Update</button>
        <a class="btn btn-info" style="color:lightyellow !important;" href="{{ route('admin.lead.list') }}">Back</a>
      </td>
    </tr>

  </table>
  
</form>
@endsection