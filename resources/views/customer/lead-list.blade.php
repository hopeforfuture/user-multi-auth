@extends('customer.layout-dashboard')

@section('content')
@include('partials.lead_filter')
<h3>List of Leads</h3>

<table id="customers">
  <tr>
    <th>SI No</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Action</th>
  </tr>

  @forelse ($leads as $lead)
    <tr>
      <td>{{ $i++ }}</td>
      <td>{{ $lead->name }}</td>
      <td>{{ $lead->email }}</td>
      <td>{{  $lead->phone ?? '-' }}</td>
      <td>{{  $lead->status_text }}</td>
      <td>
        <a href="{{ route('customer.edit.lead', [$lead->id]) }}"><button class="btn btn-info">EDIT</button></a> 
        <form action="{{ route('customer.delete.lead', [$lead->id] ) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm Delete?');">DELETE</button>
        </form>
        <a href="{{ route('customer.view.lead', [$lead->id]) }}"><button class="btn btn-primary">VIEW</button></a> 
      </td>
    </tr>
  @empty
      <p>No lead found</p>
  @endforelse

  @if (!empty($leads))
  <tr>
    <td colspan="6" style="text-align: right;">
    {!! $leads->links('vendor.pagination.custom') !!}
    </td>
  </tr>
  @endif
  
</table>
@endsection