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
      bottom: 82px;
      left: 156px;
      transform: translateX(-50%);
      color: white;
      font-weight: bold;
      font-size: 18px;
      white-space: nowrap;
      text-align: center;
      max-width: 80%;
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
            {{ Str::length($item['sponsor_name']) > 12 ? explode(' ', $item['sponsor_name'])[0] : $item['sponsor_name'] }}
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
    document.getElementById('download-all').addEventListener('click', async () => {
      const zip = new JSZip();
      const cards = document.querySelectorAll('#banners .card');

      for (let i = 0; i < cards.length; i++) {
        const card = cards[i];

        // Wait to ensure fonts/images are loaded (optional delay)
        await new Promise(resolve => setTimeout(resolve, 200));

        const canvas = await html2canvas(card, {
          useCORS: true,
          scale: 2,
        });

        const dataUrl = canvas.toDataURL("image/png");
        const content = dataUrl.split(',')[1];
        zip.file(`qr-banner-${i + 1}.png`, content, { base64: true });
      }

      zip.generateAsync({ type: "blob" }).then(blob => {
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'qr-banners.zip';
        link.click();
      });
    });
  </script>
</body>
</html>