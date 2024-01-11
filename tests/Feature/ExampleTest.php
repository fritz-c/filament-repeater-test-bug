<?php

use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Models\User;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

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
