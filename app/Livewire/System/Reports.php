<?php

namespace App\Livewire\System;

use App\Livewire\Traits\DispatchServices;
use App\Models\System\Report;
use Livewire\WithPagination;
use Livewire\Component;
use Carbon\Carbon;

class Reports extends Component
{
    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    public $take                = 3;
    //*** Default variables to needs into component ***//
    public $action_loader, $headers_table_search, $modal_title, $modal_warnings, $modal_target, $selected_id;
    //*** Default variables to needs into component ***//
    public $date_start, $date_end, $chart_bar;
    //**! Variables to needs into component         ***//
    public $listSearch;

    public function mount()
    {
        $this->action_loader    = "paginate_number, order_by";

        $this->headers_table_search    = [
            (object)['name' => 'Cantidad',          'class' => 'text-center',  'width' => '5%'],
            (object)['name' => 'Código',            'class' => 'text-center',  'width' => '25%'],
            (object)['name' => 'Articulo',          'class' => '',  'width' => '40%'],
            (object)['name' => 'Precio unitario',   'class' => 'text-right',  'width' => '15%'],
            (object)['name' => 'Monto venta',       'class' => 'text-right',  'width' => '15%'],
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ];

        $this->date_start   = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_end     = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->listSearch   = collect([]);
        $this->chart_bar    = (object)['graph_target' => "grap-products-sales", 'graph_name' => "Gráfica de ventas por producto"]; 
    }

    public function dateRange()
    {
        $date_start     = $this->date_start;
        $date_end       = $this->date_end;
        
        if ($date_start && $date_end) {
            
            $validate_date_start    = Carbon::createFromDate($date_start)->format('Y-m-d 00:00:00');
            $validate_date_end      = Carbon::createFromDate($date_end)->format('Y-m-d 23:59:59');
            $date_start_obj         = Carbon::parse($validate_date_start);
            $date_end_obj           = Carbon::parse($validate_date_end);

            if (!$date_end_obj->lt($date_start_obj)) {
                
                $items  = Report::getSaleProductsByDateRange($validate_date_start, $validate_date_end);
                $this->listSearch = collect($items);
               
            } else {

                $this->dsToasMessage('error', 'Error!', 'Las fechas no corresponden a un rango válido.');
                $this->date_start   = null;
                $this->date_end     = null;
                $this->listSearch   = collect([]);
                
            }

        }        

    }

    public function makeGraphs($listCharts)
    {
        $graphName      = "Ventas";
        $labelNames     = [];
        $dataQuantities = [];

        foreach ($listCharts as $cha => $chart) {
            
            array_push($labelNames, $chart->name);
            array_push($dataQuantities, $chart->quantity);

        }
        
        $content = (object)[
            'graphName'         => $graphName,
            'labelNames'        => $labelNames,
            'dataQuantities'    => $dataQuantities,
        ];
        
        $this->dsGraphBarChart($this->chart_bar->graph_target, $content);        
    }

    public function render()
    {
        $take           = intval($this->take);
        $listProducts   = Report::getSaleProducts($take);
        $listCharts     = Report::getSaleProducts(null);
        $this->dateRange();
        $this->makeGraphs($listCharts);

        return view('livewire.system.reports', [
            'listProducts' => $listProducts,
        ]);
    }
}
