<?php

namespace App\Livewire\System;

use App\Livewire\Traits\DispatchServices;
use App\Livewire\Traits\ModalServices;
use App\Models\System\Sale;
use Livewire\Component;

class Sales extends Component
{
    use DispatchServices;
    use ModalServices;
    
    //*** Default variables to needs into component ***//
    public $action_loader, $headers_table_sale, $headers_table_search, $modal_title,  $modal_warnings, $modal_target, $selected_id;
    //**! Variables to needs into model             ***//
    public $product_code, $amount_subtotal, $amount_iva, $amount_total, $amount_payment, $amount_change;
    //**! Variables to needs into component         ***//
    public $listModule, $listArticles, $listProducts, $listSearch, $itemQuantities;

    public function mount()
    {
        $this->headers_table_sale    = [
            (object)['name' => 'Cantidad',          'class' => '',              'width' => '5%'],
            (object)['name' => 'Artículo',          'class' => '',              'width' => '40%'],
            (object)['name' => 'Precio Unitario',   'class' => 'text-right',    'width' => '10%'],
            (object)['name' => 'Importe total',     'class' => 'text-right',    'width' => '15%'],
        ];

        $this->headers_table_search  = [
            (object)['name' => 'Cantidad',          'class' => '',              'width' => '5%'],
            (object)['name' => 'Artículo',          'class' => '',              'width' => '60%'],
            (object)['name' => 'Precio Unitario',   'class' => 'text-right',    'width' => '25%'],
            (object)['name' => 'Agregar',           'class' => 'text-right',    'width' => '15%'],
        ];

        $this->modal_warnings       = [
            'El código del producto debe contener 8 digitos de entre 0 y 9',
        ];

        $this->listModule       = collect([]); 
        $this->listArticles     = collect([]); 
        $this->listProducts     = Sale::getProducts();
        $this->listSearch       = collect([]);
        $this->itemQuantities   = collect([]);
        $this->amount_total     = 0;
        $this->amount_iva       = 0;
        $this->amount_subtotal  = 0;
        $this->amount_payment   = null;
        $this->amount_change    = 0;
        
    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id      = null;
        $this->listSearch       = collect([]);
        $this->itemQuantities   = collect([]);

        $this->dsSelectSelected('selected_id', null);
    }

    public function getItemById()
    {
        $item = Sale::getProductById($this->selected_id);
        $this->itemQuantities[$item->code] = 1;
        $this->listSearch->push($item);
    }

    public function addCode()
    {
        $product_code = $this->product_code;
        
        if (strlen($product_code) == 8) {
            
            $this->searchProduc($product_code, 1);
            
            $this->product_code = null;   

        } else {
            
            $this->dsToasMessage('warning', 'Advertencia', 'El código debe contener 8 dígitos.');
            
        }

        $this->resetFieldsAndHydrate();
    }

    public function addItem($product_code)
    {
        if ($product_code) {

            $cycles         = $this->itemQuantities[$product_code] ?? false;

            if ($cycles) {
                
                $this->searchProduc($product_code, $cycles);

            } else {

                $this->dsToasMessageWarning('La cantidad debe ser mayor a 0');

            }
        }

        $this->resetFieldsAndHydrate();        
    }

    public function productSelected()
    {
        $this->listSearch   = collect([]);
        $this->getItemById();
    }

    public function searchProduc($product_code, $cycles)
    {
        $product = Sale::getProductByCode($product_code);
        
        if ($product) {

            for ($i = 0; $i < $cycles; $i++) {

                $this->listArticles->push((object)[
                    'id'    => $product->id,
                    'code'  => $product->code,
                    'name'  => $product->name,
                    'price' => $product->price,
                    'total' => $product->price,
                ]); 
                
                $sales       = [];
                $sales_total = 0;

                foreach ($this->listArticles as $key => $article) {

                    $code = $article->code;

                    if (isset($sales[$code])) {

                        $sales[$code]->quantity  += 1;
                        $sales[$code]->total     += $article->price;

                    } else {
                        
                        $sales[$code] = (object)[
                            'quantity' => 1,
                            'id'       => $article->id,
                            'code'     => $article->code,
                            'name'     => $article->name,
                            'price'    => $article->price,
                            'total'    => $article->price,
                        ];

                    }

                    $sales_total += $article->price;

                }

                $this->listModule       = collect($sales);
                $this->amount_total     = $sales_total;
                $this->amount_iva       = $sales_total * 0.16;
                $this->amount_subtotal  = $this->amount_total - $this->amount_iva;

            }
        } else {

            $this->dsToasMessage('info', 'Aviso!', 'Producto no encontrado.');

        }
    }

    public function clearSale()
    {
        $this->listModule       = collect([]); 
        $this->listArticles     = collect([]);
        $this->amount_total     = 0;
        $this->amount_iva       = 0;
        $this->amount_subtotal  = 0;
        $this->amount_payment   = null;
        $this->amount_change    = 0; 
        $this->resetFieldsAndHydrate();
    }

    public function cancelSale() 
    {
        $this->clearSale();
    }

    public function chargeSale()
    {
        $amount_total = $this->amount_total ?? 0;

        if ($amount_total) {

            $this->msOpenModal('modalForm', 'Cobrar venta', null);

        } else {

            $this->dsToasMessage('info', 'Aviso!', 'Aún no ha agregado productos para su cobro.');

        }

    }

    public function processPayment()
    {
        $amount_total   = $this->amount_total ?? 0;    
        $amount_payment = $this->amount_payment ?? 0;

        if ($amount_payment > 0) {

            $amount_change          = $amount_payment - $amount_total;
            $this->amount_change    = $amount_change;

        }
        
    }

    public function declineChange()
    {
        $this->cancelSale();
        $this->msCloseModal();    
    }

    public function confirmCharge()
    {
        $amount_total   = $this->amount_total ?? 0;    
        $amount_payment = $this->amount_payment ?? 0;

        if ($amount_total  <= $amount_payment) {

            $this->saveSale();
            
        } else {
            
            $this->dsToasMessageWarning('El pago es menor al total por cobrar.');

        }   
    }

    public function saveSale()
    {
        $dateTime   = date('YmdHi');
        $randomCode = uniqid('', true);
        $ticketCode = $dateTime . '-' . $randomCode;

        $data = (object) [
            'ticket'            => $ticketCode,
            'amount_total'      => $this->amount_total,
            'amount_payment'    => $this->amount_payment,
            'amount_change'     => $this->amount_change,
            'detail'            => json_encode($this->listModule),
        ]; 
        
        $result = Sale::saveItem($data);
        
        if ($result->type) {

            $this->dsToasMessage('success', 'Exito!', 'venta registrada correctamente.');
            $this->dsShowTicket($result->sale_id);
            
        } else {

            if ($result->find != '') {

                $this->dsToasMessageWarning($result->find);

            } else {

                $this->dsToasMessageError('Ha ocurrido un error.');

            }

        }
        
        $this->clearSale();
        $this->msCloseModal();
    }

    public function render()
    {
        return view('livewire.system.sales');
    }
}
