<?php

namespace Jwidavid\SelectableRelationTable\Livewire;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Filament\Support\Contracts\TranslatableContentDriver;
use Closure;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SelectableRelationTableRenderer extends Component implements HasTable, HasForms
{
	use InteractsWithTable;
	use InteractsWithForms;

	public array|null $selectedIds = null;
	public string|Closure $modelClass;
	public string|Closure $relationship;
	public mixed $parentRecord;

	public function mount(): void
	{
		if (! is_array($this->selectedIds)) {
			$this->selectedIds = [];
		}
	}

	public function getTableQuery(): Builder
	{
		return $this->getModelClass()::query();
	}

	public function table(Table $table): Table
	{
		return $table
			->query($this->getModelClass()::query())
			->columns([
				CheckboxColumn::make('selected')
					->label('')
					->getStateUsing(fn ($record) => in_array($record->id, $this->selectedIds, true))
					->afterStateUpdated(function (bool $state, $record) {
						if ($state && !in_array($record->id, $this->selectedIds, true)) {
							$this->selectedIds[] = $record->id;
						} elseif (!$state) {
							$this->selectedIds = array_values(array_diff($this->selectedIds, [$record->id]));
						}
					}),
				TextColumn::make('name'),
			]);
	}

	public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
	{
		return null;
	}

	protected function getModelClass(): string
	{
		return is_callable($this->modelClass)
			? call_user_func($this->modelClass)
			: $this->modelClass;
	}

	protected function getRelationship(): string
	{
		return is_callable($this->relationship)
			? call_user_func($this->relationship)
			: $this->relationship;
	}

	protected function getParentRecord()
	{
		return is_callable($this->parentRecord)
			? call_user_func($this->parentRecord)
			: $this->parentRecord;
	}

	public function render(): \Illuminate\View\View
	{
		return view('selectable-relation-table::livewire.selectable-relation-table-renderer');
	}
}
