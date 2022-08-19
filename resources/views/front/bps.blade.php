@extends('front.layouts.app')
@section('title', 'BPS')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">BPS</h4>
      </div>
      <div class="card-body">
        <ol>
          @foreach ($categories as $category)
            <li>
              {{ $category->nama_menu }}
              @if ($category->childs->count())
                <ol style="list-style-type: lower-latin">
                  @foreach ($category->childs as $child)
                    <li>
                      {{ $child->nama_menu }}
                      @if ($child->childs->count())
                        <ul style="list-style-type: disc">
                          @foreach ($child->childs as $child)
                            <li>
                              <a class="text-decoration-none"
                                href="{{ route('bps.table', $child->id) }}">{{ $child->nama_menu }}</a>
                              <div>
                                <canvas class="isi-uraian-chart" width="13" height="5"
                                  data-id="{{ $child->id }}"></canvas>
                              </div>
                            </li>
                          @endforeach
                        </ul>
                      @endif
                    </li>
                  @endforeach
                </ol>
              @endif
            </li>
          @endforeach
        </ol>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
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
      return fetch(`/bps/chart_summary/${id}`)
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
