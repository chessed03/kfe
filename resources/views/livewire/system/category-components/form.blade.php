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
            <x-input-text-form 
                label-component="Nombre *"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>  
        
        <div class="col-md-6">
            <x-input-text-form 
                label-component="Descripción *"
                wire-model="description"
                :readonly="false"
                :disabled="false"
            />
        </div>

        @if ($update_mode)
            <div class="col-md-10">
                &nbsp;
            </div>
            <div class="col-md-2">
                <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            </div>
        @endif
        
    </div>

</x-modal-data>