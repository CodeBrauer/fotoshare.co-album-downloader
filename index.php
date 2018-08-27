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
    $crawler->filter('[data-img][data-url]')->each(function ($node) use ($data) {
        global $data;
        $data[] = $node->extract(['data-img', 'data-url', 'data-width', 'data-height', 'data-type'])[0];
    });

    try {
        $writer = Writer::createFromPath($folder . DIRECTORY_SEPARATOR . 'images.csv', 'w+');
        $writer->insertOne(['Image URL', 'Fotoshare.co Path', 'Width', 'Height', 'Type']);
        $writer->insertAll($data);
    } catch (CannotInsertRecord $e) {
        echo $e->getMessage();
    }

    foreach ($data as $row) {
        file_put_contents($folder . DIRECTORY_SEPARATOR . basename($row[0]), file_get_contents($row[0]));
    }
}

if (php_sapi_name() !== 'cli') {
    require __DIR__ . DIRECTORY_SEPARATOR . 'view.php';
}