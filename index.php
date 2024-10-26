<?php

class ServiceContainer
{
  protected array $services = [];
  protected array $instances = [];

  public function register(string $name, callable $resolver)
  {
    $this->services[$name] = $resolver;
  }

  public function get(string $name)
  {
    if (isset($this->instances[$name])) {
      return $this->instances[$name];
    }

    if (!isset($this->services[$name])) {
      throw new Exception("Service not found: {$name}");
    }

    $this->instances[$name] = $this->services[$name]($this);
    return $this->instances[$name];
  }
}

class Logger
{
  public function log(string $message)
  {
    echo "[LOG]: {$message}\n";
  }
}

class UserService
{
  protected Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->logger = $logger;
  }

  public function createUser(string $name)
  {
    $this->logger->log("User '{$name}' created.");
  }
}

class serviceProvider2
{
  function test($param = "default value")
  {
    echo $param;
  }
}

$container = new ServiceContainer();

$container->register('logger', function () {
  return new Logger();
});

$container->register('user_service', function ($container) {
  return new UserService($container->get('logger'));
});

// Register off Logger class name as serviceProvider3.... Return Logger class instance
$container->register('serviceProvider3', function () {
  return new Logger();
});

$serviceProvider2 = $container->get('serviceProvider3');
$serviceProvider2->log("Test log");

// Uncomment the following lines to use UserService
// $userService = $container->get('user_service');
// $userService->createUser('Baijid Hossain');
