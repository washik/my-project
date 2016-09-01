<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

$params = $_GET;
if (!empty($params['path'])) {
    $params = explode('/', $params['path']);
}

include('class/Templates.php');
include('class/Db.php');

$pdo = new Db('root', 'me', 'localhost', 'symfony_loc');
$pdo = $pdo->getConnection();

$tenplates = new Templates($params, $pdo);
echo $tenplates->getHtml();



function d($text, $exit = false) {
    echo "<br>\n ------------------------ DUMP ----------- <br>\n";

    if (is_array($text))  {
        echo "<pre>";
        print_r($text);
        echo "</pre>";
    } elseif(is_object($text)) {
        var_dump($text);
    } else {
        echo $text;
    }
    if ($exit) die();
}