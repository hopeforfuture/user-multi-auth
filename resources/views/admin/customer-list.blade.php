@extends('admin.layout-dashboard')

@section('content')
@include('partials.cust_filter')
<h3>List of Customers</h3>

<table id="customers">
  <tr>
    <th>SI No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Total Leads</th>
    <th>Action</th>
  </tr>

  @forelse ($customers as $customer)
    <tr>
      <td>{{ $i++ }}</td>
      <td>{{ $customer->name }}</td>
      <td>{{ $customer->email }}</td>
      <td>{{  $customer->phone ?? '-' }}</td>
      <td>{{ count($customer->leads) }}</td>
      <td>
        <a href="{{ route('admin.edit.customer', [$customer->id]) }}"><button class="btn btn-info">EDIT</button></a> 
        <form action="{{ route('admin.delete.customer', [$customer->id] ) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm Delete?');">DELETE</button>
        </form>
        <a target="_blank" href="{{ route('admin.view.customer', [$customer->id]) }}"><button class="btn btn-primary">VIEW</button></a>
        @if (!empty($customer->leads) && (count($customer->leads) > 0))
        <a target="_blank" href="{{ route('admin.lead.list', ['customer_id[]'=>$customer->id]) }}"><button class="btn btn-primary">VIEW LEADS</button></a>
        @endif
        
      </td>
    </tr>
  @empty
      <p>No lead found</p>
  @endforelse

  @if (!empty($customers))
  <tr>
    <td colspan="6" style="text-align: right;">
    {!! $customers->links('vendor.pagination.custom') !!}
    </td>
  </tr>
  @endif
  
</table>
@endsection