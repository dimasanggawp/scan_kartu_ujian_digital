<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="img/kertofix.webp" rel="icon">
    <link href="img/kerto_kecil.webp" rel="apple-touch-icon">

    <!-- jQuery CDN -->
    <script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>

    <!-- Scan Barcode -->
    <script src="<?php echo e(asset('js/html5-qrcode.min.js')); ?>"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo e(asset('js/sweetalert.min.js')); ?>"></script>

    <title>Scan Kartu Ujian</title>
    <style>
        /* Your existing CSS */
    </style>
</head>

<body>
    <div class="container">
        <center>
            <img src="img/kertofix.webp" width="80px">
            <h1>SCAN KARTU PESERTA</h1>
            <hr>

            <div style="width: 100%" id="reader"></div>

            <script>
                var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                    fps: 10,
                    qrbox: 250
                });

                function onScanSuccess(decodedText, decodedResult) {
                    console.log(`Scan result: ${decodedText}`, decodedResult);

                    swal({
                            title: "Kirim data sekarang?",
                            text: "Anda akan memasukkan data ke dalam sistem",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willSend) => {
                            if (willSend) {
                                swal("Berhasil", "Data " + decodedText + " berhasil dimasukkan!", {
                                    icon: "success",
                                });
                                
                                $url = `<?php echo e(url('proses')); ?>/${decodedText}`;
                                console.log('Decoded Text = ', `${decodedText}`);
                                console.log('URL = ', $url);

                                // First Ajax Call to Your Backend
                                $.ajax({
                                    url: `<?php echo e(url('proses')); ?>/${decodedText}`,
                                    type: 'GET',
                                    success: function(response) {
                                        console.log("Data from backend:", response);

                                        // Second Fetch Request to WhatsApp API (Using Example URL and Headers)
                                        const whatsAppApiUrl = '<?php echo e(config('app.whatsapp_api')); ?>';
                                        const whatsAppData = new URLSearchParams();
                                        whatsAppData.append('device_id', 'd7714f6b3aecddb6ad4b82f5edb491cf');
                                        whatsAppData.append('number', response.data_peserta.no_hp);
                                        whatsAppData.append('message', response.message);

                                        fetch(whatsAppApiUrl, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: whatsAppData.toString()
                                            })
                                            .then(whatsAppResponse => {
                                                console.log('WhatsApp API Response:', whatsAppResponse);
                                            })
                                            .catch(error => {
                                                console.error('Error in WhatsApp API request:', error);
                                            });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error in AJAX request to backend:', error);
                                    }
                                });

                            } else {
                                swal("Silahkan scan barcode lagi");
                            }
                        });
                }

                function onScanError(errorMessage) {
                    console.error('Scan error:', errorMessage);
                }

                html5QrcodeScanner.render(onScanSuccess, onScanError);
            </script>
            <hr>
            <br>
            <!-- <a href="https://docs.google.com/spreadsheets/d/1CEVy_33zzB7--02NZwM_G1HLsTfVUVhnqWgZzlMFCtg/edit?usp=sharing">
                <button class="button button1">Lihat Hasil Absen</button>
            </a> -->

        </center>
    </div>
</body>

</html>
<?php /**PATH /home/u630072599/domains/smkkartanegara.sch.id/public_html/cbt/praktik/resources/views/index.blade.php ENDPATH**/ ?>