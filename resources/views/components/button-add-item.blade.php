<div 
    class="btn btn-outline-{{ $itemValidate ? 'success' : 'secondary' }} avatar-sm rounded-circle bg-{{ $itemValidate ? 'success' : 'secondary' }} waves-effect waves-light mr-2"
    data-toggle="tooltip"
    data-placement="top"
    title=""
    data-original-title="Agregar"
    @if($itemValidate) wire:click="addItem('{{ $itemCode }}')" @endif
>
    <i class="mdi mdi-cart-plus  font-17 avatar-title"></i>
</div>