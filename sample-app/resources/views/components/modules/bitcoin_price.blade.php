<div class="btc-heading">
    <img src="{{ asset('img/bitcoin_logo.png') }}" class="btc-logo" alt="Bitcoin logo">
    <div class="btc-texts">
        <div class="text-heading">BTC</div>
        <div class="text-subheading">Bitcoin</div>
    </div>
</div>
<div class="btc-desc">
    Last recorded market price:
</div>
<div class="btc-price">
    <span class="price-unit">$</span>
    <span class="price-text animate__animated animate__bounceIn" id="price-value">{{ $latestPrice }}</span>
    @if(!$unpaused)
        <span class="animate__animated @if(is_null($isHigher)) not-shown @elseif($isHigher) animate__fadeInUp @else animate__fadeInDown @endif animate__faster price-difference"
        _="
            on load
                settle
                wait 3s
                add .animate__fadeOut to me
            end
        ">
            <span class="@if($isHigher) is-higher @else is-lower @endif">
                <i class="mdi @if($isHigher) mdi-menu-up @else mdi-menu-down @endif"></i>
            </span>
        </span>
    @endif
</div>
