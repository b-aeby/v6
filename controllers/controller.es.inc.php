<?php
/**
 * CubeCart v6
 * ========================================
 * CubeCart is a registered trade mark of CubeCart Limited
 * Copyright CubeCart Limited 2023. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:   https://www.cubecart.com
 * Email:  hello@cubecart.com
 * License:  GPL-3.0 https://www.gnu.org/licenses/quick-guide-gplv3.html
 */
$o = array();
if(!empty($_GET['q'])) {
    require_once(CC_ROOT_DIR.'/classes/elasticsearchhandler.class.php');
    $es = new ElasticsearchHandler;
    $es->query(array('keywords' => $_GET['q']));
    $amount = 15;
    if(isset($_GET['a']) && $_GET['a']>0 && $_GET['a']<=50) {
        $amount = (int)$_GET['a'];
    }
    if($result = $es->search(1, $amount)) {
        foreach($result["hits"]["hits"] as $p) {
            $o[] = array(
                'product_id' => $p['_id'],
                'name' => $p["_source"]["name"],
                'thumbnail' => $p["_source"]["thumbnail"]
            );
        }
    }
}
die(json_encode($o));