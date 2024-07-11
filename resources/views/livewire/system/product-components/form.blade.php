<x-modal-data :modal-title="$modal_title" :modal-show-footer="true">

    <p class="sub-header">
        @foreach ($modal_warnings as $warning)
            <i class="mdi mdi-chevron-right"></i> {{ $warning }}.
            @if (!$loop->last)
                <br>
            @endif
        @endforeach
    </p>

    <div class="row">               

        <div class="col-md-6">
            <x-input-code-form 
                label-component="Código *"
                wire-model="code"
                :is-change="false"
                :readonly="false"
                :disabled="false"
            />
        </div> 

        <div class="col-md-6">
            <x-input-text-form 
                label-component="Nombre *"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>  
        
        <div class="col-md-12">
            <x-input-text-form 
                label-component="Descripción *"
                wire-model="description"
                :readonly="false"
                :disabled="false"
            />
        </div>

        <div class="col-md-6">
            <x-select 
                label-component="Categoría *"
                :is-searchable="false"
                :list-items="$list_categories"
                wire-model="category_id"
                :is-disabled="false"
                :is-change="false"
                :is-key="false"
            />
        </div>

        <div class="col-md-{{ ($update_mode) ? '4' : '6' }}">
            <x-input-amount-form 
                label-component="Precio *"
                wire-model="price"
                :readonly="false"
                :disabled="$update_mode ? !$price_update : false"
            />
        </div>
        
        @if ($update_mode)
            <div class="col-md-2 mb-2">
                <div class="custom-control custom-switch pt-4">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:click="changePrice">
                    <label class="custom-control-label" for="customSwitch1">Actualizar precio</label>
                </div>
            </div>

            <div class="col-md-10">
                &nbsp;
            </div>
            <div class="col-md-2">
                <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            </div>
        @endif
        
    </div>

</x-modal-data>