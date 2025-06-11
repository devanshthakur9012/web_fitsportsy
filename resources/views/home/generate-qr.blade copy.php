<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>QR Code Banner Preview</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- html2canvas -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">FITSPORTSY Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5 flex-grow-1">
        <div class="text-center mb-4">
            <h3 class="fw-bold">QR Code Banner Preview</h3>
            <p class="text-muted">Preview how your QR code banner will look</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <!-- Banner Preview Wrapper -->
                    <div id="bannerPreview" class="position-relative">
                        <!-- Base Banner -->
                        <img src="{{ $bannerImage }}" class="card-img-top img-fluid" alt="Banner">

                        <!-- QR Code Overlay -->
                        <div style="position: absolute; top: 133px; left: 84px;">
                            <img src="{{ $qrimage }}" class="img-fluid rounded" alt="QR Code">
                        </div>

                        <!-- Sponsor Name Overlay -->
                        <div style="position: absolute;bottom: 78px;left: 97px;color: #ffffff;font-size: 20px;font-family: Arial;">
                            {{ $sponsreName }}
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card-body text-center">
                        <button class="btn btn-primary" onclick="window.location.reload()">Refresh Preview</button>
                        <button class="btn btn-success ms-2" id="downloadImage">Download as Image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-auto">
        <div class="container text-center">
            &copy; 2025 FITSPORTSY. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Download Button JS -->
    <script>
    document.getElementById("downloadImage").addEventListener("click", function() {
        const bannerElement = document.getElementById("bannerPreview");

        html2canvas(bannerElement, {
            useCORS: true,  // important for external images
            allowTaint: true,
            scale: 2  // high-res image
        }).then(canvas => {
            // Create a link element to download the image
            const link = document.createElement("a");
            link.download = "qr_banner.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    });
    </script>

</body>
</html>
