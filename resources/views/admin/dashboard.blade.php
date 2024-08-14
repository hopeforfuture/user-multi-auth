@extends('admin.layout-dashboard')
@section('content')
<style>
  table, tr, td {
    padding: 5px;
  }
</style>
<table border="1" style="border-collapse: collapse;margin-top:10px;">
  <tr>
    <td>Name</td>
    <td>{{ $userdata['name'] }}</td>
  </tr>

  <tr>
    <td>Email</td>
    <td>{{ $userdata['email'] }}</td>
  </tr>
</table>
@endsection