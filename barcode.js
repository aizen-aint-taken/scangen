const form = document.getElementById('barcode-form');
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const textMessage = document.getElementById('text_message').value.trim();

    if (!textMessage) {
        alert('Please enter a valid text!');
        return;
    }

    const response = await fetch('barcode.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `text_message=${encodeURIComponent(textMessage)}&submit=true`
    });

    const data = await response.text();
    document.getElementById('barcode-container').innerHTML = `<img src="${data}" alt="Generated Barcode">`;
});

// Barcode Scanner
const html5QrCode = new Html5Qrcode("reader");
Html5Qrcode.getCameras().then((devices) => {
    if (devices && devices.length) {
        html5QrCode.start(
            devices[0].id,
            {
                fps: 10, // frames per second
                qrbox: { width: 250, height: 250 } // scanning box dimensions
            },
            (decodedText) => {
                document.getElementById('scanner-output').value = decodedText;
            },
            (errorMessage) => {
                console.error(`Scanning error: ${errorMessage}`);
            }
        );
    }
}).catch((err) => {
    console.error(`Camera error: ${err}`);
});