<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Productos más vendidos</h4>
            </div>
        
            <div class="col-md-6" wire:ignore>
                <label for="take">Mostrando</label>
                <select 
                    wire:model.live="take"
                    id="take"
                    class="selectpicker"
                >
                    <option value="1">&nbsp;1 Productos</option>
                    <option value="2">&nbsp;2 Productos</option>
                    <option value="3" selected>&nbsp;3 Productos</option>
                    <option value="4">&nbsp;4 Productos</option>
                    <option value="5">&nbsp;5 Productos</option>
                    <option value="6">&nbsp;6 Productos</option>
                    
                </select>
            </div> 
        
            <div class="col-md-6">
                &nbsp;                    
            </div> 
            @foreach ($listProducts as $pro => $product)
        
                <div class="col-md-4 mt-3">
                    <div class="card-box border">
                        
                        <h4 class="header-title mt-0 mb-2 loat-left d-flex align-items-center">
        
                            <div class="avatar-sm bg-soft-primary rounded d-flex align-items-center justify-content-center">
                                <i class="fe-tag avatar-title font-22 text-primary"></i>
                            </div>
        
                            <span class="ml-2">{{ $product->name }}</span>
                        </h4>
        
                        <div class="mt-1">
        
                            <div class="float-left d-flex align-items-center" dir="ltr">
                                <div class="avatar-sm bg-soft-success rounded d-flex align-items-center justify-content-center">
                                    <i class="fe-shopping-cart avatar-title font-22 text-success"></i>
                                </div>
                                <span class="ml-2 font-14">{{ $product->quantity }} Vendidos</span>
                            </div>
        
                            <div class="text-right">
                                <h2 class="mt-3 pt-1 mb-1"> {{ _currencyFormat_($product->total) }} </h2>
                                <p class="text-muted mb-0">Pesos</p>
                            </div>
        
                        </div>
                    </div>
                </div>
            
            @endforeach
        </div>
    </div>
</div>