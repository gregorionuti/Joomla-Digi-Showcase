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
use Joomla\CMS\Uri\Uri;

jimport('joomla.filesystem.file');

class JFormFieldDigishowcasecstm extends JFormField {
    protected $type = 'Digishowcasecstm';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
    	
    	// general variables
    	$support_question_link = 'https://www.digigreg.com/#contact-presale';
    	$document = JFactory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12';
    		$card_class = 'card';
    		$card_text_class = 'card-text';
    		$background_warning_class = 'bg-warning';
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span12';
    		$card_class = 'well';
    		$card_text_class = 'lead';
    		$background_warning_class = 'alert alert-warning';
    		
    		$document->addStyleDeclaration('
    			#customization_icons_wrap > .well {
					float: left;
					max-width: 250px;
					margin-right: 10px;
					margin-left: 10px;
				}
    			#customization_icons_wrap > .well img {
					width: 100%;
				}
				#customization_form .bg-light {
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
			#customization_form {
				background-color: #3498db;
				border-color: #3498db;
				background-image: url("'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-customization.png");
				background-repeat: repeat;
			}
			#customization_form a[target="_blank"]::before {
				content: "";
			}
			#customization_form > *, #customization_form .card-title {
				color: #fff;
			}
			#customization_icons_wrap .card {
				float: left;
				margin-right: 15px;
				margin-bottom: 15px;
				width: 260px;
			}
			#customization_icons_wrap a {
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
			#customization_icons_wrap img {
				padding: 0;
				margin: 0 0 5px 0;
				max-width: 220px;
			}
		');
        
        $html = '';
        
        $html .= '<div id="customization_form" class="'.$card_class.'">';
  		
        $html .= '<div class="card-body">';
		$html .= '<h2 class="card-title">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_CUSTOMUZATION_TITLE').'</h2>';
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_CUSTOMUZATION_DESC').'</p>';
        $html .= '<div id="customization_icons_wrap" class="clearfix">';
        
        // enquiry
        $html .= '<div id="customization_enquiry" class="'.$card_class.' text-center">';
        $html .= '<div class="card-body">';
        $html .= '<a href="'.$support_question_link.'" target="_blank"><img class="card-img-top" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'customization-tech-support.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="'.$support_question_link.'" target="_blank">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_ASK_A_QUESTION_TITLE').'</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        if (!version_compare($joomlaVersion, "4.0.0", ">=")) {
        	// joomla migration
			$html .= '<div id="customization_migration" class="'.$card_class.' '.$background_warning_class.' text-center">';
			$html .= '<div class="card-body">';
			$html .= '<h4><a href="'.$support_question_link.'" target="_blank">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_REQUEST_A_QUOTE_JOOMLA_MIGRATION_DESC').'</a></h4>';
			$html .= '<p class="'.$card_text_class.'"><a href="'.$support_question_link.'" target="_blank">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_REQUEST_A_QUOTE_JOOMLA_MIGRATION_TITLE').'</a></p>';
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