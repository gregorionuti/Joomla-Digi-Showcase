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
$document->addStyleSheet(JURI::root().'modules/mod_digi_showcase/assets/css/timeline.css');

// add css style
$document->addStyleDeclaration('
	#digi_showcase_'.$moduleId.'.timeline .timeline-container {
		max-width: '.$timelineMaxWidth.'px;
	}
	#digi_showcase_'.$moduleId.'.timeline .timeline-content {
		background-color: '.$timelinePrimaryColor.';
		border-radius: '.$timelineBorderRadius.'px;
	}
	#digi_showcase_'.$moduleId.'.timeline .timeline-content::before {
		border-color: transparent '.$timelinePrimaryColor.' transparent transparent;
	}
	#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(2n) .timeline-content::before {
		border-color: transparent '.$timelinePrimaryColor.' transparent transparent;
	}
	#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-block:hover .timeline-img {
		box-shadow: 0 0 0 4px '.$timelinePrimaryColor.', inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 4px 0 4px rgba(0, 0, 0, 0.1);
	}
	#digi_showcase_'.$moduleId.'.timeline .timeline-img {
	  	background-color: '.$timelineSecondaryColor.';
	  	box-shadow: 0 0 0 4px '.$timelinePrimaryColor.', inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 4px 0 4px rgba(0, 0, 0, 0.05);
	}
	#digi_showcase_'.$moduleId.'.timeline .item-image-placeholder {
		font-size: 18px;
		line-height: 40px;
	}
	@media only screen and (min-width: '.$timelineSwitchWidth.'px) {
		#digi_showcase_'.$moduleId.' #digi_showcase_timeline {
			margin-top: 3em;
			margin-bottom: 3em;
		}
	  	#digi_showcase_'.$moduleId.' #digi_showcase_timeline::before {
			left: 50%;
			margin-left: -2px;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block {
			margin: 4em 0;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:first-child {
			margin-top: 0;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:last-child {
			margin-bottom: 0;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-img {
			width: 60px;
			height: 60px;
			left: 50%;
			margin-left: -30px;
			-webkit-transform: translateZ(0);
			-webkit-backface-visibility: hidden;
		}
		#digi_showcase_'.$moduleId.'.timeline .timeline-img img {
			height: 60px;
			width: 60px;
		}
		#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-img.is-hidden {
			visibility: hidden;
		}
		#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-img.bounce-in {
			visibility: visible;
			-webkit-animation: bounce-1 0.6s;
			-moz-animation: bounce-1 0.6s;
			animation: bounce-1 0.6s;
		}
		#digi_showcase_'.$moduleId.'.timeline .timeline-content {
			margin-left: 0;
			width: 45%;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-content::before {
			border-color: transparent transparent transparent '.$timelinePrimaryColor.';
			top: 24px;
			left: 100%;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-content .readmore {
			float: left;
	 	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-content .extra-info {
			position: absolute;
			width: 100%;
			left: 122%;
			top: 8px;
			font-size: 16px;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .item-image-placeholder {
			font-size: 30px;
			line-height: 58px;
		}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content {
			float: right;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content::before {
			top: 24px;
			left: auto;
			right: 100%;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content .readmore {
			float: right;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content .extra-info {
			left: auto;
			right: 122%;
			text-align: right;
	 	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-content.is-hidden {
			visibility: hidden;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-content.bounce-in {
			visibility: visible;
			-webkit-animation: bounce-2 0.6s;
			-moz-animation: bounce-2 0.6s;
			animation: bounce-2 0.6s;
	  	}
	  	#digi_showcase_'.$moduleId.'.timeline .timeline-animated .timeline-block:nth-child(even) .timeline-content.bounce-in {
			-webkit-animation: bounce-2-inverse 0.6s;
			-moz-animation: bounce-2-inverse 0.6s;
			animation: bounce-2-inverse 0.6s;
	  	}
	}
	
	'.Digi_Showcase_Helper::getFilterCSS($filterArray).'
');
if ($timelineSecondaryColor) {
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .timeline-content {
			box-shadow: 0 4px 0 '.$timelineSecondaryColor.';
		}
		#digi_showcase_'.$moduleId.' #digi_showcase_timeline::before {
			background-color: '.$timelineSecondaryColor.';
		}
	');
}
if ($itemsPadding) {
	$document = JFactory::getDocument();
	$document->addStyleDeclaration('
		@media only screen and (min-width: '.($timelineMaxWidth - 1).'px) {
			#digi_showcase_'.$moduleId.' .timeline-content .extra-info {
				padding-right: '.$itemsPaddingRight.'px;
				padding-left: '.$itemsPaddingLeft.'px;
			}
	  	}
	');
}
if ($itemsPadding && $backgroundOverlay == 0) {
	$document = JFactory::getDocument();
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .timeline-content {
			padding-top: '.$itemsPaddingTop.'px;
			padding-right: '.$itemsPaddingRight.'px;
			padding-bottom: '.$itemsPaddingBottom.'px;
			padding-left: '.$itemsPaddingLeft.'px;
		}
	');
} else if ($itemsPadding && $backgroundOverlay == 1) {
	$document = JFactory::getDocument();
	$document->addStyleDeclaration('
		#digi_showcase_'.$moduleId.' .timeline-content .overlay {
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
	'.$jQuery.'(document).ready(function() {
		'.Digi_Showcase_Helper::getFilterJS($filterArray).'
	});
');
if ($timelineAnimation == 1) {
	$document->addScriptDeclaration('
		'.$jQueryNoConflictDeclaration.'
		'.$jQuery.'(document).ready(function(){
			var timelineBlocks = '.$jQuery.'(".timeline-block"), offset = 0.8;		
			
			hideBlocks(timelineBlocks, offset);
				
			'.$jQuery.'(window).on("scroll", function(){
				(!window.requestAnimationFrame) 
					? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
					: window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
			});
			
			function hideBlocks(blocks, offset) {
				blocks.each(function(){
					( '.$jQuery.'(this).offset().top > '.$jQuery.'(window).scrollTop()+'.$jQuery.'(window).height()*offset ) && '.$jQuery.'(this).find(".timeline-img, .timeline-content").addClass("is-hidden");
				});
			}
			
			function showBlocks(blocks, offset) {
				blocks.each(function(){
					( '.$jQuery.'(this).offset().top <= '.$jQuery.'(window).scrollTop()+'.$jQuery.'(window).height()*offset && '.$jQuery.'(this).find(".timeline-img").hasClass("is-hidden") ) && '.$jQuery.'(this).find(".timeline-img, .timeline-content").removeClass("is-hidden").addClass("bounce-in");
				});
			}
			
			var width = '.$jQuery.'(window).width();
			var moduleWidth = '.$jQuery.'("#digi_showcase_'.$moduleId.' .timeline-container").width();
			
			if (moduleWidth <= 940 && width >= '.$timelineSwitchWidth.') {
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-content").css("width","44%");
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(odd) .timeline-content .extra-info").css("left","123%");
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content .extra-info").css("right","123%");
			}
			
			if (moduleWidth <= 760 && width >= '.$timelineSwitchWidth.') {
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-content").css("width","41%");
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(odd) .timeline-content .extra-info").css("left","142%");
				'.$jQuery.'("#digi_showcase_'.$moduleId.'.timeline .timeline-block:nth-child(even) .timeline-content .extra-info").css("right","142%");
			}
			
		});
	');
}

?>

<?php echo Digi_Showcase_Helper::getFilterHTML($filterArray); ?>

<div id="digi_showcase_timeline" class="timeline-container<?php echo $timelineAnimation == 1 ? ' timeline-animated' : '' ?>">

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
		
		// force span tag for extra info and category because timeline mode needs it
		$tagsArray['category-tag'] = 'span';
		$tagsArray['extra-info-tag'] = 'span';
		
		// get filter css class
		$filterData = Digi_Showcase_Helper::getFilterClass($filterArray,$item);
    	
?>

	<div class="showcase-item timeline-block <?php echo $filterData; ?>" style="<?php echo Digi_Showcase_Helper::getBackground($backgroundArray,$image); ?>">
    	
			<div class="timeline-img timeline-picture">
		
				<?php echo $image ? Digi_Showcase_Helper::getImageHTML($image,$dataArray,$linkArray,$mode) : '<p class="item-image-placeholder">'.substr($item['title'], 0, 2).'</p>'; ?>
			
			</div>
			
			<div class="timeline-content<?php echo $image ? '' : ' no-image'; ?>">  
				
    			<?php echo $backgroundOverlay == 1 ? '<div class="overlay">' : '' ; ?>
				
					<?php echo str_replace(['class="extra-info text-center"', 'class="category text-center"'], 'class="extra-info"', Digi_Showcase_Helper::getTextHTML(0,$dataArray,$linkArray,$tagsArray)); ?>
					
					<?php if ($timelineImageInside == 1) { ?>
						<?php echo Digi_Showcase_Helper::getImageHTML($image,$dataArray,$linkArray,$mode); ?>
					<?php } ?>
				
					<?php echo str_replace(['class="extra-info text-center"', 'class="category text-center"'], 'class="extra-info"', Digi_Showcase_Helper::getTextHTML(1,$dataArray,$linkArray,$tagsArray)); ?>
                
    			<?php echo $backgroundOverlay == 1 ? '</div>' : ''; ?>
                
			</div>
        
    </div>
	    
<?php

	} //end foreach
} //end !empty items

?>

</div>