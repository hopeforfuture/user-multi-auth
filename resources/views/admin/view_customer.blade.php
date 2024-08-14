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
      <td>{{ $customer->name }}</td>
    </tr>

    <tr>
      <td>Email</td>
      <td>{{ $customer->email }}</td>
    </tr>

    <tr>
      <td>Phone</td>
      <td>{{ $customer->phone ?? '-' }}</td>
    </tr>

    <tr>
      <td>Lead Count</td>
      <td>
        @if (!empty($customer->leads) && (count($customer->leads) > 0))
        {{ count($customer->leads) }}
        @else
        {{ 0 }}
        @endif
      </td>
    </tr>

    <tr>
      <td>Address</td>
      <td>{{ $customer->address }}</td>
    </tr>
  </table>
@endsection