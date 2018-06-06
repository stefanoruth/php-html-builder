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
<div class="foo" id="bar">
    <a href="/login">Login</a>
</div>
```

### Tests
Running tests in console `vendor/bin/phpunit`
