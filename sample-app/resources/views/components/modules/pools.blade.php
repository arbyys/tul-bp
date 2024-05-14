<div class="btc-heading">
    <div class="info-hoverable-icon has-tooltip-arrow has-tooltip-right has-tooltip-info has-tooltip-multiline" 
        data-tooltip="Number of confirmed blocks for each major mining pool in the last 24 hours. Minor mining pools or individuals are included in the 'Unknown' category."
    >
        <i class="mdi mdi-help-circle"></i>
    </div>
    <span class="icon btc-icon-logo">
        <i class="mdi mdi-lan"></i>
    </span>
    <div class="btc-texts">
        <div class="text-heading">Mining pool</div>
        <div class="text-subheading">distribution</div>
    </div>
</div>
<div class="graph-wrapper animate__animated animate__fadeIn">
    <div id="pools-graph"></div>
</div>

@if($data)
    <script>
        initGraphPools(@json($labels), @json($data));
    </script>
@endif