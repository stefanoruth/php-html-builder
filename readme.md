# HtmlBuilder

A PHP Library to building HTML dynamically.

### Example
PHP Code
```php
Html::tag('div')->class('foo')->id('bar')->addChild(
    Html::tag('a')->href('/login')->text('Login')
)->toHtml();
```
Result
```html
<div>
    <a href="/login">Login</a>
</div>
```

Running tests `vendor/bin/phpunit`