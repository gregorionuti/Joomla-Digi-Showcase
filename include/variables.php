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

$document = JFactory::getDocument();
$conf = JFactory::getConfig();

// module
$moduleId = $module->id;
$moduleTitle = $module->title;
$moduleTmplPath = 'modules'.DS.'mod_digi_showcase'.DS.'tmpl'.DS;
$moduleIncludePath = 'modules'.DS.'mod_digi_showcase'.DS.'include'.DS;

// jquery
$jQueryNoConflictSwitch = $params->get('jquery-no-conflict-switch', 0);
if ($jQueryNoConflictSwitch == 1) {
	$jQuery = '$j';
	$jQueryNoConflictDeclaration = 'var $j = jQuery.noConflict();';
} else {
	$jQuery = 'jQuery';
	$jQueryNoConflictDeclaration = '';
}

// bootstrap version
$bootstrapVersion = $params->get('bootstrap-version', 0);
if ($bootstrapVersion == 0) {
	// bootstrap 2
	$rowsClass = 'row-fluid';
	$columnsClass = 'span';
} else if ($bootstrapVersion == 1) {
	// bootstrap 3
	$rowsClass = 'row';
	$columnsClass = 'col-md-';
} else if ($bootstrapVersion == 2) {
	// bootstrap 4
	$rowsClass = 'row';
	$columnsClass = 'col-md-';
} else if ($bootstrapVersion == 3) {
	// bootstrap 5
	$rowsClass = 'row';
	$columnsClass = 'col-md-';
}

// mode
$mode = $params->get('mode', 0);

// data source
$dataSource = $params->get('data-source', 0);
$catId = $params->get('joomla-categories', 1);
$joomlaTags = $params->get('joomla-tags', '');
$joomlaArticles = $params->get('joomla-articles', '');
$customCSV = $params->get('custom-csv', '');
$expansionPack = $params->get('expansion-pack', '');
$expansionPackData = $params->get('expansion-pack-data', '');

// module data
$showFeaturedItems = $params->get('show-featured-items', 1);
$showExpiredItems = $params->get('show-expired-articles', 0);
$itemsTimeCorrection = $params->get('articles-time-correction', 0);
$itemsOffset = $params->get('items-offset', 0);
$titleInside = $params->get('include-title-inside');
$introText = $params->get('intro-text');

// arrangement
$rows = (int)($params->get('rows', 1));
$columns = (int)($params->get('columns', 1));
$columnsSpan = 12 / $columns;
$columnsWidth = round(100 / $columns);

// spacing
$modulePadding = str_replace("px", "", $params->get('module-padding', '0 0 0 0'));
$modulePaddingArray = explode(" ", $modulePadding);
$modulePaddingTop = preg_replace('/[^0-9\-]/', '', $modulePaddingArray[0] ? $modulePaddingArray[0] : 0);
$modulePaddingRight = preg_replace('/[^0-9\-]/', '', $modulePaddingArray[1] ? $modulePaddingArray[1] : 0);
$modulePaddingBottom = preg_replace('/[^0-9\-]/', '', $modulePaddingArray[2] ? $modulePaddingArray[2] : 0);
$modulePaddingLeft = preg_replace('/[^0-9\-]/', '', $modulePaddingArray[3] ? $modulePaddingArray[3] : 0);
$itemsPadding = str_replace("px", "", $params->get('items-padding', '0 10 0 10'));
$itemsPaddingArray = explode(" ", $itemsPadding);
$itemsPaddingTop = preg_replace('/[^0-9\-]/', '', $itemsPaddingArray[0] ? $itemsPaddingArray[0] : 0);
$itemsPaddingRight = preg_replace('/[^0-9\-]/', '', $itemsPaddingArray[1] ? $itemsPaddingArray[1] : 0);
$itemsPaddingBottom = preg_replace('/[^0-9\-]/', '', $itemsPaddingArray[2] ? $itemsPaddingArray[2] : 0);
$itemsPaddingLeft = preg_replace('/[^0-9\-]/', '', $itemsPaddingArray[3] ? $itemsPaddingArray[3] : 0);

// custom style
$moduleCss = ($params->get('module-css'));
$itemsCss = ($params->get('items-css'));

// content
$showTitle = $params->get('show-title', 1);
$titleCharacters = (int)($params->get('title-characters', 50));
$showDescription = $params->get('show-description', 1);
$descriptionCharacters = (int)($params->get('description-characters', 100));
$stripHtmlText = $params->get('strip-html-text', 1);
$showCategory = $params->get('show-category', 0);
$showExtraInfo = $params->get('show-extra-info', 0);

// readmore
$readmore = $params->get('readmore', 0);
$readmoreText = $params->get('readmore-text');
$readmoreStyle = $params->get('readmore-style');
$readmoreClass = $params->get('readmore-class');

// positions
$titlePosition = $params->get('title-position');
$textPosition = $params->get('text-position');
$categoryPosition = $params->get('category-position');
$extraInfoPosition = $params->get('extra-info-position');

// alignments
$titleAlignment = Digi_Showcase_Helper::getTextAlignment($params->get('title-alignment'));
$textAlignment = Digi_Showcase_Helper::getTextAlignment($params->get('text-alignment'));
$categoryAlignment = Digi_Showcase_Helper::getTextAlignment($params->get('category-alignment'));
$extraInfoAlignment = Digi_Showcase_Helper::getTextAlignment($params->get('extra-info-alignment'));

// tags
$moduleTitleTag = $params->get('module-title-tag', 'p');
$titleTag = $params->get('title-tag', 'h3');
$textTag = $params->get('text-tag', 'p');
$categoryTag = $params->get('category-tag', 'h4');
$extraInfoTag = $params->get('extra-info-tag', 'p');
$tagsArray = ['module-title-tag'=>$moduleTitleTag,
			'title-tag'=>$titleTag,
			'desc-tag'=>$textTag,
			'category-tag'=>$categoryTag,
			'extra-info-tag'=>$extraInfoTag];

// link
$itemsLink = $params->get('link-switch');
$linkAlias = $params->get('link-alias');
$linkCategory = $params->get('link-category');
$linkItem = $params->get('link-item');
$forcedLinkItemSwitch = $params->get('forced-link-item-switch');
$forcedLinkItem = $params->get('forced-link-item');
$linkArray = ['link-switch'=>$itemsLink, 
			'link-alias'=>$linkAlias, 
			'link-category'=>$linkCategory, 
			'link-item'=>$linkItem, 
			'forced-link-item-switch'=>$forcedLinkItemSwitch, 
			'forced-link-item'=>$forcedLinkItem, 
			'source'=>$dataSource,
			'plugin'=>$expansionPack];

// image
$showImage = $params->get('show-image', 1);
$imageType = $params->get('image-type', 3);
$showPlaceholder = $params->get('show-placeholder-image', 1);
$placeholderImage = $params->get('placeholder-image');
$generateThumbnail = $params->get('generate-thumbnail', 0);
$imageWidth = $params->get('image-width', 100);
$imageHeight = $params->get('image-height', 100);
$imageArray = ['show'=>$showImage, 
			'type'=>$imageType, 
			'placeholder'=>$showPlaceholder, 
			'placeholder-image'=>$placeholderImage, 
			'thumbnail'=>$generateThumbnail, 
			'width'=>$imageWidth, 
			'height'=>$imageHeight];

// background
$background = $params->get('items-background-switch', 0);
$backgroundType = $params->get('items-background-type', 0);
$backgroundColor = $params->get('items-background-custom-color');
$backgroundImage = $params->get('items-background-image');
$backgroundImageType = $params->get('items-background-image-type', 0);
$backgroundOverlay = $params->get('items-background-overlay', 0);
$backgroundOverlayColor = $params->get('items-background-overlay-color', '#000');
$backgroundOverlayTextColor = $params->get('items-background-overlay-text-color', '#fff');
$backgroundOverlayOpacity = $params->get('items-background-overlay-opacity', 0.7);
$backgroundOverlayContentOpacity = $params->get('items-background-overlay-content-opacity', 0.4);
$backgroundOverlayTransition = $params->get('items-background-overlay-transition', 0.3);
$backgroundArray = ['background'=>$background, 
					'background-type'=>$backgroundType, 
					'background-color'=>$backgroundColor, 
					'background-image'=>$backgroundImage, 
					'background-image-type'=>$backgroundImageType, 
					'background-overlay'=>$backgroundOverlay,
					'background-overlay-color'=>$backgroundOverlayColor,
					'background-overlay-text-color'=>$backgroundOverlayTextColor,
					'background-overlay-opacity'=>$backgroundOverlayOpacity,
					'background-overlay-content-opacity'=>$backgroundOverlayContentOpacity,
					'background-overlay-transition'=>$backgroundOverlayTransition];

// filter
$showFilter = $params->get('filter-switch', 1);
$filterGroup = $params->get('filter-group', 0);
$filterKeyword = 'filter';
$filterAlignment = $params->get('filter-alignment', 1);
$filterMarginWrapper = str_replace("px", "", $params->get('filter-margin-wrapper', '0 0 18 0'));
$filterMarginWrapperArray = explode(" ", $filterMarginWrapper);
$filterMarginWrapperTop = preg_replace('/[^0-9\-]/', '', $filterMarginWrapperArray[0] ? $filterMarginWrapperArray[0] : 0);
$filterMarginWrapperRight = preg_replace('/[^0-9\-]/', '', $filterMarginWrapperArray[1] ? $filterMarginWrapperArray[1] : 0);
$filterMarginWrapperBottom = preg_replace('/[^0-9\-]/', '', $filterMarginWrapperArray[2] ? $itemsPaddingArray[2] : 0);
$filterMarginWrapperLeft = preg_replace('/[^0-9\-]/', '', $filterMarginWrapperArray[3] ? $filterMarginWrapperArray[3] : 0);
$filterMarginItems = str_replace("px", "", $params->get('filter-margin-items', '0 2 0 2'));
$filterMarginItemsArray = explode(" ", $filterMarginItems);
$filterMarginItemsTop = preg_replace('/[^0-9\-]/', '', $filterMarginItemsArray[0] ? $filterMarginItemsArray[0] : 0);
$filterMarginItemsRight = preg_replace('/[^0-9\-]/', '', $filterMarginItemsArray[1] ? $filterMarginItemsArray[1] : 0);
$filterMarginItemsBottom = preg_replace('/[^0-9\-]/', '', $filterMarginItemsArray[2] ? $filterMarginItemsArray[2] : 0);
$filterMarginItemsLeft = preg_replace('/[^0-9\-]/', '', $filterMarginItemsArray[3] ? $filterMarginItemsArray[3] : 0);
$filterJustify = $params->get('filter-justify', 0);				
$filterColor = $params->get('filter-color', '#333333');
$filterHoverColor = $params->get('filter-hover-color', '#ffffff');
$filterBackgroundColor = $params->get('filter-background-color', '#f5f5f5');
$filterBackgroundHoverColor = $params->get('filter-background-hover-color', '#005e8d');
if ($dataSource == 0) {
	// data source is joomla categories
	$dataFilter = $catId;
	$filterKeyword = 'category';
	$dataRaw = '';
	$offset = $itemsOffset;
} else if ($dataSource == 1) {
	// data source is joomla tags
	$dataFilter = $joomlaTags;
	$filterKeyword = 'tag';
	$dataRaw = '';
	$offset = $itemsOffset;
} else if ($dataSource == 2) {
	// data source is joomla articles
	$dataFilter = $joomlaArticles;
	$filterKeyword = 'article';
	$dataRaw = '';
	$offset = $itemsOffset;
} else if ($dataSource == 50) {
	// data source is custom csv
	$dataFilter = Digi_Showcase_Helper::explodeCSV($customCSV);
	$filterKeyword = 'custom';
	$dataRaw = explode(PHP_EOL, $customCSV);
	$offset = $itemsOffset;
} else if ($dataSource == 99) {
	// load expansion pack
	$dataFilter = $expansionPackData;
	$extensionPackParams = Digi_Showcase_Helper::getPluginParamsFromName($expansionPack);
	$filterKeyword = $extensionPackParams->get('filter-keyword', 'custom');
	$dataRaw = '';
	$offset = $itemsOffset;
}
$filterArray = ['filter'=>$showFilter, 
				'source'=>$dataSource, 
				'data'=>$dataFilter, 
				'raw'=>$dataRaw, 
				'offset'=>$offset, 
				'plugin'=>$expansionPack, 
				'module-id'=>$moduleId, 
				'group'=>$filterGroup, 
				'keyword'=>$filterKeyword, 
				'alignment'=>$filterAlignment, 
				'justify'=>$filterJustify, 
				'color'=>$filterColor, 
				'hover-color'=>$filterHoverColor, 
				'background-color'=>$filterBackgroundColor, 
				'background-hover-color'=>$filterBackgroundHoverColor, 
				'mode'=>$mode, 
				'jquery'=>$jQuery];

// order
$orderBy = $params->get('order-by', 1);
if ($orderBy == 0) {
	$orderBy = 'created';
} else if ($orderBy == 1) {
	$orderBy = 'title';
} else if ($orderBy == 2) {
	$orderBy = 'ordering';
} else if ($orderBy == 3) {
	$orderBy = 'rand()';
} else if ($orderBy == 4) {
	$orderBy = 'publish_up';
} else if ($orderBy == 5) {
	$orderBy = 'modified';
} else if ($orderBy == 6) {
	$orderBy = 'hits';
}
$orderType = $params->get('order-type', 'desc');
$orderType = $orderType == 0 ? 'asc' : 'desc';

// carousel
$carouselMode = $params->get('carousel-mode', 0);
$carouselAutoanimation = $params->get('carousel-autoanimation');
$carouselAutoanimationInterval = $params->get('carousel-autoanimation-interval', 5000);
$carouselDisplayQuantity = $params->get('carousel-items-quantity', 6);
$carouselColumnsQuantity = $params->get('carousel-columns-quantity', 3);
$carouselScrollQuantity = $params->get('carousel-scroll-quantity', 1);
$carouselArrows = $params->get('carousel-arrows', 1);
$carouselDots = $params->get('carousel-dots', 0);
$carouselLoop = $params->get('carousel-loop', 1);
$carouselCenterElement = $params->get('carousel-center-element', 0);
$carouselAutoanimationVal = $carouselAutoanimation == 1 ? 'true' : 'false';
$carouselDotsVal = $carouselDots == 1 ? 'true' : 'false';
$carouselArrowsVal = $carouselArrows == 1 ? 'true' : 'false';
$carouselLoopVal = $carouselLoop == 1 ? 'true' : 'false';
$carouselCenterElementVal = $carouselCenterElement == '1' ? 'true' : 'false';
$carouselModeVal = $carouselMode == 1 ? 'true' : 'false';

// timeline
$timelineDisplayQuantity = $params->get('timeline-items-quantity', 6);
$timelineAnimation = $params->get('timeline-animation', 1);
$timelineImageInside = $params->get('timeline-image-inside', 0);
$timelinePrimaryColor = $params->get('timeline-primary-color');
$timelineSecondaryColor = $params->get('timeline-secondary-color');
$timelineBorderRadius = $params->get('timeline-border-radius', 3);
$timelineMaxWidth = $params->get('timeline-max-width', 1200);
$timelineSwitchWidth = $params->get('timeline-switch-width', 768);

// tag cloud
$sphereDisplayQuantity = $params->get('sphere-items-quantity', 12);
$sphereWidth = $params->get('sphere-width', 600);
$sphereHeight = $params->get('sphere-height', 600);
$sphereRadius = $params->get('sphere-radius', 250);

// masonry
$masonryDisplayQuantity = $params->get('masonry-items-quantity', 20);
$masonryColumns = $params->get('masonry-columns', 5);
$masonryMode = $params->get('masonry-mode', 1);
$masonryBlocksSize = $params->get('masonry-blocks-size', 0);
$masonryPattern = $params->get('masonry-pattern', 1);
$masonryBorderRadius = $params->get('masonry-border-radius', 5);
$masonryTabletSwitch = $params->get('masonry-tablet-switch', 960);
$masonrySmartphoneSwitch = $params->get('masonry-smartphone-switch', 640);

// quantity
if ($mode == 0) {
	// normal mode
	$itemsQty = $rows * $columns;
} else if ($mode == 1) {
	// carousel mode
	$itemsQty = $carouselDisplayQuantity;
} else if ($mode == 2) {
	// timeline mode
	$itemsQty = $timelineDisplayQuantity;
} else if ($mode == 3) {
	// tag cloud mode
	$itemsQty = $sphereDisplayQuantity;
} else if ($mode == 4) {
	// masonry mode
	$itemsQty = $masonryDisplayQuantity;
}

// data to be passed to the helper
$dataArray = ['show-title'=>$showTitle,
			'show-desc'=>$showDescription,
			'show-category'=>$showCategory,
			'show-extra-info'=>$showExtraInfo,
			'show-read-more'=>$readmore,
			'read-more-text'=>$readmoreText,
			'read-more-style'=>$readmoreStyle,
			'read-more-class'=>$readmoreClass,
			'title-position'=>$titlePosition,
			'desc-position'=>$textPosition,
			'category-position'=>$categoryPosition,
			'extra-info-position'=>$extraInfoPosition,
			'title-alignment'=>$titleAlignment,
			'desc-alignment'=>$textAlignment,
			'category-alignment'=>$categoryAlignment,
			'extra-info-alignment'=>$extraInfoAlignment,
			'show-module-title-inside'=>$titleInside,
			'module-title'=>$moduleTitle];

// helper
$helper = new Digi_Showcase_Helper($dataSource, $dataFilter, $rows, $columns, 
								   $itemsQty, $mode, $orderBy, $orderType, 
								   $showImage, $generateThumbnail, $imageWidth, $imageHeight, 
								   $showTitle, $titleCharacters, 
								   $showDescription, $descriptionCharacters, $stripHtmlText, 
								   $showExtraInfo, 
								   $showFeaturedItems, $showExpiredItems, $itemsTimeCorrection, $itemsOffset);
if ($dataSource == 0 || $dataSource == 1 || $dataSource == 2) {
	// data source is joomla stuff
	$items = $helper->getJoomlaArticles();
} else if ($dataSource == 50) {
	// data source is custom csv
	$items = $helper->getCustomCSV($customCSV);
} else if ($dataSource == 99) {
	// load expansion pack
	$items = $helper->manageExpansionPack($expansionPack,$expansionPackData);
}

?>