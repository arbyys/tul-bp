@extends('layouts.main')

@section('title', 'Dashboard - BitcoinSpotlight')

@section('styles')
@endsection

@section('content')
<section class="section main-tiles">
    <div id="main-wrapper" class="tile is-ancestor" _="
        init
            set $appName to 'bitcoin_spotlight'
            if localStorage.app_state is not empty
                get the decrypt(localStorage.app_state, $appName)
                then set $moduleData to it
            else
                set $moduleData to {}
            end
        end
        on saveState
            js
                return encrypt($moduleData, $appName)
            end
            then put it into localStorage.app_state
        end
    ">
        <!-- current price module -->
        <div class="tile is-4 module current-price"
            hx-get="{{ route('modules.bitcoin_price') }}"
            hx-include="find .unpaused"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'price', totalSeconds: 10)"
        >
            <input type="hidden" class="unpaused" name="unpaused" value="false" _="install UnpausedInput">

            <div class="module-content"></div>

            <div class="module-settings">
                <div class="refresh-pause">
                    <button class="trigger-button" _="install TogglePauseButton" title="Toggle data autofetch">
                        <span class="icon-wrapper" _="install PauseIcon">
                            <span class="icon">
                                <i class="mdi mdi-pause"></i>
                            </span>
                        </span>
                    </button>
                </div>
                <div class="refresh-timer">
                    <span class="seconds-text"></span>
                    <svg class="svg-timer" width="40" height="40" _="install SvgTimer">
                        <circle class="stroke-circle" cx="20" cy="20" r="16" stroke="#dbdbdb" stroke-width="3" fill="none" stroke-dasharray="100.53" stroke-dashoffset="0"></circle>
                    </svg>
                </div>
            </div>
            <img id="spinner-current-price" class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>

        <!-- price graph module -->
        <div class="tile is-4 module price-graph"
            hx-get="{{ route('modules.graph') }}"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'graph')"
        >
            <input type="hidden" class="unpaused" name="unpaused" value="false" _="install UnpausedInput">

            <div class="module-content"></div>

            <div class="module-settings">
                <div class="manual-refresh">
                    <button class="trigger-button is-manual" _="install RefreshDataButton" title="Manual data refresh">
                        <span class="icon-wrapper">
                            <span class="icon">
                                <i class="mdi mdi-sync"></i>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
            <img class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>

        <!-- blockchain stats module -->
        <div class="tile is-4 module blockchain-stats"
            hx-get="{{ route('modules.blockchain_stats') }}"
            hx-include="find .unpaused"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'blockchain_stats', totalSeconds: 60)"
        >
            <input type="hidden" class="unpaused" name="unpaused" value="false" _="install UnpausedInput">

            <div class="module-content"></div>

            <div class="module-settings">
                <div class="refresh-pause">
                    <button class="trigger-button" _="install TogglePauseButton" title="Toggle data autofetch">
                        <span class="icon-wrapper" _="install PauseIcon">
                            <span class="icon">
                                <i class="mdi mdi-pause"></i>
                            </span>
                        </span>
                    </button>
                </div>
                <div class="refresh-timer">
                    <span class="seconds-text"></span>
                    <svg class="svg-timer" width="40" height="40" _="install SvgTimer">
                        <circle class="stroke-circle" cx="20" cy="20" r="16" stroke="#dbdbdb" stroke-width="3" fill="none" stroke-dasharray="100.53" stroke-dashoffset="0"></circle>
                    </svg>
                </div>
            </div>
            <img class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>

        <!-- last block module -->
        <div class="tile is-4 module last-block"
            hx-get="{{ route('modules.last_block') }}"
            hx-include="find .unpaused"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'last_block', totalSeconds: 60)"
        >
            <input type="hidden" class="unpaused" name="unpaused" value="false" _="install UnpausedInput">

            <div class="module-content"></div>

            <div class="module-settings">
                <div class="refresh-pause">
                    <button class="trigger-button" _="install TogglePauseButton" title="Toggle data autofetch">
                        <span class="icon-wrapper" _="install PauseIcon">
                            <span class="icon">
                                <i class="mdi mdi-pause"></i>
                            </span>
                        </span>
                    </button>
                </div>
                <div class="refresh-timer">
                    <span class="seconds-text"></span>
                    <svg class="svg-timer" width="40" height="40" _="install SvgTimer">
                        <circle class="stroke-circle" cx="20" cy="20" r="16" stroke="#dbdbdb" stroke-width="3" fill="none" stroke-dasharray="100.53" stroke-dashoffset="0"></circle>
                    </svg>
                </div>
            </div>
            <img class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>

        <!-- pools module -->
        <div class="tile is-4 module pools"
            hx-get="{{ route('modules.pools') }}"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'pools')"
        >
            <div class="module-content"></div>

            <div class="module-settings">
                <div class="manual-refresh">
                    <button class="trigger-button is-manual" _="install RefreshDataButton" title="Manual data refresh">
                        <span class="icon-wrapper">
                            <span class="icon">
                                <i class="mdi mdi-sync"></i>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
            <img class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>

        <!-- long-term stats module -->
        <div class="tile is-4 module long-term"
            hx-get="{{ route('modules.long_term') }}"
            hx-trigger="load, updateData"
            hx-target="find .module-content"
            hx-indicator="find .spinner"
            _="install Module(moduleName: 'long_term')"
        >
            <div class="module-content"></div>

            <div class="module-settings">
                <div class="manual-refresh">
                    <button class="trigger-button is-manual" _="install RefreshDataButton" title="Manual data refresh">
                        <span class="icon-wrapper">
                            <span class="icon">
                                <i class="mdi mdi-sync"></i>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
            <img class="spinner htmx-indicator" src="{{ asset('img/spinner.svg') }}"/>
        </div>
    </div>
</section>

@endsection

@section('scripts_head')
<script type="text/hyperscript">
    --- todo dodělat client side stav aby podle něj nastavil výchozí hodnotu

    behavior Module(moduleName, totalSeconds)
        init
            if $moduleData[moduleName] is empty
                set $moduleData[moduleName] to {totalSeconds: totalSeconds, secondsLeft: totalSeconds, isPaused: false}
            else
                if $moduleData[moduleName].isPaused
                    trigger startAsPaused
                end
            end
        end
        on load[totalSeconds is not empty] repeat forever
            if $moduleData[moduleName].isPaused then wait 1s then continue end
            if $moduleData[moduleName].secondsLeft <= 0
                set $moduleData[moduleName].secondsLeft to $moduleData[moduleName].totalSeconds
                put $moduleData[moduleName].secondsLeft into first .seconds-text in me
                send updateOffset to first .svg-timer in me
                trigger updateData
            else
                decrement $moduleData[moduleName].secondsLeft
                put $moduleData[moduleName].secondsLeft into first .seconds-text in me
                send updateOffset to first .svg-timer in me
            end
            wait 1s
        end
        on toggledFromButton
            set $moduleData[moduleName].isPaused to not $moduleData[moduleName].isPaused
            if $moduleData[moduleName].isPaused
                send isPaused to the first .unpaused in closest .module
            end
            send togglePause to .icon-wrapper in me
        end
        on startAsPaused
            send isPaused to the first .unpaused in closest .module
            send togglePause to .icon-wrapper in me
            put $moduleData[moduleName].secondsLeft into first .seconds-text in me
        end
        on changeSvg
            set offset to ((1 - ($moduleData[moduleName].secondsLeft / $moduleData[moduleName].totalSeconds)) * 100.53)
            get the first .stroke-circle in me then set it's @stroke-dashoffset to offset
            send saveState to closest #main-wrapper
        end
        on htmx:afterRequest
            send isUnpaused to first .unpaused
        end
    end

    behavior UnpausedInput
        on isPaused set @value to 'true' end
        on isUnpaused set @value to 'false' end
    end

    behavior TogglePauseButton
        on click
            send toggledFromButton to closest .module
            send saveState to closest #main-wrapper
        end
    end

    behavior RefreshDataButton
        on click
            send updateData to closest .module
        end
    end

    behavior PauseIcon
        on togglePause
            toggle .mdi-pause on .mdi in me
            toggle .mdi-play on .mdi in me
        end
    end

    behavior SvgTimer
        on updateOffset
            send changeSvg to closest .module
        end
    end

  </script>
@endsection

@section("scripts")
    <script>
        initGraphPrice = function(dataset) {
            var options = {
                tooltip: {
                    x: {
                        format: 'HH:mm:ss',
                    }
                },
                grid: {
                    borderColor: '#737373',
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                },
                theme: {
                    mode: 'dark',
                },
                chart: {
                    height: 200,
                    width: "100%",
                    type: "line",
                    animations: {
                        initialAnimation: {
                            enabled: false
                        }
                    }
                },
                stroke: {
                    width: 3
                },
                series: [
                    {
                        name: "Price ($)",
                        data: dataset
                    }
                ],
                xaxis: {
                    type: 'datetime',
                    labels: {
                        show: true,
                        datetimeUTC: false,
                        style: {
                            colors: ["#ffffff"]
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: true,
                        style: {
                            colors: ["#ffffff"]
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#btc-graph"), options);

            chart.render();
        }

        initGraphPools = function(labels, data) {
            var options = {
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                grid: {
                    borderColor: '#737373',
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                },
                fill: {
                    colors:['#30b504']
                },
                theme: {
                    mode: 'dark',
                },
                chart: {
                    height: 200,
                    width: "100%",
                    type: "bar",
                    animations: {
                        initialAnimation: {
                            enabled: false
                        }
                    }
                },
                series: [{
                    name: "Confirmed blocks: ",
                    data: data
                }],
                xaxis: {
                    categories: labels,
                },
                yaxis: {
                    labels: {
                        show: true,
                        style: {
                            colors: ["#ffffff"]
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#pools-graph"), options);

            chart.render();
        }

        encrypt = function(obj, salt) {
            obj = JSON.stringify(obj);
            const encrypted = CryptoJS.AES.encrypt(obj, salt);
            return encrypted.toString();
        }

        decrypt = function(encrypted, salt) {
            const decrypted = CryptoJS.AES.decrypt(encrypted, salt).toString(CryptoJS.enc.Utf8);
            return JSON.parse(decrypted);
        }
  </script>
@endsection
