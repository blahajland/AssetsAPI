<?php

include '_tools.php';

header(formatHeader('Access-Control-Allow-Origin', '*'));

// Block POST requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    http_response_code(400);
    die();
}

if (!isValidRequest($_GET)) {
    http_response_code(401);
    die();
}

$path = BASE_URL;
$currentNode = getTree('../json/filetree.json');

if (array_key_exists($_GET['type'], $currentNode)) {
    $currentNode = $currentNode[$_GET['type']];
    $path = $path . $currentNode['path'];
    if ($currentNode['is-bucket']) {
        if (!(
            isset($_GET['bucket']) &&
            array_key_exists($_GET['bucket'], $currentNode['buckets']))
        ) {
            http_response_code(401);
            die();
        }
        $currentNode = $currentNode['buckets'][$_GET['bucket']];
        $path = $path . $currentNode['path'];
    }
    header(formatHeader('Content-Type',$currentNode['content-type']));
    $res = showFileOrFallback($path, $_GET['file'], $currentNode['type']);
    foreach ($currentNode['headers'] as $header) {
        $formattedHeader = conditionalFormat($header, '##size##', $res[0]);
        $formattedHeader = conditionalFormat($formattedHeader, '##filename##', $res[1]);
        header($formattedHeader);
    }
    die();
}
