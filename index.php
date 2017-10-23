<?php
require 'lib/config.php';
require 'lib/Twig/Autoloader.php';
Twig_Autoloader::register(true);
$loader = new Twig_Loader_Filesystem($config->twigTemplate . '/' . basename(__DIR__));
$loader->addPath('templates');
$twig = new Twig_Environment ($loader, array(
		'cache' => '../' . $config->twigCache,
		'debug' => $config->debug
));
$twig->addExtension(new Twig_Extension_Debug());
$twigVars = array();
$twigVars['current_url'] = $_SERVER['REQUEST_URI'];
$template = $twig->loadTemplate('index.html');
$template->display($twigVars);