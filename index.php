<?php

class ServiceContainer
{
  protected array $services = [];
  protected array $instances = [];

  // Register a service into the container
  public function register(string $name, callable $resolver)
  {
    $this->services[$name] = $resolver;
  }

  // Retrieve the service instance (singleton pattern)
  public function get(string $name)
  {
    // If the instance already exists, return it
    if (isset($this->instances[$name])) {
      return $this->instances[$name];
    }

    // Check if the service is registered
    if (!isset($this->services[$name])) {
      throw new Exception("Service not found: {$name}");
    }

    // Resolve the service and store the instance
    $this->instances[$name] = $this->services[$name]($this);
    return $this->instances[$name];
  }
}

// Example service: Logger class
class Logger
{
  public function log(string $message)
  {
    echo "[LOG]: {$message}\n";
  }
}

// Example service: UserService that depends on Logger
class UserService
{
  protected Logger $logger;

  public function __construct(Logger $logger)
  {
    $this->logger = $logger;
  }

  public function createUser(string $name)
  {
    // Simulate user creation logic
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

// Create a service container instance
$container = new ServiceContainer();

// Register Logger service
$container->register('logger', function () {
  return new Logger();
});

// Register UserService with dependency on Logger
$container->register('user_service', function ($container) {
  return new UserService($container->get('logger'));
});

$container->register('serviceProvider3', function () {
  return new Logger();
});

// Get the UserService from the container and use it
$serviceProvider2 = $container->get('serviceProvider3');
// $userService->createUser('Baijid hossain');


$serviceProvider2->log("test log");
