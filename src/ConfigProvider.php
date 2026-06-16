<?php

declare(strict_types=1);

namespace Componenta\Http;

use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class ConfigProvider extends \Componenta\Config\ConfigProvider
{
    protected function getFactories(): array
    {
        return [
            ServerRequestCreatorInterface::class => static function (ContainerInterface $container): ServerRequestCreatorInterface {
                return new ServerRequestCreator(
                    $container->get(ServerRequestFactoryInterface::class),
                    $container->get(UriFactoryInterface::class),
                    $container->get(UploadedFileFactoryInterface::class),
                    $container->get(StreamFactoryInterface::class),
                );
            },
        ];
    }
}
