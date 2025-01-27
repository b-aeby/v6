{*
 * CubeCart v6
 * ========================================
 * CubeCart is a registered trade mark of CubeCart Limited
 * Copyright CubeCart Limited 2023. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:   https://www.cubecart.com
 * Email:  hello@cubecart.com
 * License:  GPL-3.0 https://www.gnu.org/licenses/quick-guide-gplv3.html
 *}
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div id="stats_sales" class="tab_content">
   <h3>{$LANG.statistics.title_sales}</h3>
   {if $DISPLAY_SALES}
   <form action="{$VAL_SELF}" class="ignore-dirty" method="get">
      <div>
         <fieldset>
            <legend>{$LANG.common.filter}</legend>
            <select name="year">
            {foreach from=$YEARS item=year}
              <option value="{$year.value}" {$year.selected}>{$year.value}</option>
            {/foreach}
            </select>
            <select name="month">
            {foreach from=$MONTHS item=month}
              <option value="{$month.value}"{$month.selected}>{$month.title}</option>
            {/foreach}
            </select>
            <select name="day">
            {foreach from=$DAYS item=day}
              <option value="{$day.value}"{$day.selected}>{$day.value}</option>
            {/foreach}
            </select>
            <input type="submit" class="tiny" value="{$LANG.common.go}">
         </fieldset>
      </div>
   <input type="hidden" name="_g" value="statistics"> 
   </form>
   <div id="chart1" class="google_chart"></div>
   <div id="chart1-title" style="display:none">{$GRAPH_DATA.1.title}</div>
   <div id="chart1-hAxis" style="display:none">{$GRAPH_DATA.1.hAxis}</div>
   <div id="chart1-vAxis" style="display:none">{$GRAPH_DATA.1.vAxis}</div>
   <div id="chart2" class="google_chart"></div>
   <div id="chart2-title" style="display:none">{$GRAPH_DATA.2.title}</div>
   <div id="chart2-hAxis" style="display:none">{$GRAPH_DATA.2.hAxis}</div>
   <div id="chart2-vAxis" style="display:none">{$GRAPH_DATA.2.vAxis}</div>
   <div id="chart3" class="google_chart"></div>
   <div id="chart3-title" style="display:none">{$GRAPH_DATA.3.title}</div>
   <div id="chart3-hAxis" style="display:none">{$GRAPH_DATA.3.hAxis}</div>
   <div id="chart3-vAxis" style="display:none">{$GRAPH_DATA.3.vAxis}</div>
   <div id="chart4" class="google_chart"></div>
   <div id="chart4-title" style="display:none">{$GRAPH_DATA.4.title}</div>
   <div id="chart4-hAxis" style="display:none">{$GRAPH_DATA.4.hAxis}</div>
   <div id="chart4-vAxis" style="display:none">{$GRAPH_DATA.4.vAxis}</div>
   {else}
   <p>{$LANG.statistics.notify_sales_none}</p>
   {/if}
</div>
<div id="stats_prod_sales" class="tab_content">
   <h3>{$LANG.statistics.title_popular}</h3>
   {if $PRODUCT_SALES}
   <div id="chart5" class="google_chart"></div>
   <div id="chart5-title" style="display:none">{$GRAPH_DATA.5.title}</div>
   <div id="chart5-hAxis" style="display:none">{$GRAPH_DATA.5.hAxis}</div>
   <div id="chart5-vAxis" style="display:none">{$GRAPH_DATA.5.vAxis}</div>
   <div class="pagination">
      {$PAGINATION_SALES}
   </div>
   <table width="100%">
      <thead>
         <tr>
            <td></td>
            <td>{$LANG.catalogue.product_name}</td>
            <td style="text-align: center" nowrap="nowrap"><span title="{$LANG.statistics.quantity_sold}">{$LANG.common.quantity}</span></td>
            <td style="text-align: center" nowrap="nowrap"><span title="{$LANG.statistics.percentage_of_total}">{$LANG.common.percentage}</span></td>
         </tr>
      </thead>
      <tbody>
         {foreach from=$PRODUCT_SALES item=sale}
         <tr>
            <td style="text-align: center">{$sale.key}</td>
            <td><a href="?_g=statistics&amp;node=product&amp;product_id={$sale.product_id}">{$sale.name}</a></td>
            <td style="text-align: center">{$sale.quan}</td>
            <td style="text-align: center">{$sale.percent}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
   {else}
   <p>{$LANG.statistics.notify_sales_none}</p>
   {/if}
</div>
{if isset($PRODUCT_VIEWS)}
<div id="stats_prod_views" class="tab_content">
   <h3>{$LANG.statistics.title_viewed}</h3>
   <div id="chart6" class="google_chart"></div>
   <div id="chart6-title" style="display:none">{$GRAPH_DATA.6.title}</div>
   <div id="chart6-hAxis" style="display:none">{$GRAPH_DATA.6.hAxis}</div>
   <div id="chart6-vAxis" style="display:none">{$GRAPH_DATA.6.vAxis}</div>
   <div class="pagination">{$PAGINATION_VIEWS}</div>
   <table width="100%">
      <thead>
         <tr>
            <td width="20">&nbsp;</td>
            <td>{$LANG.catalogue.product_name}</td>
            <td style="text-align:center">{$LANG.statistics.product_views}</td>
            <td style="text-align:center"><span title="{$LANG.statistics.percentage_of_views}">{$LANG.common.percentage}</span></td>
         </tr>
      </thead>
      <tbody>
         {foreach from=$PRODUCT_VIEWS item=view}
         <tr>
            <td style="text-align:center">{$view.key}</td>
            <td>{$view.name}</td>
            <td style="text-align:center">{$view.popularity}</td>
            <td style="text-align:center">{$view.percent}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
</div>
{/if}
{if isset($SEARCH_TERMS)}
<div id="stats_search" class="tab_content">
   <h3>{$LANG.statistics.title_search}</h3>
   {if $SEARCH_TERMS}
   <div id="chart7" class="google_chart"></div>
   <div id="chart7-title" style="display:none">{$GRAPH_DATA.7.title}</div>
   <div id="chart7-hAxis" style="display:none">{$GRAPH_DATA.7.hAxis}</div>
   <div id="chart7-vAxis" style="display:none">{$GRAPH_DATA.7.vAxis}</div>
   <div class="pagination">{$PAGINATION_SEARCH}</div>
   <table width="100%">
      <thead>
         <tr>
            <td width="20">&nbsp;</td>
            <td>{$LANG.statistics.search_term}</td>
            <td style="text-align:center">{$LANG.statistics.product_hits}</td>
            <td style="text-align:center"><span title="{$LANG.statistics.percentage_of_search}">{$LANG.common.percentage}</span></td>
         </tr>
      </thead>
      <tbody>
         {foreach from=$SEARCH_TERMS item=term}
         <tr>
            <td style="text-align:center">{$term.key}</td>
            <td>{$term.searchstr}</td>
            <td style="text-align:center">{$term.hits}</td>
            <td style="text-align:center">{$term.percent}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
   {else}
   {$LANG.statistics.notify_searches_none}
   {/if}
</div>
{/if}
{if isset($BEST_CUSTOMERS)}
<div id="stats_best_customers" class="tab_content">
   <h3>{$LANG.statistics.title_customers_best}</h3>
   {if $BEST_CUSTOMERS}
   <div id="chart8" class="google_chart"></div>
   <div id="chart8-title" style="display:none">{$GRAPH_DATA.8.title}</div>
   <div id="chart8-hAxis" style="display:none">{$GRAPH_DATA.8.hAxis}</div>
   <div id="chart8-vAxis" style="display:none">{$GRAPH_DATA.8.vAxis}</div>
   <div id="chart8-data" style="display:none">[{$GRAPH_DATA.8.data}]</div>
   <div class="pagination">{$PAGINATION_BEST}</div>
   <table width="100%">
      <thead>
         <tr>
            <td width="20">&nbsp;</td>
            <td>{$LANG.common.name}</td>
            <td style="text-align:center">{$LANG.statistics.total_expenditure}</td>
            <td style="text-align:center">{$LANG.statistics.percentage_of_total}</td>
         </tr>
      </thead>
      <tbody>
         {foreach from=$BEST_CUSTOMERS item=customer}
         <tr>
            <td style="text-align:center">{$customer.key}</td>
            <td><a href="?_g=customers&node=index&action=edit&customer_id={$customer.customer_id}" class="capitalize">{$customer.last_name}, {$customer.first_name}</a></td>
            <td style="text-align:center">{$customer.expenditure}</td>
            <td style="text-align:center">{$customer.percent}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
   {else}
   {$LANG.statistics.notify_customers_none}
   {/if}
</div>
{/if}
{if isset($PLUGIN_TABS)}
   {foreach from=$PLUGIN_TABS item=tab}
      {$tab}
   {/foreach}
{/if}
{if isset($USERS_ONLINE)}
<div id="stats_online" class="tab_content">
   <h3>{$LANG.statistics.title_customers_active}</h3>
   <p>
      {if $BOTS==true}
      <a href="?_g=statistics&bots=false#stats_online">{$LANG.statistics.display_customers_only}</a>
      {else}
      <a href="?_g=statistics&bots=true#stats_online">{$LANG.statistics.display_bots_and_customers}</a>
      {/if}
   </p>
   <table width="100%">
      <thead>
      <tr>
      <td>{$LANG.statistics.session_admin}</td>
            <td>{$LANG.statistics.session_user}</td>
            <td>{$LANG.statistics.session_location}</td>
            <td>{$LANG.statistics.session_started}</td>
            <td>{$LANG.statistics.session_last}</td>
            <td>{$LANG.statistics.session_length}</td>
            <td>{$LANG.common.ip_address}</td>
         </tr>
      </thead>
      <tbody>
         {foreach from=$USERS_ONLINE item=user}
         <tr>
            <td style="text-align:center"><img src="{$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/images/{$user.is_admin}.png"></td>
            <td>
               <strong>
               {if !empty($user.customer_id)}
               <a href="{$CONFIG.adminFile}?_g=customers&action=edit&customer_id={$user.customer_id}">{$user.name}</a>
               {else}
               {$user.name}
               {/if}
               </strong>
            </td>
            <td>{$STORE_URL}/{$user.location}{if strpos($user.location,"404") === false} <a href="{$STORE_URL}/{$user.location}" target="_blank">&raquo;</a>{/if}</td>
            <td style="text-align:center">{$user.session_start}</td>
            <td style="text-align:center"  >{$user.session_last}</td>
            <td>{$user.session_length}</td>
            <td>{if !empty($user.ip_address)}<a href="http://whois.domaintools.com/{$user.ip_address}" target="_blank">{$user.ip_address}</a>{/if}</td>
         </tr>
         {foreachelse}
         <tr>
            <td colspan="6" class="text-center">{$LANG.form.none}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
</div>
{/if}
<script type="text/javascript">
   {literal}
   google.load("visualization", "1", {packages: ["corechart"]});
   
   function drawChart(id, chart_data) {
     var container = document.getElementById('chart'+id);
     
     if(container == null) { 
       return false
     }
     var chart_title = document.getElementById('chart'+id+'-title');
     var chart_hAxis = document.getElementById('chart'+id+'-hAxis');
     var chart_vAxis = document.getElementById('chart'+id+'-vAxis');
   
     var data = google.visualization.arrayToDataTable(chart_data[id]);
     var yMax = 0, gNOR = data.getNumberOfRows(), gNOC = data.getNumberOfColumns();
     for(var x = 1; x < gNOC; x++) {
       for(var y = 0; y < gNOR; y++) {
         yMax = Math.max(data.getValue(y,x), yMax);
       }
     }

     var log10yMax = Math.log10(yMax);
     var floorexp = Math.floor(log10yMax);
     var normyMax = yMax/Math.pow(10,floorexp);
     var ceilnormyMax = Math.ceil(normyMax);
     yMax = ceilnormyMax * Math.pow(10,floorexp);

     if (yMax < 20 || isNaN(yMax)) { yMax = 20; }

     var options = {
       title: chart_title.innerHTML,
       hAxis: {title: chart_hAxis.innerHTML},
       vAxis: {title: chart_vAxis.innerHTML,viewWindowMode:'explicit',viewWindow:{min:0,max:yMax}}
     };
     var chart = new google.visualization.ColumnChart(container);
     chart.draw(data, options);
   }
   
   var chart_data = []
   {/literal}
   {foreach from=$GRAPH_DATA key=k item=v}
   chart_data[{$k}] = [{$v.data}];
   {/foreach}
   {literal}

   const listener = ['resize','load'];
   listener.forEach(addEL);
   function addEL(l) {
      addEventListener(l, (event) => {
         {/literal}
         {foreach from=$GRAPH_DATA key=k item=v}
         drawChart({$k},chart_data);
         {/foreach}
         {literal}
      });
   }

   var ms_delay = 10; // delay before resize so sizes can be calculated
   
   document.getElementById("tab_stats_sales").onclick = function(){
     setTimeout(function() { drawChart(1,chart_data) },ms_delay);
     setTimeout(function() { drawChart(2,chart_data) },ms_delay);
     setTimeout(function() { drawChart(3,chart_data) },ms_delay);
     setTimeout(function() { drawChart(4,chart_data) },ms_delay);
   }
   document.getElementById("tab_stats_prod_sales").onclick = function(){
     setTimeout(function() { drawChart(5,chart_data) },ms_delay)
   }
   document.getElementById("tab_stats_prod_views").onclick = function(){
     setTimeout(function() { drawChart(6,chart_data) },ms_delay)
   }
   document.getElementById("tab_stats_search").onclick = function(){
     setTimeout(function() { drawChart(7,chart_data) },ms_delay)
   }
   document.getElementById("tab_stats_best_customers").onclick = function(){
     setTimeout(function() { drawChart(8,chart_data) },ms_delay)
   }
   {/literal}
   
</script>
