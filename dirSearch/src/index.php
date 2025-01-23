<?php
function sumCountFiles($directory) {
    $sum = 0;

    if (!is_dir($directory)) {
        return $sum;
    }

    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $file;

        if (is_dir($path)) {
            $sum += sumCountFiles($path);
        } elseif ($file == 'count') {
            $content = file_get_contents($path);
            $sum += intval($content);
        }
    }

    return $sum;
}

$directory = './dir';
$totalSum = sumCountFiles($directory);
echo "Общая сумма: " . $totalSum;