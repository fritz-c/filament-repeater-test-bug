<?php

use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Models\User;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

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
