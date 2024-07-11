<div class="form-group" x-data="{ amount_input: @entangle($wireModel) }">
    <label for="{{ $wireModel }}" class="control-label mb-1">{{ $labelComponent }}</label>
    <input
        type="text"
        class="form-control mb-1"
        id="{{ str_replace('.', '_', $wireModel) }}"
        x-model="amount_input"
        @input="amount_input = $event.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
        wire:model="{{ $wireModel }}"
        placeholder="{{ str_replace('*', '', $labelComponent) }}"
        autocomplete="off"
        @readonly($readonly)
        @disabled($disabled)
    >
    @error($wireModel)<h6> <span class="error text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</span> </h6>@enderror
</div>