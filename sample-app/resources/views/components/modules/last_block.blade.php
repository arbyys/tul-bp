<div class="btc-heading">
    <span class="icon btc-icon-logo">
        <i class="mdi mdi-history"></i>
    </span>
    <div class="btc-texts">
        <div class="text-heading">Last block</div>
        <div class="text-subheading">info</div>
    </div>
</div>
<div class="text-content">

    <div class="text-row">
        Block hash:  
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content hash-inside" title="{{ $hash }}">
                {{ $hash }}
            </span>
        </span>
    </div>

    <div class="text-row">
        Block height:  
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $height }}
            </span>
        </span>
    </div>

    <div class="text-row marged-top">
        There are
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $txCount}}
            </span>
        </span>
        confirmed transactions in this block
    </div>

    <div class="text-row">
        Block has been mined at:  
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $time }} 
            </span>
            <span class="value-unit is-padded-left">
                ({{ $date }})
            </span>
        </span>
    </div>
</div>
