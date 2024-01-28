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
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/assets/css/sphere.css');

// add javascript files
$document->addScript('modules/mod_digi_showcase/assets/js/tagcloud.jquery.min.js');

// add css style
$document->addStyleDeclaration('
	'.Digi_Showcase_Helper::getFilterCSS($filterArray).'
');

// add javascript code (Nurul Ferdous - http://dynamicguy.com/)
$document->addScriptDeclaration('
	'.$jQueryNoConflictDeclaration.'
	if ('.$jQuery.'(window).width() <= '.$sphereWidth.'){
		var settings = {
		height: ('.$jQuery.'(window).width() * 0.8),
		width: ('.$jQuery.'(window).width() * 0.8),
		radius: '.$sphereRadius / 2 .',
		speed: 1,
		slower: 0.5,
		timer: 10,
		fontMultiplier: 25,
		hoverStyle: {
			border: "none"
		},
		mouseOutStyle: {
			border: "none"
		}
		};
	} else {
		var settings = {
		height: '.$sphereHeight.',
		width: '.$sphereWidth.',
		radius: '.$sphereRadius.',
		speed: 1,
		slower: 0.5,
		timer: 10,
		fontMultiplier: 25,
		hoverStyle: {
			border: "none"
		},
		mouseOutStyle: {
			border: "none"
		}
		};
	}
	'.$jQuery.'(document).ready(function(){
		'.$jQuery.'("#digi_showcase_sphere").tagoSphere(settings);
		'.Digi_Showcase_Helper::getFilterJS($filterArray).'
	});
');

?>

<?php echo Digi_Showcase_Helper::getFilterHTML($filterArray); ?>

<div id="digi_showcase_sphere">

<ul>

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

<div class="showcase-item sphere-item <?php echo $filterData; ?>" style="<?php echo Digi_Showcase_Helper::getBackground($backgroundArray,$image); ?>">
	
    <?php echo $backgroundOverlay == 1 ? '<div class="overlay">' : '' ; ?>
    	
    	<div class="sphere-content">
			
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

</ul>

</div>