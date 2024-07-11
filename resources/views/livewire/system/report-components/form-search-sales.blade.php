<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Ventas por período</h4>
            </div>

            <div class="col-md-6">
                <x-input-date-form 
                    label-component="Inicio de período *"
                    wire-model="date_start"
                    :is-change="true"
                    wire-change="dateRange()"
                    :readonly="false"
                    :disabled="false"
                />
            </div>

            <div class="col-md-6">
                <x-input-date-form 
                    label-component="Fin de período *"
                    wire-model="date_end"
                    :is-change="true"
                    wire-change="dateRange()"
                    :readonly="false"
                    :disabled="false"
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
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ _currencyFormat_($item->price) }}</td>
                            <td class="text-right">{{ _currencyFormat_($item->total) }}</td>
                        </tr>
                        
                    @endforeach
                    
                    
                    
                </x-table-sale>
            </div>
        </div>
    </div>
</div>