<?php
$GLOBALS['main']->addTabControl($lang['settings']['release_notes'], 'general');
$GLOBALS['gui']->addBreadcrumb($lang['settings']['release_notes'], 'general', true);

$elastic = <<<END
<strong>Feature Highlight - Elasticsearch</strong>
    <p><img src="./{$GLOBALS['config']->get('config', 'adminFolder')}/skins/{$GLOBALS['config']->get('config', 'admin_skin')}/images/logo.elasticsearch.png" alt="Elasticsearch" /></p>
	<p>Getting your products in front of your customers is critical. Elasticsearch brings lightening fast, search-as-you-type functionality to your store. This is included as standard with official <a href="https://hosted.cubecart.com/" target="_blank">CubeCart Hosting</a>.<br>Alternatively please contact your hosting company to check for availability. To configure and enable Elasticsearch please update your store <a href="?_g=settings#Advanced_Settings">settings</a>.</p>
	<p>For more information talk to us at <a href="mailto:hello@cubecart.com">hello@cubecart.com</a>.</p>
	<h4>Example:</h4>
	<video width="750" loop="true" autoplay="autoplay" controls muted>
		<source src="./{$GLOBALS['config']->get('config', 'adminFolder')}/skins/{$GLOBALS['config']->get('config', 'admin_skin')}/media/movie.elasticsearch.mp4" type="video/mp4">
	</video>
END;

$features = array(
	'2600' => $elastic,
	'3218' => 'Add release notes to CubeCart to help inform merchants about new features to take advantage of',
	'3213' => 'Tumblr & Reddit socials icons added',
	'3105' => 'Debug Output to modal window to prevent page output interruption',
);
$page_content = $GLOBALS['main']->newFeatures($_GET['node'], $features);
?>