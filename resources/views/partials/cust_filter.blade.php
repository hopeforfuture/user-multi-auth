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
<div class="search-area" style="border: 1px solid #000;">
  <form method="GET" action="{{ route('admin.customer.list') }}">
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
        

        <div style="clear: both;position:relative;left:942px;">
          <button class="btn btn-info" type="submit" style="background-color:gold !important;color:#fff;">Search</button>
        </div>
  </form>
</div>