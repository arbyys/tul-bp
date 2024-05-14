<div class="btc-heading">
    <span class="icon btc-icon-logo">
        <i class="mdi mdi-poll"></i>
    </span>
    <div class="btc-texts">
        <div class="text-heading">Blockchain</div>
        <div class="text-subheading">stats</div>
    </div>
</div>
<div class="text-content">
    <div class="text-row">
        Network hashrate: 
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $hashrate }}
            </span>
            <span class="value-unit">
                TH/s
            </span>
        </span>
    </div>
    <div class="text-row">
        Average
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $avgInterval }}
            </span>
            <span class="value-unit">
                sec
            </span>
        </span>
        between blocks
    </div>
    <div class="text-row">
        Probability to find block: 
        <span class="highlighted-value long-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $blockFindProb }}
            </span>
            <span class="value-unit">
                %
            </span>
        </span>
    </div>
    <div class="text-row padded-1">
        = average 
        <span class="highlighted-value long-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $avgHashes }}
            </span>
        </span>
        hashes until a block is found
    </div>
    <div class="text-row">
        Currently 
        <span class="highlighted-value animate__animated animate__fadeIn animate__faster">
            <span class="value-content">
                {{ $unconfirmedTx }}
            </span>
        </span>
        unconfirmed transactions
    </div>
</div>
