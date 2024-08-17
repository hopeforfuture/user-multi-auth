<style>
  .search-area {
    padding: 10px;
    margin-top: 5px;
  }
  .input-item {
    margin-right: 10px;
    float: left;
  }
</style>
@php
  $action = '';
  $isCust = $isAdmin = FALSE;
  if(request()->routeIs('admin.lead.list')) {
    $action = route('admin.lead.list');
    $isAdmin = true;
  }
  if(request()->routeIs('customer.lead')) {  
    $action = route('customer.lead');
    $isCust = true;
  }
@endphp
<div class="search-area" style="border: 1px solid #000;">
  <form method="GET" action="{{ $action }}">
        <div class="input-item">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" value="{{ request()->query('name') ?? '' }}">
        </div>

        <div class="input-item">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="{{ request()->query('email') ?? '' }}">
        </div>

        <div class="input-item" style="margin-bottom: 5px;">
          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone" value="{{ request()->query('phone') ?? '' }}">
        </div>
        @if($isAdmin)
        <div class="input-item">
          <label for="phone" style="vertical-align: top;">Customer</label>
          <select name="customer_id[]" id="customer_id" multiple>
            <option value="">---Select Customer---</option>
            @foreach ($customers as $id=>$name)
            <option @if((!empty(request()->query('customer_id'))) && (in_array($id, request()->query('customer_id')))) selected @endif value="{{ $id }}">{{ $name }}</option>  
            @endforeach
          </select>
        </div>
        @endif
        
        <div class="input-item">
          <label for="phone" style="vertical-align: top;">Status</label>
          <select name="status" id="status">
          <option value="">---Select Status---</option>
          @foreach ($options as $k=>$v)
          <option @if(request()->query('status') == $k) selected @endif value="{{ $k }}">{{ $v }}</option>  
          @endforeach
        </select>
        </div>
        

        <div style="clear: both;position:relative;left:942px;">
          <button class="btn btn-info" type="submit" style="background-color:gold !important;color:#fff;">Search</button>
        </div>
  </form>
</div>