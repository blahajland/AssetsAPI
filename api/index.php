<?php

include '_tools.php';

/*
 * Request type : GET
 * Parameters :
 *  - type : string among "css" | "json" | "image"
 *  - bucket? : string among "icons" | "apps" | "pictures"
 *  - file : string
 */

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

// Tree search
switch ($_GET['type']) {
    case "css":
        header(formatHeader('Content-type', 'text/css'));
        showFileOrFallback(BASE_URL . "css/", $_GET['file'], "css");
        break;
    case "json":
        header(formatHeader('Content-Type', 'application/json'));
        showFileOrFallback(BASE_URL . "json/", $_GET['file'], "json");
        break;
    case "image":
        $root = BASE_URL . "images/";
        switch ($_GET['bucket']) {
            case "apps":
                showImageOrFallback($root . "apps/", $_GET['file'], "png");
                break;
            case "gifs":
                showImageOrFallback($root . "gifs/", $_GET['file'], "gif");
                break;
            case "icons":
                showImageOrFallback($root . "icons/", $_GET['file'], "png");
                break;
            case "pictures":
                showImageOrFallback($root . "pictures/", $_GET['file'], "png");
                break;
            default:
                http_response_code(401);
                die();
        }
        break;
    default:
        http_response_code(401);
        die();
}