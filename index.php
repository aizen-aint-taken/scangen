<?php
include_once("barcode.php"); // Include the barcode generator logic
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Generator and Scanner</title>
    <script src="https://cdn.jsdelivr.net/npm/@zxing/library@0.18.5/dist/index.min.js"></script>
    <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Barcode Generator and Scanner</h1>
    
    <!-- Barcode Generator Form -->
    <form id="barcode-form" action="barcode.php" method="post">
        <input type="text" id="text_message" name="text_message" placeholder="Enter text for barcode" required>
        <button type="submit" name="submit">Generate Barcode</button>
    </form>

    <!-- Display Generated Barcode -->
    <div class="barcode-container" id="barcode-container">
        <?php if (isset($barcode)): ?>
            <img src="<?php echo $barcode; ?>" alt="Generated Barcode">
        <?php endif; ?>
    </div>

    <!-- Barcode Scanner Section -->
    <div id="scanner">
        <h3>Scan Barcode</h3>
        <div id="reader" style="width: 300px; height: 300px; border: 1px solid #ccc; margin-bottom: 20px;">
            <!-- Video element will be shown here for the camera feed -->
        </div>
        <input type="text" id="scanner-output" placeholder="Scanned text will appear here" readonly>
    </div>

    <script>
        // Barcode Scanner: HTML5 QR Code library
        const html5QrCode = new Html5Qrcode("reader");

        // Start scanning for barcodes using the camera
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Start scanning from the first available camera
                html5QrCode.start(
                    devices[0].id, // The camera device ID
                    {
                        fps: 10, // frames per second
                        qrbox: { width: 250, height: 250 } // scanning box dimensions
                    },
                    (decodedText) => {
                        // Display the decoded barcode text in the input field
                        document.getElementById('scanner-output').value = decodedText;
                    },
                    (errorMessage) => {
                        // Handle errors (if scanning fails)
                        console.error(`Scanning error: ${errorMessage}`);
                    }
                );
            }
        }).catch((err) => {
            // Handle errors (if camera access fails)
            console.error(`Camera error: ${err}`);
        });
    </script>

    <script src="barcode.js"></script>
</body>
</html>
