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

// add style files
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/include/slick-1.8.1/slick.css');
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/include/slick-1.8.1/slick-theme.css');
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/assets/css/carousel.css');

// add javascript files
$document->addScript('modules/mod_digi_showcase/include/slick-1.8.1/slick.min.js');

// add css style
$document->addStyleDeclaration('
	'.Digi_Showcase_Helper::getFilterCSS($filterArray).'
');
if ($carouselArrowsVal == 'true' && $carouselModeVal == 'false') {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.'.carousel .slick-list {
			margin-left: 25px;
			margin-right: 25px;
		}
	');
}

// add javascript code (slick carousel - http://kenwheeler.github.io/slick/)
$document->addScriptDeclaration('
	'.$jQueryNoConflictDeclaration.'
	'.$jQuery.'(function() {
		'.$jQuery.'(document).ready(function(){
			'.$jQuery.'("#digi_showcase_'. $moduleId .'").children("#digi_showcase_carousel").slick({
				slidesToShow: '. $carouselColumnsQuantity .',
				slidesToScroll: '. $carouselScrollQuantity .',
				autoplay: '. $carouselAutoanimationVal .',
				autoplaySpeed: '. $carouselAutoanimationInterval .',
				dots: '. $carouselDotsVal .',
				arrows: '. $carouselArrowsVal .',
				infinite: '. $carouselLoopVal .',
				centerMode: '. $carouselCenterElementVal .',
				vertical: '. $carouselModeVal .',
				verticalSwiping: '. $carouselModeVal .'
			});
			'.Digi_Showcase_Helper::getFilterJS($filterArray).'
		});
	});
');


// define carousel classes
if ($carouselMode == 0) {
	$carouselModeClass = 'horizontal';
} else {
	$carouselModeClass = 'vertical';
}
if ($carouselCenterElement == 1) {
	$carouselCenterClass = ' center-element';
} else {
	$carouselCenterClass = '';
}

?>

<?php echo Digi_Showcase_Helper::getFilterHTML($filterArray); ?>

<div id="digi_showcase_carousel" class="carousel-container-<?php echo $carouselModeClass; ?>">

<?php if (!empty($items)) {
	
    foreach($items As $item) {
    
		// get item link
		$link = Digi_Showcase_Helper::getLink($linkArray,$item,$dataSource);
	
		// get item image
		$image = Digi_Showcase_Helper::getImage($imageArray,$item);
	
		// add item link to link array
		$linkArray['link'] = $link;
		
		// add item info to data array
		$dataArray['title'] = $item['title'];
		$dataArray['category'] = $item['category'];
		$dataArray['content'] = $item['content'];
		$dataArray['extra-info'] = $item['extra-info'];
		
		// get filter css class
		$filterData = Digi_Showcase_Helper::getFilterClass($filterArray,$item);
    
?>

	<div class="showcase-item slider-item-<?php echo $carouselModeClass.$carouselCenterClass; ?> <?php echo $filterData; ?>" style="<?php echo Digi_Showcase_Helper::getBackground($backgroundArray,$image); ?>">
	
		<?php echo $backgroundOverlay == 1 ? '<div class="overlay">' : '' ; ?>
	
			<div class="item-content<?php echo $image ? '' : ' no-image'; ?>">
			
				<?php echo Digi_Showcase_Helper::getTextHTML(0,$dataArray,$linkArray,$tagsArray); ?>
		
				<?php echo $image ? Digi_Showcase_Helper::getImageHTML($image,$dataArray,$linkArray,$mode) : ''; ?>
		
				<?php echo Digi_Showcase_Helper::getTextHTML(1,$dataArray,$linkArray,$tagsArray); ?>
		
			</div>
	
		<?php echo $backgroundOverlay == 1 ? '</div>' : ''; ?>
	
	</div>
	    
<?php

	} //end foreach
} //end !empty items

?>

</div>