<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Euskadi31\Silex\Provider\CorsServiceProvider;
use Api\RoutesLoader;
use Api\Providers\ServicesProvider;
use Api\Providers\RoutesProvider;
use Carbon\Carbon;

$app = new Silex\Application();

date_default_timezone_set('Europe/London');

$app['log.level'] = Monolog\Logger::ERROR;

$app['db.options'] = array(
    'driver' => 'pdo_mysql',
    'user' => 'api',
    'password' => '123456',
    'dbname' => 'api',
    'host' => 'db',
);

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new CorsServiceProvider());

$app->register(new ServiceControllerServiceProvider());

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $app['db.options']
));

$app->register(new HttpCacheServiceProvider(), array('http_cache.cache_dir' => '../var/cache',));

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => '../var/logs/' . Carbon::now('Europe/London')->format('Y-m-d') . '.log',
    'monolog.level' => $app['log.level'],
    'monolog.name' => 'application'
));

$app->register(new ServicesProvider(), []);

$app->register(new RoutesProvider(), []);

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    return new JsonResponse(array('status' => $code, 'message' => $e->getMessage(), 'stacktrace' => $e->getTraceAsString()));
});

$app['http_cache']->run();
