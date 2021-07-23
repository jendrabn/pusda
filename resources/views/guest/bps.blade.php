@extends('guest.layouts.app')

@section('title')
  BPS
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">BPS</h4>
      </div>
      <div class="card-body">
        @include('guest.partials.menu-tree-bps')
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const canvas = document.querySelectorAll('.isi-uraian-chart');

    canvas.forEach(async (element) => {
      const id = element.dataset.id;

      try {
        const data = await getSummaryUraian(id);

        const context = element.getContext('2d');
        const chart = new Chart(context, {
          type: 'line',
          data: {
            labels: data.label,
            datasets: [{
              fill: true,
              label: data.nama,
              data: data.data,
              borderColor: '#748ffc',
              backgroundColor: 'RGB(116, 143, 252, 0.25)',
              borderWidth: 1
            }],
          },
          options: {
            scales: {
              yAxes: {
                stacked: true,
                grid: {
                  color: '#e9ecef',
                  borderColor: '#495057',
                  tickColor: '#495057'
                },
                beginAtZero: true
              },
              xAxes: {
                grid: {
                  color: '#fff',
                  borderColor: '#495057',
                  tickColor: '#495057'
                }
              }
            }
          }
        });
      } catch (error) {
        console.log(error);
      }
    });

    function getSummaryUraian(id) {
      return fetch(`/guest/bps/chart_summary/${id}`)
        .then(res => {
          if (!res.ok) {
            return Promise.reject(res.statusText);
          }
          return res.json();
        })
        .then(res => res);
    }
  </script>
@endpush
