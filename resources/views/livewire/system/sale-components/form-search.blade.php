<div class="row">

    <div class="col-md-12">

        <x-select 
            label-component="Producto"
            :is-searchable="true"
            :list-items="$listProducts"
            wire-model="selected_id"
            :is-disabled="false"
            :is-change="true"
            wire-change="productSelected()"
            :is-key="false"
        />

    </div>

    <div class="col-md-12">

        <x-table-sale 
            :is-empty-list="$listSearch->isEmpty()"
            :headers-table="$headers_table_search"
            :wire-targets="$action_loader"
        >
            
            @foreach ($listSearch as $key => $item)       
                <tr>
                    <td>
                        <input
                            type="number"
                            class="form-control"
                            wire:model="itemQuantities.{{ $item->code }}"
                            value="0"
                            min="1"
                        >
                    </td>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ _currencyFormat_($item->price) }}</td>
                    <td class="text-right">
                        <div class="row">
                            
                            <div class="col-md-6 text-right">
                                <div x-on:click="openBarFilters  = !openBarFilters;" >
                                    <x-button-add-item :item-code="$item->code" :item-validate="true"/>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                <x-button-cancel-item :item-validate="true"/>
                            </div>
                            
                        </div>
                    </td>
                </tr>
            @endforeach   
        </x-table-sale>

    </div>

</div>