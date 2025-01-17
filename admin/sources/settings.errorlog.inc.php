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
if (!defined('CC_INI_SET')) {
    die('Access Denied');
}
Admin::getInstance()->permissions('settings', CC_PERM_READ, true);

if (isset($_POST['adminread'])) {
    $changed = false;
    foreach ($_POST['adminread'] as $log_id) {
        $result = $GLOBALS['db']->update('CubeCart_admin_error_log', array('read' => $_POST['admin_error_status']), array('log_id' => $log_id));
        if (!$changed && $result) {
            $changed = true;
        }
    }
    if ($changed) {
        $GLOBALS['main']->successMessage($_POST['admin_error_status'] ? $lang['settings']['message_marked_read'] : $lang['settings']['message_marked_unread']);
    } else {
        $GLOBALS['main']->errorMessage($lang['settings']['changes_not_made']);
    }
}

if (isset($_POST['systemread'])) {
    $changed = false;
    foreach ($_POST['systemread'] as $log_id) {
        $result = $GLOBALS['db']->update('CubeCart_system_error_log', array('read' => $_POST['system_error_status']), array('log_id' => $log_id));
        if (!$changed && $result) {
            $changed = true;
        }
    }
    if ($changed) {
        $GLOBALS['main']->successMessage($_POST['system_error_status'] ? $lang['settings']['message_marked_read'] : $lang['settings']['message_marked_unread']);
    } else {
        $GLOBALS['main']->errorMessage($lang['settings']['changes_not_made']);
    }
}

$count_unread = $GLOBALS['db']->count('CubeCart_admin_error_log', 'log_id', array('read' => '0'));
$GLOBALS['main']->addTabControl($lang['settings']['title_admin_error_log'], 'admin_error_log', null, null, $count_unread);
$GLOBALS['gui']->addBreadcrumb($lang['settings']['title_admin_error_log'], currentPage());

$per_page = 25;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$error_log = $GLOBALS['db']->select('CubeCart_admin_error_log', array('message', 'time', 'log_id', 'read'), array('admin_id'=>Admin::getInstance()->get('admin_id')), array('time' => 'DESC'), $per_page, $page, false);
$count = 0;
$admin_error_log = false;
if ($error_log && is_array($error_log)) {
    $count = $GLOBALS['db']->getFoundRows();
    foreach ($error_log as $log) {
        $smarty_data['error_log'][] = array(
            'time'   => formatTime($log['time']),
            'message'  => $log['message'],
            'read'   => $log['read'],
            'log_id' => $log['log_id'],
            'style'  => $log['read'] ? '' : 'style="font-weight: bold"'
        );
    }
    $admin_error_log = $smarty_data['error_log'];
}
if($admin_error_log) {
    $GLOBALS['smarty']->assign('ADMIN_ERROR_LOG', $admin_error_log);
}
$GLOBALS['smarty']->assign('PAGINATION_ADMIN_ERROR_LOG', $GLOBALS['db']->pagination($count, $per_page, $page, 5, 'page', 'admin_error_log'));

if (Admin::getInstance()->superUser()) {
    $count_unread = $GLOBALS['db']->count('CubeCart_system_error_log', 'log_id', array('read' => '0'));
    $GLOBALS['main']->addTabControl($lang['settings']['title_system_error_log'], 'system_error_log', null, null, $count_unread);
    //System errors
    $per_page = 25;
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $system_error_log = $GLOBALS['db']->select('CubeCart_system_error_log', false, false, array('time' => 'DESC'), $per_page, $page, false);
    $count = $GLOBALS['db']->getFoundRows();
    if (is_array($system_error_log)) {
        foreach ($system_error_log as $log) {
            $smarty_data['system_error_log'][] = array(
                'time'   => formatTime($log['time']),
                'message'  => $log['message'],
                'url'  => $log['url'],
                'backtrace'  => nl2br($log['backtrace']),
                'read'   => $log['read'],
                'log_id' => $log['log_id'],
                'style'  => ($log['read'] == '1') ? '' : 'style="font-weight: bold"'
            );
        }
        $GLOBALS['smarty']->assign('SYSTEM_ERROR_LOG', $smarty_data['system_error_log']);
    }

    $GLOBALS['smarty']->assign('PAGINATION_SYSTEM_ERROR_LOG', $GLOBALS['db']->pagination($count, $per_page, $page, 5, 'page', 'system_error_log'));
}
$page_content = $GLOBALS['smarty']->fetch('templates/settings.errorlog.php');
