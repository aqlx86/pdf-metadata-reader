<?php

require_once '../PDFMetadataReader.php';

$pdf = 'example.pdf';

$metadata = PDFMetadataReader::factory($pdf);

// return all metadata;
print_r($metadata->info());

// specific info
echo 'Title:' . $metadata->Title;

