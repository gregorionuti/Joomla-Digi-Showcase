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

jimport('joomla.filesystem.file');

class JFormFieldDigishowcaseadv extends JFormField {
    protected $type = 'Digishowcaseadv';
    
    protected function getInput() {
    	
    	// General variables
    	$support_question_link = 'https://www.digigreg.com/#contact-presale';
    	$document = JFactory::getDocument();
        $joomlaVersion = JVERSION;
        
        // links
		$link_digigreg = 'https://www.digigreg.com/en/products/joomla-plugins/params-backup.html';
		$link_iubenda = 'https://iubenda.refr.cc/5KMPDH3';
		$link_nordvpn = 'https://go.nordvpn.net/aff_c?offer_id=15&aff_id=109996&url_id=858';
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-4';
    		$card_class = 'card';
    		$card_text_class = 'card-text';
    		$background_warning_class = 'bg-warning';
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span4';
    		$card_class = 'well';
    		$card_text_class = 'lead';
    		$background_warning_class = 'alert alert-warning';
    		
    		$document->addStyleDeclaration('
    			#adv_cards_wrap > .well {
					float: left;
					max-width: 250px;
					margin-right: 10px;
					margin-left: 10px;
				}
    			#adv_cards_wrap > .well img {
					width: 100%;
				}
				#adv_wrapper .bg-light {
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
			#adv_wrapper {
				background-color: #3498db;
				border-color: #3498db;
				background-image: url("'.JURI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-customization.png");
				background-repeat: repeat;
			}
			#adv_wrapper a[target="_blank"]::before {
				content: "";
			}
			#adv_cards_wrap .card {
				margin-bottom: 15px;
				overflow: hidden;
			}
			#adv_cards_wrap .card img {
				background-color: rgba(255, 255, 255, 0.5);
			}
		');
		
		$html = '';
        
        $html .= '<div id="adv_wrapper" class="'.$card_class.'">';
        $html .= '<div class="card-body pb-0">';
        $html .= '<div id="adv_cards_wrap" class="clearfix">';
        
        // open row
		$html .= '<div class="'.$row_class.'">';
		
        // Params Backup
        $html .= '<div class="'.$col_class.'" id="adv_params_backup">';
        $html .= '<div class="'.$card_class.' text-start text-left">';
        $html .= '<a href="'.$link_digigreg.'"><img alt="Params Backup" class="card-img-top" src="'.JURI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-params-backup.png" /></a>';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title mb-4">Params Backup plugin - Free</h5>';
        $html .= '<p class="card-text">With Params Backup you can save settings of Joomla extension you are editing, and then reload them when necessary, with one click. It works with modules, plugins, templates and component configurations.</p>';
		$html .= '<p class="card-text">Check out the plugin by the link below.</p>';		
        $html .= '<a href="'.$link_digigreg.'" class="btn btn-primary" target="_blank">Find out more</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Iubenda
        $html .= '<div class="'.$col_class.'" id="adv_iubenda">';
        $html .= '<div class="'.$card_class.' text-start text-left">';
        $html .= '<a href="'.$link_iubenda.'"><img alt="Iubenda" class="card-img-top" src="'.JURI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-iubenda.png" /></a>';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title mb-4">Iubenda - Get 10% first year/month discount</h5>';
        $html .= '<p class="card-text">Make your site GDPR compliant now. Create the Cookie banner. Get Google Consent Mode, start measuring Google Analytics traffic and Google Ads conversions even when the consent banner is rejected.</p>';
		$html .= '<p class="card-text">Check out the offer by the (affiliated) link below.</p>';
        $html .= '<a href="'.$link_iubenda.'" class="btn btn-primary" target="_blank">Explore the offer</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // NordVPN
        $html .= '<div class="'.$col_class.'" id="adv_nordvpn">';
        $html .= '<div class="'.$card_class.' text-start text-left">';
        $html .= '<a href="'.$link_nordvpn.'"><img alt="NordVPN" class="card-img-top" src="'.JURI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-nordvpn.png" /></a>';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title mb-4">NordVPN - Get up to 73% off discount + 3 extra months</h5>';
        $html .= '<p class="card-text">Surf online with peace of mind. NordVPN will meet your daily cybersecurity needs by protecting your Internet traffic and blocking dangerous websites, advertisements and malware.</p>';
		$html .= '<p class="card-text">Check out the offer by the (affiliated) link below.</p>';
		$html .= '<a href="'.$link_nordvpn.'" class="btn btn-primary" target="_blank">Explore the offer</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>