<?php

declare(strict_types=1);

use Componenta\Config\ConfigKey;
use Componenta\Http\ConfigProvider;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

it('registers only the server request creator factory', function (): void {
    $config = (new ConfigProvider())();
    $dependencies = $config[ConfigKey::DEPENDENCIES];

    expect($dependencies[ConfigKey::FACTORIES])
        ->toHaveKey(ServerRequestCreatorInterface::class)
        ->toHaveCount(1)
        ->and($dependencies[ConfigKey::ALIASES] ?? [])
        ->not->toHaveKeys([
            RequestFactoryInterface::class,
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
            UriFactoryInterface::class,
        ]);
});
