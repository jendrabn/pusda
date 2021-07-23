  <script src="{{ asset('assets/guest/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/guest/js/bootstrap.min.js') }}"></script>
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
      return fetch(`/guest/${resourceName}/chart_data/${id}`)
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
