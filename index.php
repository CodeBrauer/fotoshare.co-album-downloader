<?php
require 'vendor/autoload.php';
use Goutte\Client;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

if (isset($_GET['url']) || !empty($argv[1])) {
    $url = isset($_GET['url']) ? $_GET['url'] : trim($argv[1]);

    $folder = __DIR__ . DIRECTORY_SEPARATOR . basename($url);

    if (!is_dir($folder)) {
        $dir = mkdir($folder, 0755);
        if ($dir === false) {
            exit('Error: You need to set the permission correctly!');
        }
    }
    $data = [];
    $client = new Client();
    $crawler = $client->request('GET', $url);
    $crawler->filter('[data-img][data-url]')->each(function ($node) {
        global $data;
        $data[] = $node->extract(['data-img', 'data-url', 'data-thumb', 'data-width', 'data-height', 'data-type'])[0];
    });
    
    $files_count = count($data);
    if (php_sapi_name() !== 'cli') { echo "$files_count files found." . PHP_EOL; }

    try {
        $writer = Writer::createFromPath($folder . DIRECTORY_SEPARATOR . 'images.csv', 'w+');
        $writer->insertOne(['Image URL', 'GIF/Thumbnail', 'Fotoshare.co Path', 'Width', 'Height', 'Type']);
        $writer->insertAll($data);
    } catch (CannotInsertRecord $e) {
        echo $e->getMessage();
    }
    foreach ($data as $key => $row) {
        $index                 = ++$key;
        $download              = [];
        $download['file'] = $row[0];
        $download['gif']  = ($row[5] == 'mp4') ? $row[2] : false;
        foreach ($download as $link) {
            $path = $folder . DIRECTORY_SEPARATOR . basename($link);
            if ($link === false) { continue; }
            if (!file_exists($path)) {
                file_put_contents($path, file_get_contents($link));
                if (php_sapi_name() !== 'cli') { echo "($index/$files_count) Downloaded: " . basename($link) . PHP_EOL; }
            } else {
                if (php_sapi_name() !== 'cli') { echo "($index/$files_count) File skipped: " . basename($link) . PHP_EOL; }
            }
        }
    }
}

if (php_sapi_name() !== 'cli') {
    require __DIR__ . DIRECTORY_SEPARATOR . 'view.php';
}