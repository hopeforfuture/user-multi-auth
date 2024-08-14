@extends('lead.layout-dashboard')

@section('content')
  <style>
    table, tr, td {
      padding: 5px;
    }
  </style>
  <table border="1" style="border-collapse: collapse;margin-top:10px;">
    <tr>
      <td>Name</td>
      <td>{{ $leaddata['name'] }}</td>
    </tr>

    <tr>
      <td>Email</td>
      <td>{{ $leaddata['email'] }}</td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>{{ $leaddata['phone'] ?? '-' }}</td>
    </tr>

    <tr>
      <td>Address</td>
      <td>{{ $leaddata['address'] }}</td>
    </tr>

    <tr>
      <td>Customer Name</td>
      <td>{{ $leaddata['customer']['name'] ?? '-' }}</td>
    </tr>
  </table>
@endsection