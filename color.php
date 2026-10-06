<?php
$im = imagecreatefromjpeg('assets/images/logo.jpg');
$rgb = imagecolorat($im, 0, 0);
$colors = imagecolorsforindex($im, $rgb);
printf('#%02x%02x%02x', $colors['red'], $colors['green'], $colors['blue']);
?>
