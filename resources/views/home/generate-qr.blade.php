<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Generate QR Banners</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="https://stuk.github.io/jszip/dist/jszip.min.js"></script>
  <style>
    .banner-card {
      position: relative;
    }
    .qr-img {
      position: absolute;
      width: 150px;
      top: 130px;
      left: 156px;
      transform: translateX(-50%);
    }
 .sponsor-name {
  position: absolute;
  bottom: 60px;
  left: 156px;
  transform: translateX(-50%);
  color: white;
  font-weight: bold;
  font-size: 18px;
  white-space: nowrap;
  text-align: center;
  max-width: 80%;
  padding: 10px 20px;
  border-radius: 30px;
  background: black;

  /* Neon Glow Border */
  border: 2px solid #8f00ff;
  box-shadow: 
    0 0 5px #fff,
    0 0 10px #8f00ff,
    0 0 20px #8f00ff,
    0 0 40px #8f00ff;
}

  </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand">FITSPORTSY Admin</a>
    </div>
  </nav>

  <div class="container py-5 flex-grow-1">
    <div class="text-center mb-4"><h3 class="fw-bold">QR Banners Preview</h3></div>

    <div id="banners" class="row g-4">
      @foreach ($data as $item)
        <div class="col-md-6">
          <div class="card shadow-sm banner-card">
            <img src="{{ asset('images/sample-qr-holding.png') }}" class="card-img-top" crossorigin="anonymous" />
            <img src="{{ $item['qr'] }}" class="qr-img" crossorigin="anonymous" />
            <div class="sponsor-name">
              {{ strlen($item['sponsor_name']) > 12 ? strtok($item['sponsor_name'], ' ') : $item['sponsor_name'] }}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-4">
      <button id="download-all" class="btn btn-success">Download All as ZIP</button>
    </div>
  </div>

  <footer class="bg-dark text-white py-3 text-center">&copy; 2025 FITSPORTSY</footer>
<script>
  function chunkArray(array, size) {
    const chunks = [];
    for (let i = 0; i < array.length; i += size) {
      chunks.push(array.slice(i, i + size));
    }
    return chunks;
  }

  async function processChunk(chunk, chunkIndex) {
    const zip = new JSZip();

    for (let i = 0; i < chunk.length; i++) {
      const card = chunk[i];

      // Wait for images to load
      const images = card.querySelectorAll('img');
      await Promise.all(Array.from(images).map(img => {
        if (img.complete) return Promise.resolve();
        return new Promise(resolve => (img.onload = resolve));
      }));

      const canvas = await html2canvas(card, {
        useCORS: true,
        scale: 2
      });

      const dataUrl = canvas.toDataURL("image/png");
      const content = dataUrl.split(',')[1];
      zip.file(`qr-banner-${chunkIndex * 50 + i + 1}.png`, content, { base64: true });
    }

    const blob = await zip.generateAsync({ type: "blob" });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `qr-banners-${chunkIndex + 1}.zip`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  document.getElementById('download-all').addEventListener('click', async () => {
    const cards = Array.from(document.querySelectorAll('#banners .card'));
    const chunks = chunkArray(cards, 50);

    for (let i = 0; i < chunks.length; i++) {
      await processChunk(chunks[i], i);
      await new Promise(resolve => setTimeout(resolve, 500)); // Slight delay between downloads
    }

    alert("All ZIPs have been downloaded.");
  });
</script>
</body>
</html>
