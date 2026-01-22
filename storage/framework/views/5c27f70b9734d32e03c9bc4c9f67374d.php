<div class="p-3">
    
    <select wire:model.live="selectedDriverId" class="form-select">
        <option value="">-- Select Driver --</option>
        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($driver->id); ?>">
                <?php echo e($driver->nameDriver); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <button type="button" class="btn btn-primary mb-3" onclick="startScanner()">
        📷 فتح الكاميرا
    </button>

    <div id="scannerBox" style="display:none" wire:ignore>
        <div id="reader" style="width:100%"></div>
        <button type="button" class="btn btn-danger mt-2" onclick="stopScanner()">
            إغلاق
        </button>
    </div>

    <hr>

    <h5>📦 Barcodes</h5>
    <ul class="list-group">
        <?php $__currentLoopData = $barcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item"><?php echo e($code); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode = null;
    let audioCtx = null;
    let lastCode = null;

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
                if (!decodedText || decodedText === lastCode) return;
                lastCode = decodedText;

                playBeep();
                vibrateSuccess();

                // ✅ هنا نستخدم call() مباشرة على الميثود
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('addBarcode', decodedText);
            },
            (error) => {}
        ).catch(err => alert('Camera error: ' + err));
    }

    function stopScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                document.getElementById('scannerBox').style.display = 'none';
            });
        }
    }
</script>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\barcode\barcode-scanner.blade.php ENDPATH**/ ?>