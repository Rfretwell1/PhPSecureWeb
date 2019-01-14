<?php
/**
 * @param $container
 * @return \Slim\Views\Twig - returns the views of the slim\views\twig files
 */
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'debug' => true // This line should enable debug mode
        ]
    );

    /**
     * instantiate and add slim specific extension
     */
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    // This line should allow the use of {{ dump() }} debugging in Twig
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};

$container['base64_wrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'Base64Wrapper.php';
    $wrapper = new Base64Wrapper();
    return $wrapper;
};

$container['soap_wrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'SoapWrapper.php';
    $wrapper = new SoapWrapper();
    return $wrapper;
};

$container['session_wrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'SessionWrapper.php';
    $wrapper = new SessionWrapper();
    return $wrapper;
};

$container['account_model'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'AccountModel.php';
    $wrapper = new AccountModel();
    return $wrapper;
};

$container['messages_model'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'MessagesModel.php';
    $wrapper = new MessagesModel();
    return $wrapper;
};

$container['bcrypt_wrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'BcryptWrapper.php';
    $wrapper = new BcryptWrapper();
    return $wrapper;
};


$container['libsodium_wrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'LibSodiumWrapper.php';
    $wrapper = new LibSodiumWrapper();
    return $wrapper;
};

$container['message_validator'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'MessageValidator.php';
    $validator = new MessageValidator();
    return $validator;
};

$container['validator'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'Validator.php';
    $validator = new Validator();
    return $validator;
};

$container['circuitboard_model'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'CircuitboardModel.php';
    $model = new CircuitboardModel();
    return $model;
};


$container['mysql_wrapper'] = function ($container) {
$class_path = $container->get('settings')['class_path'];
require $class_path . 'MySQLWrapper.php';
$mysql_wrapper = new MySQLWrapper();
return $mysql_wrapper;
};


$container['sql_queries'] = function ($container) {
$class_path = $container->get('settings')['class_path'];
require $class_path . 'SQLQueries.php';
$sql_queries = new SQLQueries();
return $sql_queries;
};


$container['dbase'] = function ($container) {

$db_conf = $container['settings']['pdo'];
$host_name = $db_conf['rdbms'] . ':host=' . $db_conf['host'];
$port_number = ';port=' . '3306';
$user_database = ';dbname=' . $db_conf['db_name'];
$host_details = $host_name . $port_number . $user_database;
$user_name = $db_conf['user_name'];
$user_password = $db_conf['user_password'];
$pdo_attributes = $db_conf['options'];
$obj_pdo = null;
try
{
$obj_pdo = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
}
catch (PDOException $exception_object)
{
trigger_error('error connecting to  database');
}
return $obj_pdo;
};