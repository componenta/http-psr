# Componenta HTTP PSR

Интеграция создания серверного запроса для Componenta HTTP. Пакет регистрирует `Nyholm\Psr7Server\ServerRequestCreatorInterface` из PSR-17 фабрик и дает небольшие контракты для сервисов, которым нужен текущий запрос.

Пакет намеренно не устанавливает конкретную реализацию PSR-7. Установите один интеграционный пакет: `componenta/http-psr-nyholm`, `componenta/http-psr-diactoros`, `componenta/http-psr-guzzle` или `componenta/http-psr-slim`.

## Установка

```bash
composer require componenta/http-psr componenta/http-psr-nyholm
```

## Конфигурация

`Componenta\Http\ConfigProvider` регистрирует `ServerRequestCreatorInterface`. Для этого в контейнере должны быть PSR-17 сервисы:

- `ServerRequestFactoryInterface`
- `UriFactoryInterface`
- `UploadedFileFactoryInterface`
- `StreamFactoryInterface`

Конкретные интеграционные пакеты предоставляют эти псевдонимы.

## Request-aware контракты

`ServerRequestAwareInterface` объявляет set-only свойство:

```php
public ServerRequestInterface $serverRequest { set; }
```

`ServerRequestProviderInterface` объявляет get-only свойство для сервисов, которые отдают текущий запрос. `ServerRequestAware` является trait и реализует чтение и запись текущего запроса.

## Связанные пакеты

- [`componenta/app-http`](../app-http/README.ru.md) использует этот пакет для создания текущего серверного запроса.
- Интеграционные PSR-7 пакеты предоставляют конкретные фабрики.
