<?php

declare(strict_types=1);

namespace Componenta\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestProviderInterface
{
    public ServerRequestInterface $serverRequest { get; }
}
