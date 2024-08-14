@extends('customer.layout-dashboard')

@section('content')
  <style>
    table, tr, td {
      padding: 5px;
    }
  </style>
  <table border="1" style="border-collapse: collapse;margin-top:10px;">
    <tr>
      <td>Name</td>
      <td>{{ $custdata['name'] }}</td>
    </tr>

    <tr>
      <td>Email</td>
      <td>{{ $custdata['email'] }}</td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>{{ $custdata['phone'] }}</td>
    </tr>

    <tr>
      <td>Address</td>
      <td>{{ $custdata['address'] }}</td>
    </tr>
  </table>
@endsection