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

class JFormFieldDigishowcaseeds extends JFormField {
    protected $type = 'Digishowcaseeds';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
    	
    	// general variables
    	$document = JFactory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12';
    		$card_class = 'card';
    		$card_text_class = 'card-text';
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span12';
    		$card_class = 'well';
    		$card_text_class = 'lead';
    		
    		$document->addStyleDeclaration('
    			#extra_data_source_icons_wrap > .well {
					float: left;
					max-width: 250px;
					margin-right: 10px;
					margin-left: 10px;
				}
    			#extra_data_source_icons_wrap > .well img {
					width: 100%;
				}
				#extra_data_source_form .bg-light {
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
			#extra_data_source_form {
				background-color: #8e44ad;
				border-color: #8e44ad;
				background-image: url("'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-eds.png");
				background-repeat: repeat;
			}
			#extra_data_source_form a[target="_blank"]::before {
				content: "";
			}
			#extra_data_source_form > *, #extra_data_source_form .card-title {
				color: #fff;
			}
			#extra_data_source_icons_wrap .card {
				float: left;
				margin-right: 15px;
				margin-bottom: 15px;
				width: 260px;
			}
			#extra_data_source_icons_wrap a {
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
			#extra_data_source_icons_wrap img {
				padding: 0;
				margin: 0 0 5px 0;
				max-width: 220px;
			}
		');
        
        $html = '';
        
        $html .= '<div id="extra_data_source_form" class="'.$card_class.'">';
  		
        $html .= '<div class="card-body">';
		$html .= '<h2 class="card-title">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_EXTRA_DATA_SOURCE_TITLE').'</h2>';
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_EXTRA_DATA_SOURCE_DESC').'</p>';
        $html .= '<div id="extra_data_source_icons_wrap" class="clearfix">';
        
        // virtuemart
        $html .= '<div id="extra_data_source_virtuemart_categories" class="'.$card_class.' text-center">';
        $html .= '<div class="card-body">';
        $html .= '<a href="https://www.digigreg.com/en/products/joomla-plugins/digi-showcase-plugins/digi-showcase-virtuemart-categories.html" target="_blank"><img class="card-img-top" alt="Virtuemart Categories" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'extra-data-source-virtuemart-categories.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="https://www.digigreg.com/en/products/joomla-plugins/digi-showcase-plugins/digi-showcase-virtuemart-categories.html" target="_blank">Virtuemart Categories</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // users
        $html .= '<div id="extra_data_source_joomla_users" class="'.$card_class.' text-center">';
        $html .= '<div class="card-body">';
        $html .= '<a href="https://www.digigreg.com/en/products/joomla-plugins/digi-showcase-plugins/digi-showcase-joomla-users.html" target="_blank"><img class="card-img-top" alt="Joomla Users" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'extra-data-source-joomla-users.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="https://www.digigreg.com/en/products/joomla-plugins/digi-showcase-plugins/digi-showcase-joomla-users.html" target="_blank">Joomla Users</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        // login to your account
        $html .= '<div id="extra_data_source_go_to_your_account" class="'.$card_class.' text-center">';
        $html .= '<div class="card-body">';
        $html .= '<a href="https://www.digigreg.com/en/login.html" target="_blank"><img class="card-img-top" alt="Joomla Users" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'go-to-your-account.png"></a>';
        $html .= '<p class="'.$card_text_class.'"><a href="https://www.digigreg.com/en/login.html" target="_blank">'.JText::_('MOD_DIGI_SHOWCASE_FIELD_GO_TO_YOUR_ACCOUNT_TITLE').'</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>