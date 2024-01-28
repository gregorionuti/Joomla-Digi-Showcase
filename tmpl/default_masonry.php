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
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/assets/css/masonry.css');

// add css style
$document->addStyleDeclaration('
	#digi_showcase_'.$moduleId.'.masonry .showcase-item .item-content {
		border-radius: '.$masonryBorderRadius.'px;
	}
	@media screen and (min-width: '.($masonrySmartphoneSwitch + 1).'px) and (max-width: '.$masonryTabletSwitch.'px) {
		#digi_showcase_'.$moduleId.'.masonry .masonry-block {
			width: 50% !important;
		}
	}
	@media screen and (max-width: '.$masonrySmartphoneSwitch.'px) {
		#digi_showcase_'.$moduleId.'.masonry .masonry-block {
			width: 100% !important;
		}
	}
	
	'.Digi_Showcase_Helper::getFilterCSS($filterArray).'
');
if ($backgroundOverlay == 1) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .overlay {
			border-radius: '.$masonryBorderRadius.'px;
			background-image: none;
			background-color: rgba(0, 0, 0, 0);
			transition: background-color '.$backgroundOverlayTransition.'s;
		}
		#digi_showcase_'.$moduleId.' .overlay:hover {
			background-color: rgba('.Digi_Showcase_Helper::hexToRgb($backgroundOverlayColor).$backgroundOverlayOpacity.');
		}
		#digi_showcase_'.$moduleId.' .overlay .item-content {
			opacity: '.$backgroundOverlayContentOpacity.';
			transition: opacity '.$backgroundOverlayTransition.'s, color '.$backgroundOverlayTransition.'s;
		}
		#digi_showcase_'.$moduleId.' .overlay:hover *:not(.item-content) {
			color: '.$backgroundOverlayTextColor.';
		}
		#digi_showcase_'.$moduleId.' .overlay:not(:hover) *:not(.item-content) {
			transition: color '.$backgroundOverlayTransition.'s;
		}
	');
}
if ($itemsPadding && $backgroundOverlay == 1) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item {
			padding-top: '.$itemsPaddingTop.'px;
			padding-right: '.$itemsPaddingRight.'px;
			padding-bottom: '.$itemsPaddingBottom.'px;
			padding-left: '.$itemsPaddingLeft.'px;
		}
	');
} else if ($itemsPadding) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .showcase-item .item-content > div:first-child {
			padding-top: '.$itemsPaddingTop.'px;
			padding-right: '.$itemsPaddingRight.'px;
			padding-bottom: '.$itemsPaddingBottom.'px;
			padding-left: '.$itemsPaddingLeft.'px;
		}
	');
}

// add javascript code
$document->addScriptDeclaration('
	'.$jQueryNoConflictDeclaration.'
	'.$jQuery.'(document).ready(function(){
			
			// variables
			var mode = '.$masonryMode.';
			var blockSize = '.$masonryBlocksSize.';
			var pattern = ['.$masonryPattern.'];
			var columns = '.$masonryColumns.';
			var borderRadius = '.$masonryBorderRadius.';
			var width = 0;
			var height = 0;
			var widthArr = [];
			var heightArr = [];
			var widthPercent;
			var itemClass;
			var overlay = '.$backgroundOverlay.';
			var n = 0;
			
			'.$jQuery.'(".digi_showcase.masonry").find(".masonry-block").each(function(){
				
				if (mode == 0) {
					
					if (blockSize == 0) {
						width = 1;
						height = 1;
					} else if (blockSize == 1) {
						width = 2;
						height = 2;
					} else if (blockSize == 2) {
						width = 2;
						height = 1;
					} else if (blockSize == 3) {
						width = 1;
						height = 2;
					}
					
				} else if (mode == 1) {
					
					// choose randomly the shape of this item
					var randomClass = Math.floor(Math.random() * 4);
					
					// check previous item size to choose the best option to avoid empty spaces in the grid
					if (widthArr[n-1] == 2 && heightArr[n-1] == 2) {
						// square 2x2
						if (randomClass == 1) {
							// horizontal rectangle 2x1
							width = 2;
							height = 1;
						} else if (randomClass == 2) {
							// horizontal rectangle 1x2
							width = 1;
							height = 2;
						} else if (randomClass == 3) {
							// square 2x2
							width = 2;
							height = 2;
						} else if (randomClass == 4) {
							// square 1x1
							width = 1;
							height = 1;
						}
					} else if (widthArr[n-1] == 1 && heightArr[n-1] == 1) {
						// square 1x1
						if (randomClass == 2 || randomClass == 3) {
							// hhorizontal rectangle 2x1
							width = 2;
							height = 1;
						} else {
							// square 1x1
							width = 1;
							height = 1;
						}
					} else if (widthArr[n-1] == 2 && heightArr[n-1] == 1) {
						// horizontal rectangle 2x1
						if (randomClass == 2 || randomClass == 3) {
							// horizontal rectangle 2x1
							width = 2;
							height = 1;
						} else {
							// square 1x1
							width = 1;
							height = 1;
						}
					} else if (widthArr[n-1] == 1 && heightArr[n-1] == 2) {
						// vertical rectangle 1x2
						if (randomClass == 2 || randomClass == 3) {
							// vertical rectangle 1x2
							width = 1;
							height = 2;
						} else {
							// square 1x1
							width = 1;
							height = 1;
						}
					} else {
						if (randomClass == 0) {
							// square 1x1
							width = 1;
							height = 1;
						} else if (randomClass == 1) {
							// square 2x2
							width = 2;
							height = 2;
						} else if (randomClass == 2) {
							// horizontal rectangle 2x1
							width = 2;
							height = 1;
						} else if (randomClass == 3) {
							// vertical rectangle 1x2
							width = 1;
							height = 2;
						}
					}
					
					// check how to end the row to choose the best option to avoid empty spaces in the grid
					if (columns % 2 != 0) {
						// if columns number is odd
						if ((widthArr[n-1] == 2) && (widthArr[n-2] == 2) && (heightArr[n-1] == 2) && (heightArr[n-2] == 2)) {
							// if the last two are squares 2x2 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 2)  && (widthArr[n-3] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 2) && (heightArr[n-3] == 2)) {
							// if the last three are two squares 2x2 and one square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 2) && (widthArr[n-2] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1)) {
							// if the last two are horizontal rectangles 2x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 2) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 1)) {
							// if the last three are two squares 1x1 and one horizontal rectangle 2x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 2) && (widthArr[n-3] == 1) && (heightArr[n-1] == 1) && (heightArr[n-1] == 1) && (heightArr[n-3] == 1)) {
							// if the last three are one square 1x1 and one horizontal rectangle 2x1 and one square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 2) && (heightArr[n-3] == 2)) {
							// if the last three are one square 2x2 and one vertical rectangle 1x2 and one square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (widthArr[n-4] == 1) && (heightArr[n-1] == 2) && (heightArr[n-1] == 2) && (heightArr[n-3] == 2) && (heightArr[n-4] == 2)) {
							// if the last four are vertical rectangles 1x2 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (widthArr[n-4] == 1) && (heightArr[n-1] == 1) && (heightArr[n-1] == 2) && (heightArr[n-3] == 2) && (heightArr[n-4] == 2)) {
							// if the last four are three vertical rectangles 1x2 and a square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (widthArr[n-4] == 1) && (widthArr[n-5] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 2) && (heightArr[n-3] == 2) && (heightArr[n-4] == 2) && (heightArr[n-5] == 2)) {
							// if the last five are four vertical rectangles 1x2 and a square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 2) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 2)) {
							// if the last three are one vertical rectangle 1x2 and one square 1x1 and one horizontal rectangle 2x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1 && (widthArr[n-4] == 1) && (widthArr[n-5] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 1) && (heightArr[n-4] == 1))) {
							// if the last five are four squares 1x1 and one square 2x2 or one horizontal rectangle 2x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1 && (widthArr[n-4] == 1) && (widthArr[n-5] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 1) && (heightArr[n-4] == 2) && (heightArr[n-5] == 2))) {
							// if the last five are one square 2x2 andone vertical rectangle 1x2 and three squares 1x1 add a square 1x1
							width = 1;
							height = 1;
						}
					} else {
						// if columns number is even
						if ((widthArr[n-1] == 2) && (widthArr[n-2] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1)) {
							// if the last two are one horizontal rectangle 2x1 and one square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 2) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1)) {
							// if the last two are one square 1x1 and one horizontal rectangle 2x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 1)) {
							// if the last three are squares 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 1) && (heightArr[n-1] == 2) && (heightArr[n-2] == 2) && (heightArr[n-3] == 1)) {
							// if the last three are two vertical rectangles 1x2 and one square 1x1 add a square 1x1
							width = 1;
							height = 1;
						} else if ((widthArr[n-1] == 1) && (widthArr[n-2] == 1) && (widthArr[n-3] == 2) && (widthArr[n-4] == 1) && (heightArr[n-1] == 1) && (heightArr[n-2] == 1) && (heightArr[n-3] == 1) && (heightArr[n-4] == 1)) {
							// if the last four are one square 1x1 and one horizontal rectangle 1x2 and two squares 1x1 add a square 1x1
							width = 1;
							height = 1;
						}
					}
					
					// enter random sizes in arrays
					widthArr[n] = width;
					heightArr[n] = height;
					
				} else if (mode == 2) {
					
					if (pattern[n] == 4) {
						// square 2x2
						width = 2;
						height = 2;
					} else if (pattern[n] == 3) {
						// horizontal rectangle 2x1
						width = 2;
						height = 1;
					} else if (pattern[n] == 2) {
						// horizontal rectangle 1x2
						width = 1;
						height = 2;
					} else if (pattern[n] == 1) {
						// square 1x1
						width = 1;
						height = 1;
					} else {
						// square 1x1
						width = 1;
						height = 1;
					}
					
					// enter sizes in arrays
					widthArr[n] = width;
					heightArr[n] = height;
					
				}
				
				// assign the correct class to the item
				if (width == 1 && height == 1) {
					itemClass = "square-1-x-1";
				} else if (width == 2 && height == 2) {
					itemClass = "square-2-x-2";
				} else if (width == 2 && height == 1) {
					itemClass = "rectangle-2-x-1";
				} else if (width == 1 && height == 2) {
					itemClass = "rectangle-1-x-2";
				}
				'.$jQuery.'(this).addClass(itemClass);
				
				// generate the sizes of this item based on columns
				widthPercent = (width / columns) * 100;
				
				// assign the size as percent to item width
				'.$jQuery.'(this).width(widthPercent + "%");
				
				// assign the size as pixels to item height and remove vertical padding from total item height to avoid off-grid sizes
				if (width == 1 && height == 1) {
					// square 1x1
					height = ('.$jQuery.'(this).width()) - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.';
				} else if (width == 2 && height == 2) {
					// square 2x2
					height = ('.$jQuery.'(this).width()) - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.';
				} else if (width == 2 && height == 1) {
					// horizontal rectangle 2x1
					height = ('.$jQuery.'(this).width() / 2) - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.';
				} else if (width == 1 && height == 2) {
					// vertical rectangle 1x2
					height = ('.$jQuery.'(this).width() * 2) - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.';
				}
				
				// assign the sizes to image
				'.$jQuery.'(this).find(".image").width('.$jQuery.'(this).width());
				'.$jQuery.'(this).find(".image").height(height);
				
				// assign padding to text
				'.$jQuery.'(this).find(".masonry-text").css("padding-top",('.$jQuery.'(this).height() / 2) - '.$jQuery.'(this).find(".masonry-text").outerHeight());
				
				// assign the sizes to overlay
				if (overlay == 1) {
					'.$jQuery.'(this).find(".overlay").width('.$jQuery.'(this).find(".item-content").width() - '.$itemsPaddingLeft.' - '.$itemsPaddingRight.');
					'.$jQuery.'(this).find(".overlay").height('.$jQuery.'(this).find(".item-content").height() - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.');
				} else {
					'.$jQuery.'(this).find(".item-content > div:first-child").width('.$jQuery.'(this).find(".item-content").width() - '.$itemsPaddingLeft.' - '.$itemsPaddingRight.');
					'.$jQuery.'(this).find(".item-content > div:first-child").height('.$jQuery.'(this).find(".item-content").height() - '.$itemsPaddingTop.' - '.$itemsPaddingBottom.');
				}
				
				// add 1 to n for the next cycle
				n++;
				
			});
			
			'.Digi_Showcase_Helper::getFilterJS($filterArray).'
	});
');

?>

<?php echo Digi_Showcase_Helper::getFilterHTML($filterArray); ?>

<div id="digi_showcase_masonry">

<?php if (!empty($items)) {
    
    foreach($items As $item) {
    
		// get item link
		$link = Digi_Showcase_Helper::getLink($linkArray,$item);
	
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

<div class="masonry-block" style="<?php echo Digi_Showcase_Helper::getBackground($backgroundArray,$image); ?>">

	<div class="showcase-item <?php echo $filterData; ?>">
	
		<div class="item-content<?php echo $image ? '' : ' no-image'; ?>">
		
			<div class="<?php echo $backgroundOverlay == 1 ? 'overlay' : '' ; ?>">
			
				<?php echo Digi_Showcase_Helper::getTextHTML(0,$dataArray,$linkArray,$tagsArray); ?>
				
				<?php echo Digi_Showcase_Helper::getTextHTML(1,$dataArray,$linkArray,$tagsArray); ?>
			
			</div>
			
			<?php echo Digi_Showcase_Helper::getImageHTML($image,$dataArray,$linkArray,$mode); ?>
			
		</div>
		
	</div>
    
</div>
    
<?php
	
	} //end foreach
} //end !empty items

?>

<div class="clearfix"></div>
    
</div>