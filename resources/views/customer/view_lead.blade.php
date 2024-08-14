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
      <td>{{ $lead['name'] }}</td>
    </tr>

    <tr>
      <td>Email</td>
      <td>{{ $lead['email'] }}</td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>{{ $lead['phone'] }}</td>
    </tr>

    <tr>
      <td>Address</td>
      <td>{{ $lead['address'] }}</td>
    </tr>
  </table>
@endsection