<div wire:ignore>
    <h4 class="header-title">{{ $graphName }}</h4>

    <div class="mt-4 chartjs-chart">
        <canvas id="{{ $graphTarget }}" height="350"></canvas>
    </div>
</div>