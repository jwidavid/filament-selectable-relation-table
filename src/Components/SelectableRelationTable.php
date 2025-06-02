<?php

namespace YourVendor\SelectableRelationTable\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SelectableRelationTable extends Field implements HasTable, HasForms
{
	use InteractsWithForms;
	use InteractsWithTable;

	protected string $view = 'selectable-relation-table::components.selectable-relation-table';

	public string $modelClass;
	public string $relationship;
	public mixed $parentRecord;

	public function modelClass(string $modelClass): static
	{
		$this->modelClass = $modelClass;

		return $this;
	}

	public function relationship(string $relationship): static
	{
		$this->relationship = $relationship;

		return $this;
	}

	public function parentRecord(mixed $record): static
	{
		$this->parentRecord = $record;

		return $this;
	}

	public function getTableQuery(): Builder
	{
		/** @var \Illuminate\Database\Eloquent\Model $model */
		$model = $this->modelClass;

		return $model::query();
	}

	public function table(Table $table): Table
	{
		return $table
			->columns([
				CheckboxColumn::make('attach')
					->label('')
					->getStateUsing(fn ($record): bool => in_array($record->id, $this->getState() ?? []))
					->afterStateUpdated(function (bool $state, $record) {
						$selected = $this->getState() ?? [];

						$updated = $state
							? array_unique([...$selected, $record->id])
							: array_values(array_diff($selected, [$record->id]));

						$this->state($updated);
					}),

				ImageColumn::make('thumbnail')
					->label('Image')
					->circular()
					->getStateUsing(fn ($record) => method_exists($record, 'getFirstMediaUrl')
						? $record->getFirstMediaUrl('thumbnail')
						: null),

				TextColumn::make('name')
					->sortable()
					->searchable(),
			])
			->paginated()
			->searchable();
	}
}
