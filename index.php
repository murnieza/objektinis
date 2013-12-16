<?php

session_start();

ini_set("error_reporting", E_ALL);
ini_set("display_errors", true);

require_once 'Core/autoload.php';

$loader = new Twig_Loader_Filesystem(dirname(__FILE__) . "/Resources/Views/");
$twig = new Twig_Environment($loader, array(
    'cache' => dirname(__FILE__) . "/tmp",
    'debug' => true,
));

$twig->addExtension(new Twig_Extension_Debug());

$view = null;

if (isset($_GET['cl']) && class_exists("Core\\" . $_GET['cl'])) {
    $viewName = "Core\\" . $_GET['cl'];
} else {
    $viewName = "Core\\FrontPage";
}

$view = new $viewName();

if (isset($_GET['fn']) && method_exists($view, $_GET['fn'])) {
    $view->{$_GET['fn']}();
}

$controllerOutput = $view->setTemplateEngine($twig)->render();

$renderer = new \Core\Renderer($twig);

echo  $renderer->render($view);
