<?php
/**
 * Shared document head and navigation. Set $title before including.
 */
require_once __DIR__ . '/helpers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>soundsphere.net - <?php echo e($title); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<meta name="theme-color" content="#886FC6">
<link rel="stylesheet" href="/Style/style.css">
<link rel="icon" type="image/png" href="/Static/favicon.png">
<script src="/Static/sort.js" defer></script>
<script src="/Static/search.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>
