<div class="row">

    <div class="col-md-12">
        <x-input-code-form 
            label-component="Código del producto"
            wire-model="product_code"
            :is-change="true"
            wire-change="addCode()"
            :readonly="false"
            :disabled="false"
        />
    </div>

    <div class="col-md-12">
        <x-table-sale 
            :is-empty-list="$listModule->isEmpty()"
            :headers-table="$headers_table_sale"
            :wire-targets="$action_loader"
        >
            
            @foreach ($listModule as $key => $item)
                                        
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">
                        {{ _currencyFormat_($item->price) }}
                    </td>
                    <td class="text-right">
                        {{ _currencyFormat_($item->total) }}
                    </td>
                </tr>
                
            @endforeach
            
        </x-table-sale>
    </div>

    <div class="col-md-10 text-right">
        <h5><b>SUBTOTAL</b></h5>
    </div>
    <div class="col-md-2 text-right">
        <h5><b>{{ _currencyFormat_($amount_subtotal) }}</b></h5>
    </div>
    <div class="col-md-10 text-right">
        <h5><b>IVA (16%)</b></h5>
    </div>
    <div class="col-md-2 text-right">
        <h5><b>{{ _currencyFormat_($amount_iva) }}</b></h5>
    </div>
    <div class="col-md-10 text-right">
        <h4><b>TOTAL</b></h4>
    </div>
    <div class="col-md-2 text-right">
        <h4><b>{{ _currencyFormat_($amount_total) }}</b></h4>
    </div>

    <div class="col-md-12">
        <hr>
    </div>

    <div class="col-md-6">
        <button
            type="button"
            class="btn btn-block btn-lg btn-danger waves-effect waves-light"
            wire:click="cancelSale()"
        >
            Cancelar venta
        </button>
    </div>

    <div class="col-md-6">
        <button
            type="button"
            class="btn btn-block btn-lg btn-primary waves-effect waves-light"
            wire:click="chargeSale()"
        >
            Cobrar venta
        </button>
    </div>

</div>