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

class mod_Digi_ShowcaseInstallerScript {
	
	function update($parent) {
    	
    	// specific classes based on joomla version
    	if (version_compare(JVERSION, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12';
    		$badge_class = 'badge bg-success';
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span12';
    		$badge_class = 'label label-success';
    	}
		
		$version = $parent->getManifest()->version;
		
    	$paypal_link = 'https://www.paypal.com/paypalme/gregorionuti';
    	$revolut_link = 'https://revolut.me/gregorionuti';
    	$kofi_link = 'https://ko-fi.com/gregorionuti';
		
		$html = '';
        
        $html .= '<div class="'.$row_class.'">';
        
        $html .= '<div class="'.$col_class.'">';
        
        $html .= '<div id="digigreg_donation">';
        
        $html .= '<div id="digigreg_donation_text">';
        
        $html .= '<h2>Do you enjoy Digi Showcase? If yes, please, donate a small amount to help its development</h2>';
        
        $html .= '<p>The development of this extension and its <strong>conversion for Joomla 5</strong> took many hours of work. With a small donation, you can help the developer to keep it up to date and tuned up over time. Even € 1 or whatever small amount can help. Thank you so much!<br /><small><i class="text-dark">Greg</i></small>'.'</p>';
        $html .= '<p>';
        $html .= '<span class="text-uppercase">Please donate via these links</span> <br />';
        $html .= '<a style="margin-top: 5px; margin-right: 10px;" class="btn btn-light" target="_blank" href="'.$paypal_link.'"><img style="width: 16px; height: 16px; margin-right: 2px; margin-top: -3px;" class="btn-img" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-paypal.png" alt="PayPal" />PayPal</a>';
        $html .= '<a style="margin-top: 5px; margin-right: 10px;" class="btn btn-light" target="_blank" href="'.$revolut_link.'"><img style="width: 16px; height: 16px; margin-right: 2px; margin-top: -3px;" class="btn-img" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-revolut.png" alt="Revolut" />Revolut</a>';
        $html .= '<a style="margin-top: 5px; margin-right: 10px;" class="btn btn-light" target="_blank" href="'.$kofi_link.'"><img style="width: 16px; height: 16px; margin-right: 2px; margin-top: -3px;" class="btn-img" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-ko-fi.png" alt="Ko-fi" />Ko-fi</a>';
        $html .= '</p>';
        
		$html .= '</div>';
		
		$html .= '</div>';
        
        $html .= '</div>';
        
        $html .= '</div>';
        
        echo $html;
		
	}
	
}

?>