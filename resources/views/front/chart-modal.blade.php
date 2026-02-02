<div aria-hidden="true"
     aria-labelledby="chart-modal-title"
     class="modal fade"
     id="modal-chart"
     tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title"
                    id="chart-modal-title">Grafik Data</h5>
                <button aria-label="Close"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        type="button"></button>
            </div>
            <div class="modal-body chart-modal-body"
                 id="chart-container">
                <div class="chart-state chart-state--loading d-none"
                     id="chart-loading">
                    <div class="spinner-border text-primary"
                         role="status"></div>
                    <p class="mb-0 mt-3">Memuat data grafik...</p>
                </div>
                <div class="chart-state chart-state--error d-none"
                     id="chart-error"></div>
                <canvas class="w-100 d-none"
                        id="chart-isi-uraian"></canvas>
            </div>
            <div class="modal-footer border-top-0">
                <button class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                        type="button">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
