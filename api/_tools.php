<?php

include_once "_consts.php";

function formatHeader(string $key, string $value): string
{
    return $key . ": " . $value;
}

function isValidRequest(array $reqs): bool
{
    $sz = sizeof($reqs);
    return
        $sz > 0 &&
        $sz < 4 &&
        isset($reqs['type']) &&
        isset($reqs['file']) &&
        !($reqs['type'] === "images") ||
        isset($reqs['bucket']);
}

function showFileOrFallback(string $path, string $filePath, string $format): void
{
    $file = file_get_contents($path . $filePath . "." . $format);
    if ($file === false) {
        echo file_get_contents($path . FALLBACK . "." . $format);
    } else {
        echo $file;
    }
}

function showImageOrFallback(string $path, string $request, string $format): void
{
    header(formatHeader('Content-type', 'image/' . $format));
    $file = file_get_contents($path . $request . "." . $format);
    if ($file === false) {
        $error = file_get_contents($path . FALLBACK . "." . $format);
        clearstatcache();
        header(formatHeader("Content-Length", strlen($error)));
        header(formatHeader("Content-Disposition", "inline; filename=" . FALLBACK . "." . $format));
        echo $error;
    } else {
        header(formatHeader("Content-Length", strlen($file)));
        header(formatHeader("Content-Disposition", "inline; filename=" . $request . "." . $format));
        clearstatcache();
        echo $file;
    }
}