# PHP Service Container

A lightweight service container implementation in PHP that supports dependency injection and service registration through dedicated service providers.

## Overview

This project demonstrates the use of a **Service Container** and **Service Providers** to manage dependencies and service registration in PHP applications. 

### Components

- **ServiceContainer**: 
  - Manages service registration and retrieval.
  
- **Logger**: 
  - Responsible for logging messages.

- **UserService**: 
  - Uses `Logger` to log user creation.

- **LoggerServiceProvider**: 
  - A dedicated service provider that registers the `Logger` service.

- **UserServiceProvider**: 
  - A dedicated service provider that registers the `UserService`, which depends on the `Logger`.

## Usage

### Register Services

1. **Create instances** of your service providers (`LoggerServiceProvider` and `UserServiceProvider`).

2. **Call their `register()` methods**, passing the service container instance to register their respective services:

   ```php
   $loggerProvider = new LoggerServiceProvider();
   $loggerProvider->register($container);

   $userServiceProvider = new UserServiceProvider();
   $userServiceProvider->register($container);
