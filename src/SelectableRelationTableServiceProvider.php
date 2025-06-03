<?php

namespace Jwidavid\SelectableRelationTable;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Jwidavid\SelectableRelationTable\Livewire\SelectableRelationTableRenderer;

class SelectableRelationTableServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'selectable-relation-table');

		Livewire::component('selectable-relation-table-renderer', SelectableRelationTableRenderer::class);
	}
}
