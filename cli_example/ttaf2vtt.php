<?php

use JoeBot0101\WebVtt\Converters\TtafVttConverter;

include_once __DIR__ . '/../vendor/autoload.php';

if (validate_arguments($argv)) {
    do_conversion($argv);
};

function validate_arguments($argv)
{
    $arguments_valid = true;
    if (count($argv) < 2 || $argv[1] == '--help') {
        $arguments_valid = false;
        __help();
    }

    if (isset($argv[1]) && $argv[1] == "") {
        $arguments_valid = false;
        echo "The first argument must be the path to the source you are converting from.";
    }

    if (isset($argv[2]) && $argv[2] == "") {
        $arguments_valid = false;
        echo "The second argument must be the path to the converted WebVTT file.";
    }

    return $arguments_valid;
}

function do_conversion(array $argv)
{
    $source = $argv[1];
    $destination = $argv[2];

    if (is_dir($source)) {
        convert_directory($source, $destination);
    } else {
        convert_file($source, $destination);
    }
}

function convert_file($source, $destination)
{
    try {
        $ttaf2vtt = new TtafVttConverter($source);
        $vtt = $ttaf2vtt->convertToVtt();
        $vtt->toFile($destination);
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}

function convert_directory($source, $destination)
{
    if (!file_exists($destination)) {
        mkdir($destination);
    }

    $files = scandir($source);
    foreach ($files as $file) {
        if ($file == "." || $file == "..") {
            continue;
        }
        $file_info = pathinfo($file);
        if ($file_info['extension'] !== 'xml') {
            continue;
        }

        $source_file = $source . DIRECTORY_SEPARATOR . $file;
        $destination_file = $destination . DIRECTORY_SEPARATOR . $file_info['filename'] . '.vtt';
        convert_file($source_file, $destination_file);
    }
}

function __help()
{
    echo "ttaf2vtt:" . PHP_EOL;
    echo "========" . PHP_EOL . PHP_EOL;
    echo "Example usage for converting an individual file:" . PHP_EOL;
    echo "php ttaf2vtt.php path/to/source.xml path/to/destination.vtt" . PHP_EOL . PHP_EOL;
    echo "Example usage for converting an directory of files:" . PHP_EOL;
    echo "php ttaf2vtt.php path/to/source_dir path/to/destination_dir/" . PHP_EOL . PHP_EOL;
}
