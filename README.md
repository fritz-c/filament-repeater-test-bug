# Filament builder test bug

## Setup and reproduction

```sh
cp .env.example .env
touch database/database.sqlite
composer install
php artisan test
```

## Issue description

When testing resources that use the Builder component, the `fillForm` method can throw an exception (`Undefined array key "type"`) if the `data` comes before the `type` key in the json array.

Expected:
`fillForm` should work regardless of the order of the keys in the builder items.

```php
// This one works
it('works with type first', function () {
    livewire(CreateArticle::class)
        ->fillForm(['items' => [[
            'type' => 'note',
            'data' => ['body' => 'hi'],
        ]]])
        ->call('create')
        ->assertHasNoFormErrors();
});

// This one fails
it('works with type last', function () {
    livewire(CreateArticle::class)
        ->fillForm(['items' => [[
            'data' => ['body' => 'hi'],
            'type' => 'note',
        ]]])
        ->call('create')
        ->assertHasNoFormErrors();
});
```
