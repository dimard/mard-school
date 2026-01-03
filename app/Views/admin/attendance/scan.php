<!doctype html>
<html lang="en">

<head>
    <?= view('layouts/head_meta', ['pageTitle' => 'Scan QR Absensi']) ?>
    <?= view('layouts/head_css') ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?= view('layouts/loader') ?>
    <?= view('layouts/sidebar') ?>
    <?= view('layouts/topbar') ?>

    <div class="pc-container">
        <div class="pc-content">
            <?= view('layouts/breadcrumb', [
                'pageTitle' => 'Scan QR Absensi',
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => 'admin/dashboard'],
                    ['label' => 'Absensi', 'url' => 'admin/attendance'],
                    ['label' => 'Scan QR']
                ]
            ]) ?>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Scan QR Code</h5>
                        </div>
                        <div class="card-body text-center">
                            <div id="reader" width="600px"></div>
                            <div id="result" class="mt-3"></div>

                            <div class="d-grid gap-2 mt-3">
                                <a href="<?= base_url('admin/attendance') ?>" class="btn btn-secondary">Kembali ke
                                    Daftar Absensi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('layouts/footer_js') ?>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            console.log(`Scan result: ${decodedText}`, decodedResult);

            // Stop scanning temporarily
            // html5QrcodeScanner.clear();

            // Send ajax request
            fetch('<?= base_url('admin/attendance/ajax-scan') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'qr_content=' + encodeURIComponent(decodedText)
            })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('result');
                    if (data.success) {
                        resultDiv.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;

                        // Optional: Play a success sound
                        // var audio = new Audio('success.mp3');
                        // audio.play();
                    } else {
                        resultDiv.innerHTML = `<div class="alert alert-warning">⚠️ ${data.message}</div>`;
                    }

                    // Clear result after 3 seconds
                    setTimeout(() => {
                        resultDiv.innerHTML = '';
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('result').innerHTML = `<div class="alert alert-danger">❌ Error connecting to server</div>`;
                });
        }

        function onScanError(errorMessage) {
            // handle on error condition, with error message
            // console.warn(`Code scan error = ${errorMessage}`);
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
</body>

</html>