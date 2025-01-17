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
Admin::getInstance()->permissions('reviews', CC_PERM_READ, true);


## Delete review
if (isset($_GET['delete']) && is_numeric($_GET['delete']) && Admin::getInstance()->permissions('reviews', CC_PERM_DELETE)) {
    if ($GLOBALS['db']->delete('CubeCart_reviews', array('id' => (int)$_GET['delete']))) {
        $GLOBALS['main']->successMessage($lang['reviews']['notify_review_delete']);
    } else {
        $GLOBALS['main']->errorMessage($lang['reviews']['error_review_delete']);
    }
    httpredir(currentPage(array('delete')));
}

## Bulk delete reviews
if (!empty($_POST['delete']['email'])) {
    if ($GLOBALS['db']->delete('CubeCart_reviews', array('email' => $_POST['delete']['email']))) {
        $GLOBALS['main']->successMessage($lang['reviews']['notify_review_deleted']);
    }
}
if (isset($_POST['multi-status']) && isset($_POST['go'])) {
    switch ($_POST['multi-status']) {
        case 'delete':
            if (!empty($_POST['delete']['individual'])) {
                if ($GLOBALS['db']->delete('CubeCart_reviews', array('id' => array_keys($_POST['delete']['individual'])))) {
                    $GLOBALS['main']->successMessage($lang['reviews']['notify_review_deleted']);
                }
            }
        break;
    }
}
if (!empty($_POST['delete']['ip_address'])) {
    if ($GLOBALS['db']->delete('CubeCart_reviews', array('ip_address' => $_POST['delete']['ip_address']))) {
        $GLOBALS['main']->successMessage($lang['reviews']['notify_review_deleted']);
    }
}

## Update Review
if (isset($_POST['review']) && is_array($_POST['review']) && Admin::getInstance()->permissions('reviews', CC_PERM_EDIT)) {
    $record = array(
        'approved' => $_POST['review']['approved'],
        'anon' => $_POST['review']['anon'],
        'name'  => $_POST['review']['name'],
        'email'  => $_POST['review']['email'],
        'title'  => $_POST['review']['title'],
        'review' => $_POST['review']['review'],
        'rating' => (isset($_POST['rating']) && is_numeric($_POST['rating'])) ? (int)$_POST['rating'] : 0,
    );

    foreach ($GLOBALS['hooks']->load('admin.products.reviews.update') as $hook) {
        include $hook;
    }

    if (is_numeric($_POST['review']['id'])) {
        $updated = $GLOBALS['db']->update('CubeCart_reviews', $record, array('id' => (int)$_POST['review']['id']));
        if ((bool)$GLOBALS['db']->affected()) {
            $GLOBALS['main']->successMessage($lang['reviews']['notify_review_update']);
            $rem_array = array('edit');
        } else {
            $GLOBALS['main']->errorMessage($lang['reviews']['error_review_update']);
            $rem_array = false;
        }
    } else {
        $record['ip_address'] = get_ip_address();
        $record['customer_id'] = 0;
        $record['product_id'] = $_POST['review']['product_id'];
        
        if (!empty($_POST['review']['product_id']) && is_numeric($_POST['review']['product_id'])) {
            if ($GLOBALS['db']->insert('CubeCart_reviews', $record)) {
                $GLOBALS['main']->successMessage($lang['reviews']['notify_review_added']);
                $rem_array = array('edit');
            } else {
                $GLOBALS['main']->errorMessage($lang['reviews']['error_review_added']);
                $rem_array = false;
            }
        } else {
            $no_redirect = true;
            $GLOBALS['smarty']->assign('REVIEW', $record);
            $GLOBALS['main']->errorMessage($lang['reviews']['error_no_product_selected']);
        }
    }
    if (!isset($no_redirect)) {
        httpredir(currentPage($rem_array));
    }
}

## Approve reviews
if (isset($_POST['approve']) && is_array($_POST['approve']) && Admin::getInstance()->permissions('reviews', CC_PERM_EDIT)) {
    $updated = false;
    $before = md5(serialize($GLOBALS['db']->select('CubeCart_reviews', 'approved')));
    foreach ($_POST['approve'] as $review_id => $status) {
        $GLOBALS['db']->update('CubeCart_reviews', array('approved' => (int)$status), array('id' => (int)$review_id));
    }
    $after = md5(serialize($GLOBALS['db']->select('CubeCart_reviews', 'approved')));
    if ($before !== $after) {
        $GLOBALS['main']->successMessage($lang['reviews']['notify_review_status']);
    }
    ## origin variable tells us we need to come back to the dashboard now
    if (isset($_GET['origin']) && !empty($_GET['origin']) && $_GET['origin']=="dashboard") {
        httpredir('?', 'product_reviews');
    }
}

## Filter Reviews
if (isset($_POST['filter']) && !empty($_POST['filter'])) {
    ## These fields are present regardless
    $append  = array('field' => $_POST['field'], 'sort' => $_POST['sort']);
    $anchor  = 'reviews';
    $rem_array  = null;
    ## Fields for approved / not approved filter
    if (isset($_POST['filter']['approved']) && is_numeric($_POST['filter']['approved'])) {
        if ($_POST['filter']['approved']) {
            $review_types = $lang['reviews']['filter_approved'];
        } else {
            $review_types = $lang['reviews']['filter_unapproved'];
        }
        $GLOBALS['main']->successMessage($review_types);
        $append['approved'] = $_POST['filter']['approved'];
    } else {
        $rem_array  = array('approved');
    }
    ## Field for product ID
    if (!empty($_POST['filter']['product_id']) && is_numeric($_POST['filter']['product_id'])) {
        $append['product_id'] = $_POST['filter']['product_id'];
        $anchor = 'reviews';
    } elseif (isset($_POST['filter']['product_string']) && !empty($_POST['filter']['product_string'])) {
        $GLOBALS['main']->errorMessage($lang['catalogue']['error_search_no_results']);
        $anchor = 'search';
    }
    ## If not empty keywords append that too
    if (!empty($_POST['filter']['keywords'])) {
        $append['keywords'] = $_POST['filter']['keywords'];
    }

    ## filter is always set on any submit so we can redirect here for all
    httpredir(currentPage($rem_array, $append, $anchor), 'reviews');
}
$GLOBALS['gui']->addBreadcrumb($lang['reviews']['title_reviews'], currentPage(array('edit', 'field', 'sort', 'product_id', 'approved')));

if (isset($_GET['edit']) && is_numeric($_GET['edit']) && Admin::getInstance()->permissions('reviews', CC_PERM_EDIT)) {
    
    // Edit review
    if ($_GET['edit']==0) {
        $GLOBALS['main']->addTabControl($lang['catalogue']['add_review'], 'review');
        $GLOBALS['smarty']->assign('FORM_MODE', 'add');
        $GLOBALS['smarty']->assign('DISPLAY_FORM', true);
    } elseif (($reviews = $GLOBALS['db']->select('CubeCart_reviews', false, array('id' => (int)$_GET['edit']))) !== false) {
        $GLOBALS['main']->addTabControl($lang['reviews']['title_review_edit'], 'review');
        $GLOBALS['smarty']->assign('FORM_MODE', 'edit');
        $review = $reviews[0];
        $GLOBALS['gui']->addBreadcrumb($review['title'], currentPage());
        for ($i=1; $i<=5; $i++) {
            $GLOBALS['smarty']->assign('STAR', array('value' => $i, 'checked' => ($i == $review['rating']) ? ' checked="checked"' : ''));
        }
        $GLOBALS['smarty']->assign('REVIEW', $review);
        $GLOBALS['smarty']->assign('DISPLAY_FORM', true);
    } else {
        httpredir(currentPage(array('edit')));
    }
} else {
    $GLOBALS['main']->addTabControl($lang['reviews']['title_reviews'], 'reviews');
    $GLOBALS['main']->addTabControl($lang['catalogue']['add_review'], '', '?_g=products&node=reviews&edit=0');
    $GLOBALS['main']->addTabControl($lang['reviews']['title_bulk_delete'], 'bulk_delete');
    $GLOBALS['main']->addTabControl($lang['common']['search'], 'search');

    $page  = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $per_page = 10;

    $where = false;

    if (isset($_GET['product_id'])) {
        $where['product_id'] = (int)$_GET['product_id'];
    }
    if (isset($_GET['approved']) && is_numeric($_GET['approved'])) {
        $filter['approved'] = (int)$_GET['approved'];
        $where['approved']  = (int)$_GET['approved'];
    } else {
        $filter['approved'] = '';
    }
    if (isset($_GET['sort'], $_GET['field'])) {
        $filter['field'] = $_GET['field'];
        $filter['sort']  = $_GET['sort'];
    } else {
        $filter['field'] = 'time';
        $filter['sort']  = 'DESC';
    }

    if (!empty($_GET['keywords'])) {
        $where = array(
            'review'  => '~'.$_GET['keywords'],
            /* Where LIKE defaults to AND causing problems
            'name' 		=> '~'.$_GET['keywords'],
            'email'	 	=> '~'.$_GET['keywords'],
            'title' 	=> '~'.$_GET['keywords']
            */
        );
    }
    $reviews = $GLOBALS['db']->select('CubeCart_reviews', false, $where, array($filter['field'] => $filter['sort']), $per_page, $page);

    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
        $product = $GLOBALS['db']->select('CubeCart_inventory', array('name'), array('product_id' => (int)$_GET['product_id']));
    }

    if (!$reviews && isset($product) && $product) {
        $GLOBALS['main']->errorMessage($lang['reviews']['error_reviews_none']);
        httpredir(currentPage(array('product_id')), 'search');
    }

    if ($reviews) {
        $GLOBALS['smarty']->assign('PAGINATION', $GLOBALS['db']->pagination(false, $per_page, $page, 9));
        foreach ($reviews as $review) {
            if (($product = $GLOBALS['db']->select('CubeCart_inventory', array('name'), array('product_id' => $review['product_id']))) !== false) {
                $review['product'] = $product[0];
                $review['date']  = formatTime($review['time']);
                $review['delete'] = currentPage(null, array('delete' => (int)$review['id'], 'token' => SESSION_TOKEN));
                $review['edit']  = currentPage(null, array('edit' => (int)$review['id']));
                $smarty_data['reviews'][] = $review;
            } else {
                $GLOBALS['db']->delete('CubeCart_reviews', array('product_id' => $review['product_id']));
            }
        }
        if (isset($smarty_data['reviews'])) {
            $GLOBALS['smarty']->assign('REVIEWS', $smarty_data['reviews']);
        }
    }
    $fields = array(
        /* We can't do this as it's not possible to have joins on the select function.. booooooooooo!!!
        array ('value' => 'product', 'name' => 'Product Name'),
        */
        array('value' => 'rating', 'name' => $lang['documents']['rating']),
        array('value' => 'time', 'name' => $lang['common']['date']),
    );
    $sorts = array(
        array('value' => 'DESC', 'name' => $lang['category']['sort_high_low']),
        array('value' => 'ASC', 'name' => $lang['category']['sort_low_high'])
    );
    $statuses = array(
        array('value' => '', 'name' => $lang['common']['all']),
        array('value' => '1', 'name' => $lang['common']['approved']),
        array('value' => '0', 'name' => $lang['common']['unapproved'])
    );

    foreach ($fields as $field) {
        $field['selected'] = ($field['value'] == $filter['field']) ? 'selected="selected"' : '';
        $smarty_data['fields'][] = $field;
    }
    $GLOBALS['smarty']->assign('FIELDS', $smarty_data['fields']);
    foreach ($sorts as $sort) {
        $sort['selected'] = ($sort['value'] == $filter['sort']) ? 'selected="selected"' : '';
        $smarty_data['sorts'][] = $sort;
    }
    $GLOBALS['smarty']->assign('SORTS', $smarty_data['sorts']);
    foreach ($statuses as $status) {
        $status['selected'] = ($status['value'] == $filter['approved'] && is_numeric($filter['approved'])) ? 'selected="selected"' : '';
        $smarty_data['statuses'][] = $status;
    }
    $GLOBALS['smarty']->assign('STATUSES', $smarty_data['statuses']);
    $GLOBALS['smarty']->assign('LIST_REVIEWS', true);
}

$page_content = $GLOBALS['smarty']->fetch('templates/products.reviews.php');
