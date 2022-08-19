<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Home') &mdash; Pusat Data Kabupaten Situbondo</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/front.min.css') }}">
  @yield('styles')
</head>

<body>
  <header>
    <div class="header__top d-none d-lg-block">
      <div class="container">
        <div class="logo"><a href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('img/logo.png') }}"
              alt="Logo"></a>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand d-lg-none">
          <div class="logo">
            <img class="w-auto h-100" src="{{ asset('img/logo.png') }}" alt="Logo">
          </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav m-lg-auto">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('bps.index') | request()->is('guest/bps/*') ? 'active' : '' }}"
                href="{{ route('bps.index') }}">BPS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('rpjmd.index') || request()->is('guest/rpjmd/*') ? 'active' : '' }}"
                href="{{ route('rpjmd.index') }}">RPJMD</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('delapankeldata.index') || request()->is('guest/delapankeldata/*') ? 'active' : '' }}"
                href="{{ route('delapankeldata.index') }}">8 Kelompok Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('skpd') ? 'active' : '' }}" href="{{ route('skpd') }}">SKPD</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('indikator.index') || request()->is('guest/indikator/*') ? 'active' : '' }}"
                href="{{ route('indikator.index') }}">Indikator Kerja</a>
            </li>

            @if (auth()->check())
              <li class="nav-item">
                @php
                  $role = auth()->user()->role;
                @endphp
                @if ($role == 1)
                  <a class="nav-link " href="{{ route('admin.dashboard') }}">Dashboard</a>
                @elseif($role == 2)
                  <a class="nav-link " href="{{ route('admin-skpd.dashboard') }}">Dashboard</a>
                @endif
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link " href="{{ route('login') }}">Login</a>
              </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="https://tawk.to/pusdasitubondo" target="_blank" rel=noreferrer>Live Chat</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    @yield('content')
  </main>

  <div class="scroll-top">
    <button class="btn btn-dark" type="button" aria-label="Scroll to top">
      <i class="fas fa-arrow-up"></i>
    </button>
  </div>

  <footer>
    <div class="footer__top">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 footer__item">
            <h5>Pengembang</h5>
            <ul>
              <li>Tim PKL <a href="https://ilkom.unej.ac.id" class="text-decoration-none" target="_blank"
                  rel=noreferrer>Fakultas Ilmu Komputer
                  Universitas Jember</a></li>
              <li><a href="https://unej.ac.id/id" target="_blank" rel=noreferrer class="logo"><img class="img-fluid"
                    src="{{ asset('img/logo-unej.png') }}" alt="Logo Universitas Jember"></a></li>
            </ul>
          </div>
          <div class="col-lg-4 footer__item">
            <h5>Alamat</h5>
            <ul>
              <li>Pemerintah Kabupaten Situbondo <br>
                Jln. P.B. Sudirman No.1 Kabupaten Situbondo 68312, Provinsi Jawa Timur
              </li>
            </ul>
          </div>
          <div class="col-lg-4 footer__item">
            <h5>Kontak Kami</h5>
            <ul>
              <li>Telp : [0338] 674096, 671161 / [0338] 674222 ext 236</li>
              <li>Fax. : [0338] 674096, 671885</li>
              <li>Email: <a href="mailto:admin@situbondokab.go.id">admin@situbondokab.go.id</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="container"><span>2021 © PUSDA Situbondo</span> | <a href="http://kominfo.situbondokab.go.id"
          target="_blank" rel=noreferrer>Dinas Kominfo dan
          Persandian Pemkab Situbondo</a></div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.0/dist/chart.min.js"
    integrity="sha256-sKuIOg+m9ZQb96MRaiHCMzLniSnMlTv1h1h4T74C8ls=" crossorigin="anonymous"></script>
  <script>
    initScrollTop();

    function initScrollTop() {
      const scrollTopElement = document.querySelector('.scroll-top');
      const headerHeight = document.getElementsByTagName('header')[0].clientHeight;

      scrollTopElement.addEventListener('click', function() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0; // for safari
      });

      window.addEventListener('scroll', function() {
        if (pageYOffset > headerHeight) {
          scrollTopElement.classList.add('show');
        } else {
          scrollTopElement.classList.remove('show');
        }
      });
    }

    function initHandleShowChartModal(resourceName) {
      const modalChart = new bootstrap.Modal(document.getElementById('modal-chart'), {
        keyboard: false
      });
      const btnCharts = document.querySelectorAll('.btn-chart');
      btnCharts.forEach(element => {
        element.addEventListener('click', async (e) => {
          const id = e.target.dataset.id;

          try {
            const uraian = await getUraian(id, resourceName);
            renderChart(uraian);
            modalChart.show();
          } catch (error) {
            console.log(error);
          }

        });
      });
    }

    function getUraian(id, resourceName) {
      return fetch(`/${resourceName}/chart_data/${id}`)
        .then(res => {
          if (!res.ok) {
            return Promise.reject(res.statusText)
          }
          return res.json();
        })
        .then(res => res);
    }

    function renderChart(data) {
      const chartContainer = document.getElementById('chart-container');
      const canvas = document.createElement('canvas');
      canvas.id = 'chart';
      const btnDownload = document.getElementById('btn-download-chart');
      btnDownload.removeEventListener('click', () => {});

      chartContainer.innerHTML = '';
      chartContainer.appendChild(canvas);

      const {
        isi,
        ketersedian_data,
        uraian,
        satuan
      } = data;

      const years = data.isi.map((v, i) => v.tahun).reverse();
      const isiUraian = data.isi.map((v, i) => v.isi).reverse();

      const context = document.getElementById('chart').getContext('2d');
      const chart = new Chart(context, {
        type: 'bar',
        data: {
          labels: years,
          datasets: [{
            label: uraian,
            data: isiUraian,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255,99,132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

      btnDownload.addEventListener('click', () => {
        const image = chart.toBase64Image();
        const a = document.createElement('a');
        a.href = image;
        a.download = `chart-uraian-${uraian}.png`;
        a.click();
      })

    }
  </script>

  @yield('scripts')
</body>

</html>
