<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = $_GET['url'];
$html = file_get_contents($url);
$html = str_replace(array("\n", "\r"), '', $html);
$html = substr_replace($html, '<base href="' . $url . '" target="_self">', strpos($html, '</head>'), 0);
$html = preg_replace('/\<script.*?<\/script\>/im', '', $html);
$html = preg_replace('/\<noscript.*?<\/noscript\>/im', '', $html);
$html = preg_replace('/\<style.*?<\/style\>/im', '', $html);
$html = preg_replace('/\<link.*?\>/im', '', $html);
$html = preg_replace('/\<!--.*?--\>/im', '', $html);
$html = preg_replace('/onclick=".*?"/im', '', $html);
$html = preg_replace('/(<a\s.*?)href=".*?"(.*?>)/im', '$1$2', $html);
$html = preg_replace('/\s\s+/im', ' ', $html);

echo $html;