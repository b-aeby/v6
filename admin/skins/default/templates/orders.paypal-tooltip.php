{if !empty($SUMMARY.gateway) && stristr($SUMMARY.gateway, 'paypal') && $SUMMARY.gateway!== 'paypal commerce'}   
<style>
.ppcp-container {
    display: flex;
}
.ppcp-container a, .fa-times {
    color: #fff;
}
.pp_cta {
    margin: 25px 0px 10px 25px
}
a.pp_go {
    text-decoration: none !important;
    background: #ffffff;
    color: #003087 !important;
    font-weight: bold;
    padding: 5px 15px;
    border-radius: 50px;
}
a.pp_upgrade_now {
    background: #ffc439!important;
    margin-left: 10px;
}
.flex-child {
    flex: 1;
}  
.ppcp-container .monogram {
    width:55px;
    flex: 0 0 55px;
    background-image: url({$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/images/PP_Monogram.png);
    background-position: center;
    background-repeat: no-repeat;
}
.ppcp-container .message {
        background-color: #003087;
    color: #ffffff;
    padding: 15px;
    font-size: 14px;
}
</style>
<div class="ppcp-container">
    <div class="flex-child monogram"></div>
    <div class="flex-child message">
        <a href="#" onmouseover="$('#pp_expand').slideDown()"><strong>Upgrade Available</strong>: This order was created with an outdated PayPal integration.</a></a>
        <div style="display: none;" id="pp_expand">
            <p>We recommend upgrading to the latest free PayPal Commerce extension.</p>
            <ul>
                <li>Higher conversions with PayPal Express Checkout in context flow.</li>
                <li>Customers can pay directly form the product detail page.</li>
                <li>Take secure card payments with advanced 3D secure compliance.</li>
                <li>Attract more sales with PayPal's <abbr title="Buy Now Pay Later">BNPL</abbr> product, Pay Later.</li>
                <li>Customizable checkout flow with the most relevant payment methods presented to customers (PayPal, Pay Later, Card Brands and Local Payment Methods).</li>
            </ul>
            <div class="pp_cta">
                <a href="#" style="float: right" onclick="$('#pp_expand').slideUp()" title="Close"><i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="https://www.cubecart.com/banner/go/32" class="pp_go" target="_blank">Learn More</a> <a href="?_g=plugins&install[type]=plugins&install[id]=452&install[msg]=Please+connect+your+existing+PayPal+account+to+upgrade+to+PayPal+Commerce." class="pp_go pp_upgrade_now" target="_self">Upgrade Now</a>
            </div>
        </div>
    </div>
</div>
{/if}