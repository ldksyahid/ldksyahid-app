@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div id="boxes">
    <div style="top: 50%; left: 50%; display: none;" id="dialog" class="window">
        <div id="san">
            <a href="#" class="close agree"><img src="{{ asset('Images/Icons/close-icon.png') }}" width="25" style="float:right; margin-right: -25px; margin-top: -20px;"></a>
            <a href="https://ldksyah.id/ekspresi"rel="noopener noreferrer" class="boom"><img src="{{ asset('Images/Icons/ekspresi-join-logo.png') }}" width="400px"></a>
        </div>
    </div>
    <div style="width: 2478px; font-size: 32pt; height: 1202px; display: none; opacity: 0.4;" id="mask"></div>
</div>
@endif
@if((new \Jenssegers\Agent\Agent())->isMobile())
<div id="boxes">
    <div id="dialog" class="window">
        <div id="san">
            <a href="#" class="close agree"><img src="{{ asset('Images/Icons/close-icon.png') }}" width="20" style="float:right; margin-right: 110px; margin-top: -30px;"></a>
            <a href="https://ldksyah.id/ekspresi"rel="noopener noreferrer" class="boom" target="_blank"><img src="{{ asset('Images/Icons/ekspresi-join-logo.png') }}" width="200px"></a>
        </div>
    </div>
    <div style="width: 2478px; font-size: 32pt; height: 1202px; display: none; opacity: 0.4;" id="mask"></div>
</div>
@endif
