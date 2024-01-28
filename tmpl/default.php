<?php
/**
 * 
 * @version             See field version manifest file
 * @package             See field name manifest file
 * @author				Gregorio Nuti
 * @copyright			See field copyright manifest file
 * @license             GNU General Public License version 2 or later
 * 
 */

// no direct access
defined('_JEXEC') or die;

// define ds variable for joomla 3 compatibility
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// be sure to avoid link error
if (is_null($linkAlias)) { 
    $linkAlias = 1;
}
if (is_null($linkCategory)) { 
    $linkCategory = 1;
}
if (is_null($linkItem)) { 
    $linkItem = 1;
}

// get sef settings from joomla
$sef = $conf->get('sef') ? '1' : '0';
$rewrite = $conf->get('sef_rewrite') ? '1' : '0';
$urlSuffix = $conf->get('sef_suffix') ? '1' : '0';
$unicodeAlias = $conf->get('unicodeslugs') ? '1' : '0';

// add css style
$document = JFactory::getDocument();
if (!empty($moduleCss)) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' {
			'.$moduleCss.'
		}
	');
}
if (!empty($itemsCss)) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item {
			'.$itemsCss.'
		}
	');
}
if ($backgroundOverlay == 1) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .overlay .item-content {
			opacity: '.$backgroundOverlayContentOpacity.';
			transition: opacity '.$backgroundOverlayTransition.'s, color '.$backgroundOverlayTransition.'s;
		}
		#digi_showcase_'.$moduleId.' .overlay:hover .item-content {
			opacity: 1;
		}
	');
}
if ($backgroundOverlay == 1 && $mode != 4) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .overlay {
			background-image: none;
			background-color: rgba('.Digi_Showcase_Helper::hexToRgb($backgroundOverlayColor).$backgroundOverlayOpacity.');
			transition: background-color '.$backgroundOverlayTransition.'s;
		}
		#digi_showcase_'.$moduleId.' .overlay:hover {
			background-color: rgba(0, 0, 0, 0);
		}
		#digi_showcase_'.$moduleId.' .overlay:not(:hover) *:not(.item-content) {
			color: '.$backgroundOverlayTextColor.';
			transition: color '.$backgroundOverlayTransition.'s;
		}
	');
}
if ($background == 1 && $backgroundType == 1) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item {
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		}
	');
}
if ($modulePadding) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' {
			padding-top: '.$modulePaddingTop.'px;
			padding-right: '.$modulePaddingRight.'px;
			padding-bottom: '.$modulePaddingBottom.'px;
			padding-left: '.$modulePaddingLeft.'px;
		}
	');
}
if ($itemsPadding && $backgroundOverlay == 0 && $mode != 2) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item {
			padding-top: '.$itemsPaddingTop.'px;
			padding-right: '.$itemsPaddingRight.'px;
			padding-bottom: '.$itemsPaddingBottom.'px;
			padding-left: '.$itemsPaddingLeft.'px;
		}
	');
} else if ($itemsPadding && $backgroundOverlay == 1 && $mode != 2) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item .overlay {
			padding-top: '.$itemsPaddingTop.'px;
			padding-right: '.$itemsPaddingRight.'px;
			padding-bottom: '.$itemsPaddingBottom.'px;
			padding-left: '.$itemsPaddingLeft.'px;
		}
	');
}
if ($showFilter && $filterMarginWrapper) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' #digi_showcase_filter {
			margin-top: '.$filterMarginWrapperTop.'px;
			margin-right: '.$filterMarginWrapperRight.'px;
			margin-bottom: '.$filterMarginWrapperBottom.'px;
			margin-left: '.$filterMarginWrapperLeft.'px;
		}
	');
}
if ($showFilter && $filterMarginItems) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' #digi_showcase_filter > li {
			margin-top: '.$filterMarginItemsTop.'px;
			margin-right: '.$filterMarginItemsRight.'px;
			margin-bottom: '.$filterMarginItemsBottom.'px;
			margin-left: '.$filterMarginItemsLeft.'px;
		}
	');
}

// define module class
if ($mode == 0) {
	$moduleClass = 'digi_showcase default';
} else if ($mode == 1) {
	$moduleClass = 'digi_showcase carousel';
} else if ($mode == 2) {
	$moduleClass = 'digi_showcase timeline';
} else if ($mode == 3) {
	$moduleClass = 'digi_showcase sphere';
} else if ($mode == 4) {
	$moduleClass = 'digi_showcase masonry';
}

?>

<div id="digi_showcase_<?php echo $moduleId; ?>" class="<?php echo $moduleClass; ?>">

    <?php if (isset($introText)) { ?>
        <p id="digi_showcase_introtext" class="lead"><?php echo $introText; ?></p>
        <hr />
    <?php } ?>
    
	<?php
		if ($mode == 0) {
			require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default') . '_items');
		} else if ($mode == 1) {
			require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default') . '_carousel');
		} else if ($mode == 2) {
			require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default') . '_timeline');
		} else if ($mode == 3) {
			require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default') . '_sphere');
		} else if ($mode == 4) {
			require JModuleHelper::getLayoutPath('mod_digi_showcase', $params->get('layout', 'default') . '_masonry');
		}
	?>
    
</div>