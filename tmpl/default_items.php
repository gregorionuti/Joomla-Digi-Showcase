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

// add css style
$document->addStyleDeclaration('
	'.Digi_Showcase_Helper::getFilterCSS($filterArray).'
');

// add javascript code
$document->addScriptDeclaration('
	'.$jQueryNoConflictDeclaration.'
	'.$jQuery.'(document).ready(function(){
		'.Digi_Showcase_Helper::getFilterJS($filterArray).'
	});
');

?>

<?php echo Digi_Showcase_Helper::getFilterHTML($filterArray); ?>

<div class="<?php echo $rowsClass; ?>">

<?php if (!empty($items)) {
    
	$i=0;
    
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

<div class="showcase-item <?php echo $columnsClass.$columnsSpan; ?> <?php echo $filterData; ?>" style="<?php echo Digi_Showcase_Helper::getBackground($backgroundArray,$image); ?>">
	
    <?php echo $backgroundOverlay == 1 ? '<div class="overlay">' : '' ; ?>
    
		<div class="item-content<?php echo $image ? '' : ' no-image'; ?>">
			
				<?php echo Digi_Showcase_Helper::getTextHTML(0,$dataArray,$linkArray,$tagsArray); ?>
				
				<?php echo Digi_Showcase_Helper::getImageHTML($image,$dataArray,$linkArray,$mode); ?>
				
				<?php echo Digi_Showcase_Helper::getTextHTML(1,$dataArray,$linkArray,$tagsArray); ?>
			
		</div>
    
    <?php echo $backgroundOverlay == 1 ? '</div>' : ''; ?>
    
</div>
        
<?php
		
		$i++;
		
		// only bootstrap 2 needs the div of the row to be closed for each displayed row
		if ($bootstrapVersion == 0) {
			
			// close the div of the bootstrap row, only for bootstrap 2
			if ($columns == $i || $columns == ($i %$columns == 0)) {
				if ($i < ($rows * $columns)) {
					echo '</div><div class="'.$rowsClass.'">';
				}
			}
		}
	
	} //end foreach
} //end !empty items

?>
    
</div>