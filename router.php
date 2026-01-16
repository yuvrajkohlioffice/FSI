<?php
// router.php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$ext = pathinfo($path, PATHINFO_EXTENSION);

// Agar request kisi file (image, css, js) ke liye hai, toh wahi file dikhayein
if (file_exists($_SERVER["DOCUMENT_ROOT"] . $path) && $ext != "") {
    return false; 
} 
// Nahi toh, har request ko details.php par bhej dein (Rewrite Rule jaisa kaam)
else {
    // Yahan check karein ki query string set ho rahi hai ya nahi
    if (!isset($_GET['pgID'])) {
        // URL se slash hata kar pgID mein set karein (simple logic)
        $_GET['pgID'] = ltrim($path, '/');
    }
    include 'details.php';
}
?>