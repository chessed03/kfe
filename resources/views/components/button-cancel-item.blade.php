<div 
    class="btn btn-outline-{{ $itemValidate ? 'danger' : 'secondary' }} avatar-sm rounded-circle bg-{{ $itemValidate ? 'danger' : 'secondary' }} waves-effect waves-light mr-2"
    data-toggle="tooltip"
    data-placement="top"
    title=""
    data-original-title="Cancelar"
    @if($itemValidate) wire:click="addItem('{{ false }}')" @endif
>
    <i class="mdi mdi-cart-plus  font-17 avatar-title"></i>
</div>