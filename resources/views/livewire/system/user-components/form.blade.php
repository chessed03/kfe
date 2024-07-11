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

        <div class="col-md-12">
            <x-input-text-form 
                label-component="Nombre *"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>  
        
        <div class="col-md-6">
            <x-input-text-form 
                label-component="Correo electrónico *"
                wire-model="email"
                :readonly="false"
                :disabled="false"
            />
        </div>

        <div class="col-md-6">
            <x-select 
                label-component="Tipo *"
                :is-searchable="false"
                :list-items="$list_types"
                wire-model="type_id"
                :is-disabled="false"
                :is-change="false"
                :is-key="false"
            />
        </div>

        @if ($update_mode)
            <div class="col-md-12 mb-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:click="changePassword">
                    <label class="custom-control-label" for="customSwitch1">Cambiar password</label>
                </div>
            </div>
        @endif

        @if (!$update_mode || $password_update)
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <x-input-password-form 
                            label-component="Contraseña *"
                            wire-model="password"
                            :readonly="false"
                            :disabled="false"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-input-password-form 
                            label-component="Repetir contraseña *"
                            wire-model="password_confirmation"
                            :readonly="false"
                            :disabled="false"
                        />
                    </div>
                </div>
            </div>
        @endif

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