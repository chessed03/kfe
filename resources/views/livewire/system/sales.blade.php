<div class="row">
    
    <div class="col-lg-12">

        <div class="card-box">

            <div class="row" x-data="{ openBarFilters: false }">                 

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">

                            <p class="sub-header">
                                @foreach ($modal_warnings as $warning)
                                    <i class="mdi mdi-chevron-right"></i> {{ $warning }}.
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </p>

                        </div>
                        <div class="col-md-6">

                            <button
                                type="button"
                                x-on:click="openBarFilters =! openBarFilters"
                                x-bind:class="{'btn-dark': !openBarFilters, 'btn-danger': openBarFilters}"
                                class="btn waves-effect waves-light float-right"
                            >
                                <i x-bind:class="{'fe-monitor mr-1': !openBarFilters, 'fe-x mr-1': openBarFilters}"></i> 
                                <span x-text="openBarFilters ? 'Cerrar buscador' : 'Buscar producto'"></span>
                            </button>
        
                        </div>
                    </div>
                </div>
                
                <div 
                    class="col-md-12" 
                    x-show="openBarFilters"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                >

                    @include('livewire.system.sale-components.form-search')

                </div>                   

                <div 
                    class="col-md-12"
                    x-show="!openBarFilters"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                >

                    @include('livewire.system.sale-components.form-sale')

                </div>
                
            </div>
            
        </div>

    </div>    

    @include('livewire.system.sale-components.charge-sale')

</div>