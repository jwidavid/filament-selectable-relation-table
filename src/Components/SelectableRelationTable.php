<?php

namespace Jwidavid\SelectableRelationTable\Components;

use Filament\Forms\Components\Field;

class SelectableRelationTable extends Field
{
	protected string $view = 'selectable-relation-table::components.selectable-relation-table';

	// Custom properties
	protected string|\Closure|null $modelClass = null;
	protected string|\Closure|null $relationship = null;
	protected mixed $parentRecord = null;

	public function modelClass(string|\Closure $modelClass): static
	{
		$this->modelClass = $modelClass;

		return $this;
	}

	public function relationship(string|\Closure $relationship): static
	{
		$this->relationship = $relationship;

		return $this;
	}

	public function parentRecord(mixed $record): static
	{
		$this->parentRecord = $record;

		return $this;
	}

	public function getModelClass(): string
	{
		return is_callable($this->modelClass) ? call_user_func($this->modelClass) : $this->modelClass;
	}

	public function getRelationship(): string
	{
		return is_callable($this->relationship) ? call_user_func($this->relationship) : $this->relationship;
	}

	public function getParentRecord(): mixed
	{
		return is_callable($this->parentRecord) ? call_user_func($this->parentRecord) : $this->parentRecord;
	}
}
