<x-filament-forms::field-wrapper
        :id="$getId()"
        :label="$getLabel()"
        :helper-text="$getHelperText()"
        :hint="$getHint()"
        :hint-icon="$getHintIcon()"
        :state-path="$getStatePath()"
        :is-required="$isRequired()"
>
    <livewire:selectable-relation-table-renderer
            :model-class="$getModelClass()"
            :relationship="$getRelationship()"
            :parent-record="$getParentRecord()"
            :selected-ids="$getState() ?? []"
            wire:model.defer="{{ $getStatePath() }}"
    />
</x-filament-forms::field-wrapper>
