<x-modal-data :modal-title="$modal_title" :modal-show-footer="false">

    <p class="sub-header">
        
    </p>

    <div class="row">               

        <div class="col-md-6 text-right">
            <h3><b>SUBTOTAL</b></h3>
        </div>
        <div class="col-md-3 text-right">
            <h3><b>{{ _currencyFormat_($amount_subtotal) }}</b></h3>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div>

        <div class="col-md-6 text-right">
            <h3><b>IVA (16%)</b></h3>
        </div>
        <div class="col-md-3 text-right">
            <h3><b>{{ _currencyFormat_($amount_iva) }}</b></h3>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div>

        <div class="col-md-6 text-right">
            <h1><b>TOTAL</b></h1>
        </div>
        <div class="col-md-3 text-right">
            <h1><b>{{ _currencyFormat_($amount_total) }}</b></h1>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div>

        <div class="col-md-6 text-right">
            <h1><b>EFECTIVO</b></h1>
        </div>
        <div class="col-md-3 text-right">
            
            <div class="form-group" x-data="{ amount_input: @entangle("amount_payment") }">
                <input
                    type="text"
                    class="form-control mb-1  pay-sale-input"
                    x-model="amount_input"
                    @input="amount_input = $event.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    wire:model="amount_payment"
                    wire:keyup="processPayment()"
                    placeholder="0.00"
                    autocomplete="off"
                >
                @error("amount_payment")<h6> <span class="error text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</span> </h6>@enderror
            </div>

        </div>
        <div class="col-md-3">
            &nbsp;
        </div>
        <div class="col-md-6 text-right">
            <h1><b>CAMBIO</b></h1>
        </div>
        <div class="col-md-3 text-right">
            <h1><b>{{ _currencyFormat_($amount_change) }}</b></h1>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-6">
            <button
                type="button"
                class="btn btn-block btn-lg btn-danger waves-effect waves-light"
                wire:click="declineChange()"
            >
                Cancelar
            </button>
        </div>
    
        <div class="col-md-6">
            <button
                type="button"
                class="btn btn-block btn-lg btn-dark waves-effect waves-light"
                wire:click="confirmCharge()"
            >
                Aceptar
            </button>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>

</x-modal-data>


<style>
    .pay-sale-input {
        text-align: right;
        font-size: 2.3rem;
        font-weight: 600;
    }
</style>