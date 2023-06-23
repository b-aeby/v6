<?php
/**
 * CubeCart v6
 * ========================================
 * CubeCart is a registered trade mark of CubeCart Limited
 * Copyright CubeCart Limited 2017. All rights reserved.
 * UK Private Limited Company No. 5323904
 * ========================================
 * Web:   http://www.cubecart.com
 * Email:  sales@cubecart.com
 * License:  GPL-3.0 https://www.gnu.org/licenses/quick-guide-gplv3.html
 */
if (!defined('CC_INI_SET')) {
    die('Access Denied');
}
Admin::getInstance()->permissions('settings', CC_PERM_READ, true);


$GLOBALS['gui']->addBreadcrumb($lang['navigation']['nav_redirects404s'], currentPage());
$GLOBALS['main']->addTabControl($lang['settings']['redirects'], 'redirects');
$GLOBALS['main']->addTabControl($lang['settings']['missing_uris'], 'missing_uris');

if (Admin::getInstance()->permissions('settings', CC_PERM_EDIT)) {

    if(isset($_POST['path']) && !empty($_POST['path'])) {
        // Check product, category, doc exists
        $exists = false;
        switch($_POST['type']) {
            case 'prod':
                $exists = $GLOBALS['db']->select('CubeCart_inventory', false, array('product_id' => (int)$_POST['item_id']));
            break;
            case 'cat':
                $exists = $GLOBALS['db']->select('CubeCart_category', false, array('cat_id' => (int)$_POST['item_id']));
            break;
            case 'doc':
                $exists = $GLOBALS['db']->select('CubeCart_documents', false, array('doc_id' => (int)$_POST['item_id']));
            break;
            default: // Catch static sections
                $exists = true;
                $_POST['item_id'] = 0;
        }
        if($exists) {
            if($GLOBALS['seo']->setdbPath($_POST['type'], (int)$_POST['item_id'], $_POST['path'], true, false, $_POST['redirect'])) {
                $GLOBALS['main']->successMessage($lang['notification']['notify_success_add_redirect']);
                if($missing = $GLOBALS['db']->select('CubeCart_404_log', false, array('uri' => $_POST['path']))) {
                    $GLOBALS['db']->update('CubeCart_404_log', array('done' => 1, 'warn' => 0), array('id' => $missing[0]['id']));
                }
            } else {
                $GLOBALS['main']->errorMessage($lang['notification']['notify_fail_add_redirect']);
            }
        } else {
            $GLOBALS['main']->errorMessage($lang['notification']['notify_object_not_found']);
        }
        httpredir('?_g=settings&node=redirects');
    }
}

if (isset($_GET['delete']) && ctype_digit($_GET['delete']) && Admin::getInstance()->permissions('settings', CC_PERM_DELETE)) {
    if($GLOBALS['db']->delete('CubeCart_seo_urls', array('id' => $_GET['delete']))) {
        $GLOBALS['main']->successMessage($lang['notification']['notify_seo_url_deleted']);
    } else {
        $GLOBALS['main']->errorMessage($lang['notification']['notify_seo_url_not_deleted']);
    }
    $redirect = currentPage(array('delete'));
    if(isset($_GET['item_id']) && isset($_GET['type'])) {
        switch($_GET['type']) {
            case "prod":
                $redirect = '?_g=products&node=index&action=edit&product_id='.$_GET['item_id'];
            break;
            case "cat":
                $redirect = '?_g=categories&action=edit&cat_id='.$_GET['item_id'];
            break;
            case "doc":
                $redirect = '?_g=documents&action=edit&doc_id='.$_GET['item_id'];
            break;
        }
        httpredir($redirect, 'seo');
    } else {
        httpredir($redirect);
    } 
}

$page  = (isset($_GET['page'])) ? $_GET['page'] : 1;
$per_page = 100;
$redirect_dataset = array();
if($redirects =  $GLOBALS['db']->select('CubeCart_seo_urls', false, "`redirect` IN ('301', '302')", false, $per_page, $page)) {
    $total = $GLOBALS['db']->count('CubeCart_seo_urls', false, "`redirect` IN ('301', '302')");
    $GLOBALS['smarty']->assign('PAGINATION', $GLOBALS['db']->pagination($total, $per_page, $page));
    foreach($redirects as $redirect) {
        $redirect['destination'] = $GLOBALS['seo']->getdbPath($redirect['type'], $redirect['item_id']);
        $redirect_dataset[] = $redirect;
    }
}
$GLOBALS['smarty']->assign('REDIRECTS', $redirect_dataset);

$page  = (isset($_GET['404_page'])) ? $_GET['404_page'] : 1;
$per_page = 100;
$missing_dataset = array();
if($missing =  $GLOBALS['db']->select('CubeCart_404_log', false, false, array('created' => 'DESC'), $per_page, $page)) {
    $total = $GLOBALS['db']->count('CubeCart_404_log', false, false);
    $GLOBALS['smarty']->assign('PAGINATION_404', $GLOBALS['db']->pagination($total, $per_page, $page, 5, '404_page', 'missing_uris'));
    foreach($missing as $m) {
        $m['updated'] = formatTime(strtotime($m['updated']));
        $missing_dataset[] = $m;
    }
}
$GLOBALS['smarty']->assign('MISSING', $missing_dataset);

$page_content = $GLOBALS['smarty']->fetch('templates/settings.redirects.php');