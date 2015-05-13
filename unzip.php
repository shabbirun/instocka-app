<?php
$zip = new ZipArchive;
if ($zip->open('samsofia.zip') === TRUE) {
    $zip->extractTo('/home1/samsofia/public_html/');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}
?>
