<?php

declare(strict_types=1);

use Componenta\Config\ConfigFactory;
use Componenta\Config\ConfigKey;
use Componenta\Config\Environment;
use Componenta\DI\ContainerFactory;
use Componenta\Http\ConfigProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

it('creates incoming requests through the configured PSR factories', function (): void {
    $factory = new Psr17Factory();
    $composition = (new ConfigFactory())->create(new Environment([]),
        new ConfigProvider(),
        static fn (): array => [
            ConfigKey::DEPENDENCIES => [
                ConfigKey::SERVICES => [
                    ServerRequestFactoryInterface::class => $factory,
                    UriFactoryInterface::class => $factory,
                    StreamFactoryInterface::class => $factory,
                    UploadedFileFactoryInterface::class => $factory,
                ],
            ],
        ],
    );
    $container = (new ContainerFactory())->create($composition->config, $composition->dependencies);
    $creator = $container->get(ServerRequestCreatorInterface::class);

    $request = $creator->fromArrays(
        server: ['REQUEST_METHOD' => 'POST', 'REQUEST_URI' => '/orders?id=1', 'QUERY_STRING' => 'id=1', 'SERVER_NAME' => 'example.test', 'SERVER_PORT' => '80'],
        headers: ['Content-Type' => 'application/x-www-form-urlencoded'],
        cookie: ['session' => 'test-session'],
        get: ['id' => '1'],
        post: ['name' => 'Ada'],
        body: 'name=Ada',
    );

    expect($request->getMethod())->toBe('POST')
        ->and((string) $request->getUri())->toBe('http://example.test/orders?id=1')
        ->and($request->getCookieParams())->toBe(['session' => 'test-session'])
        ->and($request->getQueryParams())->toBe(['id' => '1'])
        ->and($request->getParsedBody())->toBe(['name' => 'Ada'])
        ->and($request->getHeaderLine('Content-Type'))->toBe('application/x-www-form-urlencoded')
        ->and((string) $request->getBody())->toBe('name=Ada');
});
