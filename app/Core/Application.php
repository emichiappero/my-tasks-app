<?php

namespace App\Core;

use App\Core\Router;
use Dotenv\Dotenv;

class Application
{
  public Router $router;

  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    date_default_timezone_set('UTC');

    $this->router = new Router();
  }

  public function run()
  {
    $this->router->dispatch();
  }
}
