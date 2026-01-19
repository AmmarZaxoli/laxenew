<div>
    <div class="p-3">
    <div class="row">
        <div class="col-md-6">
            <!-- Driver Selection & Scanner -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">📦 Driver & Scanner</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Select Driver</label>
                        <select wire:model.live="selectedDriverId" class="form-select">
                            <option value="">-- Select Driver --</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">
                                    {{ $driver->nameDriver }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="startScanner()">
                        📷 فتح الكاميرا لمسح الباركود
                    </button>

                    <div id="scannerBox" style="display:none" wire:ignore>
                        <div id="reader" style="width:100%; min-height: 300px;"></div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-danger" onclick="stopScanner()">
                                إغلاق الكاميرا
                            </button>
                        </div>
                    </div>

                    @if($selectedDriverId)
                        <div class="mt-3">
                            <h6>📋 Scanned Barcodes</h6>
                            <div class="list-group">
                                @forelse ($barcodes as $index => $code)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $code }}</span>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                wire:click="removeBarcode({{ $index }})">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <div class="list-group-item text-muted text-center">
                                       
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Two Tables Side by Side -->
            <div class="row">
                <!-- Left Table: Driver's Invoices -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📄 Driver's Invoices</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($driverInvoices as $invoice)
                                            <tr class="{{ in_array($invoice['num_invoice_sell'], $barcodes) ? 'table-success' : '' }}">
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $invoice['num_invoice_sell'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $invoice['customer_name'] }}</td>
                                                <td>${{ number_format($invoice['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">
                                                    @if($selectedDriverId)
                                                        No invoices found for this driver
                                                    @else
                                                        Select a driver to view invoices
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                Total: {{ count($driverInvoices) }} invoices
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Right Table: Scanned Invoices -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">✅ Scanned Invoices</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($scannedInvoices as $invoice)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ $invoice['num_invoice_sell'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $invoice['customer_name'] }}</td>
                                                <td>${{ number_format($invoice['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">
                                                    No scanned invoices yet
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                Scanned: {{ count($scannedInvoices) }} invoices
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Card at Bottom -->
@if($selectedDriverId && count($scannedInvoices) > 0)
    <div class="p-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📊 Scan Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3>{{ count($driverInvoices) }}</h3>
                                <p class="text-muted mb-0">Total Driver Invoices</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-success">{{ count($scannedInvoices) }}</h3>
                                <p class="text-muted mb-0">Scanned Invoices</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-danger">{{ count($driverInvoices) - count($scannedInvoices) }}</h3>
                                <p class="text-muted mb-0">Remaining</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode = null;
    let audioCtx = null;
    let lastCode = null;
    let lastScanTime = 0;
    const COOLDOWN = 1500;

    function playBeep() {
        if (!audioCtx) audioCtx = new(window.AudioContext || window.webkitAudioContext)();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'square';
        osc.frequency.setValueAtTime(1000, audioCtx.currentTime);
        gain.gain.setValueAtTime(0.15, audioCtx.currentTime);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.15);
    }

    function vibrateSuccess() {
        if (navigator.vibrate) navigator.vibrate(200);
    }

    function startScanner() {
        document.getElementById('scannerBox').style.display = 'block';
        html5QrCode = new Html5Qrcode("reader");

        html5QrCode.start({
                facingMode: "environment"
            }, {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 120
                }
            },
            (decodedText) => {
                const now = Date.now();
                if (decodedText === lastCode && (now - lastScanTime) < COOLDOWN) {
                    return;
                }
                lastCode = decodedText;
                lastScanTime = now;
                playBeep();
                vibrateSuccess();
                @this.call('addBarcode', decodedText);
            }
        ).catch(err => alert('Camera error: ' + err));
    }

    function stopScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                document.getElementById('scannerBox').style.display = 'none';
                lastCode = null;
            });
        }
    }
</script>

<style>
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .table-responsive::-webkit-scrollbar {
        width: 5px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
</style>
</div>