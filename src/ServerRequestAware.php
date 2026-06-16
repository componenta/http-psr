<?php

declare(strict_types=1);

namespace Componenta\Http;

use Psr\Http\Message\ServerRequestInterface;

trait ServerRequestAware
{
    private ServerRequestInterface $currentServerRequest;

    public ServerRequestInterface $serverRequest {
        get => $this->currentServerRequest;
        set => $this->currentServerRequest = $value;
    }
}
