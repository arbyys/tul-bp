<div class="btc-heading">
    <div class="info-hoverable-icon has-tooltip-arrow has-tooltip-right has-tooltip-info has-tooltip-multiline" 
        data-tooltip="Graph of BTC/USD price during last 30 minutes."
    >
        <i class="mdi mdi-help-circle"></i>
    </div>
    <span class="icon btc-icon-logo">
        <i class="mdi mdi-chart-line"></i>
    </span>
    <div class="btc-texts">
        <div class="text-heading">Price graph</div>
        <div class="text-subheading">in the last 30 minutes</div>
    </div>
</div>
<div class="graph-wrapper animate__animated animate__fadeIn">
    <div id="btc-graph"></div>
</div>

@if($data)
    <script>
        initGraphPrice(@json($data));
    </script>
@endif