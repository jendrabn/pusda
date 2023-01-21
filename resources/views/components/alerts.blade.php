@if (session('success-message'))
  <div class="alert alert-success">
    <h5><i class="icon fas fa-check"></i> Success</h5>
    {{ session('success-message') }}
  </div>
@endif

@if (session('error-message'))
  <div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> Error</h5>
    {{ session('error-message') }}
  </div>
@endif
