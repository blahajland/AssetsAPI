<?php

const BASE_URL = "../";
const REDIRECT = "https://blahaj.land/";
const FALLBACK = "_fallback";

function formatHeader(string $key, string $value): string
{
    return $key . ": " . $value;
}

function errorAndDie($error): void
{
    echo $error;
    die();
}

function isValidRequest(array $reqs): bool
{
    $sz = sizeof($reqs);
    return
        $sz > 0 &&
        $sz < 4 &&
        isset($reqs['type']) &&
        isset($reqs['file']);
}

function getPath(string $path, string $fileName, string $format): string
{
    return $path . $fileName . $format;
}

function showFileOrFallback(string $path, string $fileName, string $format): array
{
    $file = file_get_contents(getPath($path, $fileName, $format));
    $headerfn = $fileName . $format;
    if ($file === false) {
        $err = file_get_contents(getPath($path, FALLBACK, $format));
        $lenght = strlen($err);
        echo $err;
    } else {
        $lenght = strlen($file);
        echo $file;
    }
    return [$lenght, $headerfn];
}


function getTree($path)
{
    $treeFile = file_get_contents($path) or errorAndDie("No tree available");
    $treeRoot = json_decode($treeFile, true) or errorAndDie("No tree available");
    $tree = $treeRoot["_entrypoint"] or errorAndDie("No tree available");
    return $tree;
}

function conditionalFormat($string, $placeholder, $value): string
{
    return str_replace($placeholder, $value, $string);
}