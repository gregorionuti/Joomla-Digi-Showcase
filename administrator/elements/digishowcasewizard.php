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

// namespaces
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

jimport('joomla.filesystem.file');

class JFormFieldDigishowcasewizard extends JFormField {
    protected $type = 'Digishowcasewizard';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
    	
    	// general variables
    	$document = Factory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$card_class = 'card';
    		$card_body_class = 'card-body';
    		$card_text_class = 'card-text';
    		$background_warning_class = 'bg-warning';
    	} else {
    		$card_class = 'card well';
    		$card_body_class = '';
    		$card_text_class = 'text';
    		$background_warning_class = 'alert alert-warning';
    		
    		$document->addStyleDeclaration('
    			#wizard_icons_wrap > .well {
					max-width: 250px;
					width: 110px !important;
				}
    			#wizard_icons_wrap > .well img {
					width: 100%;
				}
				#wizard_form .bg-light {
					background-color: rgb(248, 249, 250);
					padding: 15px;
					border-radius: 5px;
					color: rgb(37, 37, 41);
					font-weight: bold;
				}
    		');
    	}
    	
    	// add css style
		$document->addStyleDeclaration('
			#wizard_form {
				background-color: #0075b7;
				border-color: #0075b7;
				background-image: url("'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-wizard.png");
				background-repeat: repeat;
			}
			#wizard_form > *, #wizard_form .card-title {
				color: #fff;
			}
			#wizard_icons_wrap .card {
				float: left;
				margin-right: 15px;
				margin-bottom: 15px;
				width: 130px;
			}
			#wizard_icons_wrap a {
				color: #565656;
				text-decoration: none;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				-webkit-transition-property: background-position, 0 0;
				-moz-transition-property: background-position, 0 0;
				-webkit-transition-duration: .8s;
				-moz-transition-duration: .8s;
			}
			#wizard_icons_wrap img {
				padding: 0;
				margin: 0 0 5px 0;
				max-width: 70px;
			}
		');
    	
    	// add javascript code
    	$document->addScriptDeclaration('
			$j(document).ready(function(){
				
				var wizard_message_container = $j("#wizard_message");
				
				$j(function wizard() {
					
					$j("#wizard_icons_wrap").children(".card").each(function() {
						
						var button = $j(this);
						var operation = $j(this).attr("id").replace("wizard_", "");
						
						button.click(function(e) {
							e.stopPropagation();
							e.preventDefault();
							wizardOperation(operation);
						});
					
					});
					
				});
				
				function wizardOperation(current_operation) {
					
					// get the current url
					var current_url = window.location;
					
					// add the current task to the url
					current_url += "&wizard_task=" + current_operation;
					
					$j("#wizard_icons_wrap").fadeOut(function() {
						
						// show the loading alert
						wizard_message_container.html("<div class=\"alert alert-block alert-info\"><h4>PLEASE WAIT</h4> <span id=\"loader\"><img style=\"margin-left: 30px;\" width=\"14\" src=\"http://www.digigreg.com/images/icons/loader.gif\" alt=\"loading\"></span></div>");
					});
					
					$j.ajax({
						url: current_url,
						success: function() {
							
							// show the success alert
							wizard_message_container.html("<div class=\"alert alert-block alert-success\"><h4>DONE</h4> A beautiful " + current_operation.replace("wizard_", "").replace("_", " ").toLowerCase() + " has been created.</div>");
							
							// reload the page and remove from the url undesidered parts
							window.location = current_url.replace("#", "").replace("&wizard_task=" + current_operation, "");
						}
					});
					
				}
				
			});
		');
        
        // include digigreg api
        include_once "digigreg_api.php";
        
        // general variables
        $uri = Uri::getInstance();
        
        // set the table and the column of database
        $db_table = '#__modules';
        $db_column = 'id';
        
        // get variables from url
        $extension_id = $uri->getVar('id', 'none');
        $task = $uri->getVar('wizard_task', 'none');
        
// get module data from database
			$dbo = Factory::getDBO();
			$query = 'SELECT params FROM '.$db_table.' WHERE '.$db_column.' = '.$extension_id.' LIMIT 1';	
            $dbo->setQuery($query);
            $params = $dbo->loadObject();
			
			// replace params
			$params = json_decode($params->params);
        
        // if url contains proper variables
		if ($extension_id !== 'none' && is_numeric($extension_id) && $task !== 'none') {
			
			if ($task == 'list') {
				// mode
				$params->mode = 0;
				$params->rows = 10;
				$params->columns = 1;
				// layout
				$params->{'filter-switch'} = 0;
				$params->{'items-padding'} = '15 15 15 15';
				$params->{'items-css'} = 'border: 2px solid; border-radius: 2px; margin-bottom: 15px;';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 0;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 1;
				$params->{'category-switch'} = 1;
				$params->{'show-extra-info'} = 1;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'table') {
				// mode
				$params->mode = 0;
				$params->rows = 6;
				$params->columns = 4;
				// layout
				$params->{'filter-switch'} = 0;
				$params->{'items-padding'} = '10 10 10 10';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 0;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 1;
				$params->{'category-switch'} = 1;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'slideshow') {
				// mode
				$params->mode = 1;
				$params->{'carousel-mode'} = 0;
				$params->{'carousel-autoanimation'} = 1;
				$params->{'carousel-autoanimation-interval'} = 5000;
				$params->{'carousel-items-quantity'} = 3;
				$params->{'carousel-columns-quantity'} = 1;
				$params->{'carousel-scroll-quantity'} = 1;
				$params->{'carousel-arrows'} = 1;
				$params->{'carousel-dots'} = 0;
				$params->{'carousel-loop'} = 1;
				$params->{'carousel-center-element'} = 0;
				// layout
				$params->{'filter-switch'} = 0;
				$params->{'items-padding'} = '0 0 0 0';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 0;
				$params->{'show_title'} = 0;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'carousel') {
				// mode
				$params->mode = 1;
				$params->{'carousel-mode'} = 0;
				$params->{'carousel-autoanimation'} = 1;
				$params->{'carousel-autoanimation-interval'} = 3000;
				$params->{'carousel-items-quantity'} = 6;
				$params->{'carousel-columns-quantity'} = 3;
				$params->{'carousel-scroll-quantity'} = 1;
				$params->{'carousel-arrows'} = 1;
				$params->{'carousel-dots'} = 1;
				$params->{'carousel-loop'} = 1;
				$params->{'carousel-center-element'} = 1;
				// layout
				$params->{'filter-switch'} = 0;
				$params->{'items-padding'} = '0 0 0 0';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 0;
				$params->{'show_title'} = 0;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'timeline') {
				// mode
				$params->mode = 2;
				$params->{'timeline-items-quantity'} = 12;
				$params->{'timeline-animation'} = 1;
				$params->{'timeline-image-inside'} = 0;
				// layout
				$params->{'filter-switch'} = 1;
				$params->{'filter-alignment'} = 1;
				$params->{'items-padding'} = '0 10 0 10';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 1;
				$params->{'image_width'} = 100;
				$params->{'image_height'} = 100;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 1;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 1;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'tag_cloud') {
				// mode
				$params->mode = 3;
				$params->{'sphere-items-quantity'} = 18;
				$params->{'sphere-width'} = 400;
				$params->{'sphere-height'} = 400;
				$params->{'sphere-radius'} = 150;
				// layout
				$params->{'filter-switch'} = 0;
				$params->{'items-padding'} = '0 0 0 0';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 1;
				$params->{'image_width'} = 100;
				$params->{'image_height'} = 100;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 0;
			} else if ($task == 'random_grid') {
				// mode
				$params->mode = 4;
				$params->{'masonry-items-quantity'} = 20;
				$params->{'masonry-columns'} = 5;
				$params->{'masonry-mode'} = 1;
				// layout
				$params->{'filter-switch'} = 1;
				$params->{'filter-alignment'} = 1;
				$params->{'items-padding'} = '10 10 10 10';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 1;
				$params->{'image_width'} = 400;
				$params->{'image_height'} = 400;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 1;
			} else if ($task == 'big_grid') {
				// mode
				$params->mode = 4;
				$params->{'masonry-items-quantity'} = 9;
				$params->{'masonry-columns'} = 6;
				$params->{'masonry-mode'} = 0;
				$params->{'masonry-blocks-size'} = 1;
				// layout
				$params->{'filter-switch'} = 1;
				$params->{'filter-alignment'} = 1;
				$params->{'items-padding'} = '10 10 10 10';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 1;
				$params->{'image_width'} = 400;
				$params->{'image_height'} = 400;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 1;
			} else if ($task == 'small_grid') {
				// mode
				$params->mode = 4;
				$params->{'masonry-items-quantity'} = 25;
				$params->{'masonry-columns'} = 5;
				$params->{'masonry-mode'} = 0;
				$params->{'masonry-blocks-size'} = 0;
				// layout
				$params->{'filter-switch'} = 1;
				$params->{'filter-alignment'} = 1;
				$params->{'items-padding'} = '10 10 10 10';
				$params->{'items-css'} = '';
				// items
				$params->{'show_image'} = 1;
				$params->{'image-type'} = 3;
				$params->{'show_placeholder_image'} = 1;
				$params->{'generate_thumbnail'} = 1;
				$params->{'image_width'} = 200;
				$params->{'image_height'} = 200;
				$params->{'show_title'} = 1;
				$params->{'show_description'} = 0;
				$params->{'category-switch'} = 0;
				$params->{'show-extra-info'} = 0;
				$params->{'items-background-switch'} = 0;
				$params->{'items-background-overlay'} = 1;
			}
			
			
			$params = json_encode($params);
			
			// set module data in database
			$dbo = Factory::getDBO();
			$query = 'UPDATE '.$db_table.' SET params = '.$dbo->quote($params).' WHERE '.$db_column.' = '.$extension_id.' LIMIT 1';
            $dbo->setQuery($query);
            $result = $dbo->execute();
            
        }
        
        $html = '';
        
        $html .= '<div id="wizard_form" class="'.$card_class.'">';
  		
        $html .= '<div class="'.$card_body_class.'">';
		$html .= '<h2 class="card-title">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_WIZARD_TITLE').'</h2>';
        $html .= '<p class="card-text bg-light text-dark rounded p-3">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_WIZARD_DESC').'</p>';
        $html .= '<div id="wizard_message" class="system-message"></div>';
        $html .= '<div id="wizard_icons_wrap" class="clearfix">';
        
        if (!$params) {
			$html .= '<h2 class="card-title">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_WIZARD_SAVE_FIRST').'</h2>';
		} else {
        
        // standard (list)
        $html .= '<div id="wizard_list" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="List" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-list.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">List</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // standard (table)
        $html .= '<div id="wizard_table" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Table" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-table.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Table</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // carousel (slideshow)
        $html .= '<div id="wizard_slideshow" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Slideshow" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-slideshow.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Slideshow</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // carousel (carousel)
        $html .= '<div id="wizard_carousel" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Carousel" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-carousel.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Carousel</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // timeline
        $html .= '<div id="wizard_timeline" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Timeline" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-timeline.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Timeline</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // tag cloud
        $html .= '<div id="wizard_tag_cloud" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Tag Cloud" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-tag-cloud.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Tag Cloud</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // masonry (random grid)
        $html .= '<div id="wizard_random_grid" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Random Grid" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-random-grid.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Random Grid</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // masonry (big grid)
        $html .= '<div id="wizard_big_grid" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Big Grid" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-big-grid.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Big Grid</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // masonry (small grid)
        $html .= '<div id="wizard_small_grid" class="'.$card_class.' text-center">';
        $html .= '<div class="'.$card_body_class.'">';
        $html .= '<a href="#"><img class="card-img-top" alt="Small Grid" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'icon-small-grid.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="#">Small Grid</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>