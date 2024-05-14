<div class="btc-heading">
    <span class="icon btc-icon-logo">
        <i class="mdi mdi-calendar-month"></i>
    </span>
    <div class="btc-texts">
        <div class="text-heading">Long term</div>
        <div class="text-subheading">stats</div>
    </div>
</div>
<div class="text-content">
    <div class="text-row">
        In the last 24 hours, 
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $last24hTx }}
            </span>
        </span>
        transactions were sent
    </div>
    <div class="text-row">
        In the last 24 hours,
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $last24hBtcSent }}
            </span>
            <span class="value-unit">
                BTC
            </span>
        </span>
        was sent
    </div>
    <div class="text-row marged-top">
        Totally
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $totalBlocks }}
            </span>
        </span>
        blocks were confirmed
    </div>
    <div class="text-row">
        Mined
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $totalBtc }}
            </span>
            <span class="value-unit">
                BTC
            </span>
        </span>
        out of
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $maximumBtc }}
            </span>
            <span class="value-unit">
                BTC
            </span>
        </span>
    </div>
</div>
