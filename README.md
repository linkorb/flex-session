# FlexSession
FlexSession: .env configurable session backends

Allows switching the SessionHandler at Runtime using environment variables.

Using
```php
$typeProvider = TypeProviderFactory::fromEnv('FLEX_SESSION');
$handlerFactory = new FlexSessionHandlerFactory($typeProvider);

$handlerFactory->addType('file', new FileSessionHandlerFactory());
$handlerFactory->addType('memcached', new MemcachedSessionHandlerFactory());
$handlerFactory->addType('pdo', new PdoSessionHandlerFactory());

$handler = new FlexSessionHandler($handlerFactory);
$session = new Session(new NativeSessionStorage([], $handler));
```

Example define environment variable
```
# File based
FLEX_SESSION=file?path=/tmp/my-app-sessions
# Memached
FLEX_SESSION=memcached?server=127.0.0.1
# PDO
FLEX_SESSION=pdo?dsn=mysql:host=localhost;dbname=testdb&username=x&password=y&table=session_table
```

Run tests
```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
```

### Links

[The HttpFoundation Component(Symfony Docs)](https://symfony.com/doc/current/components/http_foundation.html)