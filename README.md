# Componenta HTTP PSR

Server request creation integration for Componenta HTTP. The package registers `Nyholm\Psr7Server\ServerRequestCreatorInterface` from PSR-17 factories and provides small request-aware contracts.

It intentionally does not install a concrete PSR-7 implementation. Install one integration package such as `componenta/http-psr-nyholm`, `componenta/http-psr-diactoros`, `componenta/http-psr-guzzle`, or `componenta/http-psr-slim`.

## Installation

```bash
composer require componenta/http-psr componenta/http-psr-nyholm
```

## Configuration

`Componenta\Http\ConfigProvider` registers `ServerRequestCreatorInterface`. It requires these PSR-17 services in the container:

- `ServerRequestFactoryInterface`
- `UriFactoryInterface`
- `UploadedFileFactoryInterface`
- `StreamFactoryInterface`

Concrete integration packages provide those aliases.

## Request-Aware Contracts

`ServerRequestAwareInterface` declares a set-only property:

```php
public ServerRequestInterface $serverRequest { set; }
```

`ServerRequestProviderInterface` declares a get-only property for services that expose the current request. `ServerRequestAware` is a trait that implements both get and set behavior for classes that need to store the current request.

## Related Packages

- [`componenta/app-http`](../app-http/README.md) uses this package to create the current server request.
- PSR-7 integration packages provide concrete factories.
