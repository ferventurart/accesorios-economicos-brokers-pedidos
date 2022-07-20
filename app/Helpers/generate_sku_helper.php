<?php

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;

function sku_generator($productName, $categoryName, $productId)
{
    $results = ''; // empty string
    $part1 = strtoupper(substr($categoryName, 0, 4));
    $part2 = strtoupper(substr($productName, 0, 4));
    $part3 =  $productId;
    $results .= "{$part1}-{$part2}{$part3}";
    return $results;
}

function sku_png_printer($sku)
{
    $generator = new BarcodeGeneratorPNG();
    echo '<p class="fs-3">'.$sku.'</p> <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($sku, $generator::TYPE_CODE_128)) . '">';
}

function sku_html_printer($sku)
{
    $generator = new BarcodeGeneratorHTML();
    return $generator->getBarcode($sku, $generator::TYPE_CODE_128);
}
