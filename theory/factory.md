## Factory method

### Представлен в файлах:

* Service\User\User.php
* Service\Product\Product.php
* Service\Order\Basket.php
* ...

### Пример:

```php
    protected function getSomethingRepository(): Model\Repository\Something
    {
        return new Model\Repository\Something();
    }
```

### Используют для:

* Уменьшения связи с другими классами
* Возможности изменять созданный класс, без изменений в основном
* Для имитации (mock) классов в тестах

