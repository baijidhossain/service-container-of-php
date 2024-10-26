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

// Service Provider for Logger
class LoggerServiceProvider
{
  public function register(ServiceContainer $container)
  {
    $container->register('logger', function () {
      return new Logger();
    });
  }
}

// Service Provider for UserService
class UserServiceProvider
{
  public function register(ServiceContainer $container)
  {
    $container->register('user_service', function ($container) {
      return new UserService($container->get('logger'));
    });
  }
}

// Initialize the service container
$container = new ServiceContainer();

// Register services using the service providers
$loggerProvider = new LoggerServiceProvider();
$loggerProvider->register($container);

$userServiceProvider = new UserServiceProvider();
$userServiceProvider->register($container);

// Register Logger instance as serviceProvider3
$container->register('serviceProvider3', function () {
  return new Logger();
});

// Use the registered services
$serviceProvider2 = $container->get('serviceProvider3');
$serviceProvider2->log("Test log");

// Optionally, get and use UserService
$userService = $container->get('user_service');
$userService->createUser('Baijid Hossain');
