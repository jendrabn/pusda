@if (session('success-message'))
  <div class="alert alert-success">
    <h5><i class="icon fas fa-check"></i> Success</h5>
    {{ session('success-message') }}
  </div>
@endif

@if (session('error-message'))
  <div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> Error!</h5>
    {{ session('error-message') }}
  </div>
@endif

{{-- @if ($errors->any())
  <div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> Error!</h5>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif --}}
