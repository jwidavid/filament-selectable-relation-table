<?php

namespace Jwidavid\SelectableRelationTable;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Jwidavid\SelectableRelationTable\Livewire\SelectableRelationRenderer;

class SelectableRelationTableServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'selectable-relation-table');

		Livewire::component('selectable-relation-renderer', SelectableRelationRenderer::class);
	}
}
