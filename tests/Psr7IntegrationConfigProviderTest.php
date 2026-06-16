<?php

declare(strict_types=1);

use Componenta\Config\ConfigKey;
use Componenta\Http\Psr7\Diactoros\ConfigProvider as DiactorosConfigProvider;
use Componenta\Http\Psr7\Guzzle\ConfigProvider as GuzzleConfigProvider;
use Componenta\Http\Psr7\Nyholm\ConfigProvider as NyholmConfigProvider;
use Componenta\Http\Psr7\Slim\ConfigProvider as SlimConfigProvider;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

it('registers concrete psr17 aliases only in implementation packages', function (
    string $provider,
    array $aliases,
    array $factories,
    array $invokables,
): void {
    $config = (new $provider())();
    $dependencies = $config[ConfigKey::DEPENDENCIES];

    expect($dependencies[ConfigKey::ALIASES])->toMatchArray($aliases)
        ->and(array_keys($dependencies[ConfigKey::FACTORIES] ?? []))->toBe($factories)
        ->and($dependencies[ConfigKey::INVOKABLES] ?? [])->toBe($invokables);
})->with([
    'nyholm' => [
        NyholmConfigProvider::class,
        [
            RequestFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
            ResponseFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
            ServerRequestFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
            StreamFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
            UploadedFileFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
            UriFactoryInterface::class => 'Nyholm\\Psr7\\Factory\\Psr17Factory',
        ],
        ['Nyholm\\Psr7\\Factory\\Psr17Factory'],
        [],
    ],
    'diactoros' => [
        DiactorosConfigProvider::class,
        [
            RequestFactoryInterface::class => 'Laminas\\Diactoros\\RequestFactory',
            ResponseFactoryInterface::class => 'Laminas\\Diactoros\\ResponseFactory',
            ServerRequestFactoryInterface::class => 'Laminas\\Diactoros\\ServerRequestFactory',
            StreamFactoryInterface::class => 'Laminas\\Diactoros\\StreamFactory',
            UploadedFileFactoryInterface::class => 'Laminas\\Diactoros\\UploadedFileFactory',
            UriFactoryInterface::class => 'Laminas\\Diactoros\\UriFactory',
        ],
        [],
        [
            'Laminas\\Diactoros\\RequestFactory',
            'Laminas\\Diactoros\\ResponseFactory',
            'Laminas\\Diactoros\\ServerRequestFactory',
            'Laminas\\Diactoros\\StreamFactory',
            'Laminas\\Diactoros\\UploadedFileFactory',
            'Laminas\\Diactoros\\UriFactory',
        ],
    ],
    'guzzle' => [
        GuzzleConfigProvider::class,
        [
            RequestFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
            ResponseFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
            ServerRequestFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
            StreamFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
            UploadedFileFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
            UriFactoryInterface::class => 'GuzzleHttp\\Psr7\\HttpFactory',
        ],
        ['GuzzleHttp\\Psr7\\HttpFactory'],
        [],
    ],
    'slim' => [
        SlimConfigProvider::class,
        [
            RequestFactoryInterface::class => 'Slim\\Psr7\\Factory\\RequestFactory',
            ResponseFactoryInterface::class => 'Slim\\Psr7\\Factory\\ResponseFactory',
            ServerRequestFactoryInterface::class => 'Slim\\Psr7\\Factory\\ServerRequestFactory',
            StreamFactoryInterface::class => 'Slim\\Psr7\\Factory\\StreamFactory',
            UploadedFileFactoryInterface::class => 'Slim\\Psr7\\Factory\\UploadedFileFactory',
            UriFactoryInterface::class => 'Slim\\Psr7\\Factory\\UriFactory',
        ],
        [],
        [
            'Slim\\Psr7\\Factory\\RequestFactory',
            'Slim\\Psr7\\Factory\\ResponseFactory',
            'Slim\\Psr7\\Factory\\ServerRequestFactory',
            'Slim\\Psr7\\Factory\\StreamFactory',
            'Slim\\Psr7\\Factory\\UploadedFileFactory',
            'Slim\\Psr7\\Factory\\UriFactory',
        ],
    ],
]);
