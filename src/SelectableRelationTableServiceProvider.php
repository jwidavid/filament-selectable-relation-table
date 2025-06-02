<?php

namespace jwidavid\SelectableRelationTable;

use Illuminate\Support\ServiceProvider;

class SelectableRelationTableServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'selectable-relation-table');
	}
}
