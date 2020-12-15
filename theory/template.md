## Factory method

### Представлен в файле:

* app\Kernel.php

### Пример:

```php
    public function handle(Request $request): Response
    {
        $this->registerConfigs();
        $this->registerRoutes();

        return $this->process($request);
    }
```
