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
$GLOBALS['main']->addTabControl($lang['settings']['release_notes'], 'general');
$GLOBALS['gui']->addBreadcrumb($lang['settings']['release_notes'], currentPage(array('node')), true);

$features = array(
    '3304' => 'Back-office 404 log. Discover external URL\'s that have no destination and use the existing redirect tool to fix them.',
	'3131' => 'Back-office category list now shows product count.',
	'3229' => 'Escape key now closes back-office search pull out.',
	'3243' => 'Memory added to back-office list size (Products, Orders, Customers).',
	'3275' => 'Administrator log to show more detailed info. e.g. The item that was edited.',
	'3299' => 'Improved back-office request log layout with header logging.',
    '3331' => '&quot;Save &amp; Reload&quot; button added to category edit add/page.',
    '3332' => 'Google Universal Analytics removed in favour of new <a href="https://www.cubecart.com/extensions/plugins/google-analytics-for-ecommerce" target="_blank">extension</a>.',
    '3346' => 'Back-office customer list to show their chosen language.',
    '3347' => '<a href="https://www.hcaptcha.com" target="_blank">hCaptcha</a> officially supported as an alternative to Google reCAPTCHA. This requires skin updates.',
    '3348' => 'Back-office now logs actions of cleaning subscriber log.'
);
$notes = '';
$page_content = $GLOBALS['main']->newFeatures($_GET['node'], $features, 112, $notes);
?>