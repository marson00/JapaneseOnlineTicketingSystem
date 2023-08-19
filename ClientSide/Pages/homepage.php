<?php
require_once '../../session/sessionStart.php';
require_once '../../config/connection.php';
require_once './ProxyImage/ProxyImage.php';

$conn = connection::getInstance()->getCon();

// Array of image filenames
$imageFilenames = [
    "../Pictures/pic2.png",
    "../Pictures/AboutUsPic.png",
    "../Pictures/0c10.jpg",
];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <?php include_once '../../config/client_css_links.php'; ?>
    </head>
    <body>
        <!-- Top Navigation Bar -->
        <?php include_once '../adapter/topNav.php'; ?>

        <!-- Event Slideshow -->
        <div id="main-carousel" class="carousel slide bg-dark" data-bs-ride="carousel">
            <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                <?php foreach ($imageFilenames as $index => $filename): ?>
                    <div class="carousel-item <?= $index === 0 ? ' active' : '' ?>">
                        <?php $image = new ProxyImage($filename); $image->displayImage(); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#main-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#main-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- Footer -->
        <?php include_once '../adapter/footer.php'; ?>

        <!-- MDB -->
        <?php include_once '../../config/client_js_links.php'; ?>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>

    </body>
</html>
