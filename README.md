# Filament repeater test bug

## Setup and reproduction

```sh
cp .env.example .env
touch database/database.sqlite
composer install
php artisan migrate:fresh --seed
php artisan test
```

## Issue description

When testing resources that use the Repeater component, the `fillForm` method, due to its approach of deep-filling data one value at a time, will create invalid states that do not occur in normal use. In this repro, the `itemLabel` callback has an assumption that `$state` is pre-loaded with the keys corresponding to the repeater items' schema, with each key's value initialized to null when nothing has been set yet. This assumption is valid when rendering the form normally, but is not correct when in the test environment using the test helpers, causing errors.

Expected:
The `livewire` test helper and its `fillForm` method should initialize form state for tests in a fashion identical to normal form rendering.

```php
// From the resource:
->itemLabel(function (array $state): ?string {
    if (! $state['author'] || ! $state['title']) {
        return null;
    }

    return "{$state['author']}: {$state['title']}";
})
```

```php
// This fails due to an absent 'title' key in $state
it('populates multiple fields in schema', function () {
    livewire(CreateArticle::class)
        ->fillForm(['quotes' => [[
            'author' => 'Sally',
            'title' => 'Foo',
            'body' => 'Bar',
        ]]])
        ->call('create')
        ->assertHasNoFormErrors();
});
```
