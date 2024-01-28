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

jimport('joomla.form.formfield');

class JFormFieldDigishowcaseadv extends JFormField {
    protected $type = 'Digishowcaseadv';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
    	
    	// general variables
    	$support_question_link = 'https://www.digigreg.com/#contact-presale';
    	$support_one_hour_link = 'https://www.digigreg.com/en/products/tech-support/sign-up.html#hours-1';
    	$support_two_hours_link = 'https://www.digigreg.com/en/products/tech-support/sign-up.html#hours-2';
    	$support_three_hours_link = 'https://www.digigreg.com/en/products/tech-support/sign-up.html#hours-3';
    	$support_five_hours_link = 'https://www.digigreg.com/en/products/tech-support/sign-up.html#hours-5';
    	$support_ten_hours_link = 'https://www.digigreg.com/en/products/tech-support/sign-up.html#hours-10';
    	$btc_address = "bc1qnuswkl7jhc2p8dm00ryqlu92ctgg58rzthquy6";
    	$eth_address = "0xBe43A9F77a80AA064FedAE5B427fd5b3077D2cc0";
    	$paypal_link = 'https://www.paypal.com/paypalme/gregorionuti';
    	$revolut_link = 'https://revolut.me/gregorionuti';
    	$document = JFactory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-6';
    		$card_class = 'card';
    		$card_title_class = 'card-title';
    		$card_body_class = 'card-body';
    		$card_text_class = 'card-text';
    		$bg_success_class = "bg-success";
    		$btn_dark_class = "btn-outline-dark";
    		
    		$document->addStyleDeclaration('
    			@media (max-width: 1300px) {
					#digigreg_donation .card-text, #digigreg_adv .card-text {
						word-wrap: anywhere;
					}
				}
    			@media (max-width: 767px) {
					#digigreg_donation, #digigreg_adv {
						margin: 0 1rem;
					}
				}
    		');
    		
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span6';
    		$card_class = 'well';
    		$card_title_class = 'title';
    		$card_body_class = 'well';
    		$card_text_class = 'text';
    		$bg_success_class = "alert alert-success";
    		$btn_dark_class = "btn-warning";
    		
    		$document->addStyleDeclaration('
    			#digigreg_adv .well, #digigreg_donation .well {
					margin: 0;
					background-color: rgba(255, 255, 255, 0.7);
				}
    			#digigreg_adv .well .btn-group, #digigreg_donation .well .btn-group,
    			#digigreg_adv .well .mt-1, #digigreg_donation .well .mt-1 {
					margin-top: 10px;
				}
				@media (max-width: 1300px) {
					#digigreg_donation .text, #digigreg_adv .text {
						word-wrap: anywhere;
					}
					#digigreg_adv .btn {
						display: block;
						border-radius: 3px;
						margin-bottom: 10px;
					}
				}
    		');
    	}
    	
    	// add css style
		$document->addStyleDeclaration('
			#digigreg_adv {
				background-color: #f89406;
				background-image: url("'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-suggestion.png");
				background-repeat: repeat;
				position: relative;
				z-index: 0;
				display: flex;
				align-items: center;
				justify-content: center;
				min-height: 276px;
				overflow: hidden;
			}
			#digigreg_donation {
				background-color: #00b16a;
				background-image: url("'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'pattern-donation.png");
				background-repeat: repeat;
				position: relative;
				z-index: 0;
				display: flex;
				align-items: center;
				justify-content: center;
				min-height: 276px;
				overflow: hidden;
				animation: shake 5s;
				animation-iteration-count: infinite; 
			}
			#digigreg_donation:hover {
				animation: none;
			}
			#digigreg_adv a[target="_blank"]::before, #digigreg_donation a[target="_blank"]::before {
				content: "";
			}
			#digigreg_adv_text, #digigreg_donation_text {
				text-align: left;
			}
			#digigreg_donation .pulse {
				display: none;
			}
			#digigreg_donation:hover .pulse {
				display: block;
				z-index: -1;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				max-width: 1024px;
			}
			#digigreg_donation:hover .pulse circle {
				fill: #7fc6a4;
				transform: scale(0);
				opacity: 0;
				transform-origin: 50% 50%;
				animation: pulse 2s cubic-bezier(.5,.5,0,1) infinite;
			}
			#digigreg_donation:hover .pulse circle:nth-child(2) {
				animation: pulse 2s 0.75s cubic-bezier(.5,.5,0,1) infinite;
			}
			#digigreg_donation:hover .pulse circle:nth-child(3) {
				animation: pulse 2s 1.5s cubic-bezier(.5,.5,0,1) infinite;
			}
			#digigreg_donation .btn-img {
				width: 16px;
				height: 16px;
				margin-right: 2px;
				margin-top: -3px;
			}
			@keyframes pulse {
				25% {
					opacity: 0.4;
				}
				100% {
					transform: scale(1);
				}
			}
			@keyframes shake {
				0% { transform: translate(1px, 1px) rotate(0deg); }
				1% { transform: translate(-1px, -2px) rotate(-1deg); }
				2% { transform: translate(-3px, 0px) rotate(1deg); }
				3% { transform: translate(3px, 2px) rotate(0deg); }
				4% { transform: translate(1px, -1px) rotate(1deg); }
				5% { transform: translate(-1px, 2px) rotate(-1deg); }
				6% { transform: translate(-3px, 1px) rotate(0deg); }
				7% { transform: translate(3px, 1px) rotate(-1deg); }
				8% { transform: translate(-1px, -1px) rotate(1deg); }
				9% { transform: translate(1px, 2px) rotate(0deg); }
				10% { transform: translate(1px, -2px) rotate(-1deg); }
				11% { transform: translate(0, 0) rotate(0); }
				100% { transform: translate(0, 0) rotate(0); }
			}
		');
        
        $html = '';
        
        $html .= '<hr  class="mt-0" />';
        
        $html .= '<div class="'.$row_class.'">';
        
        $html .= '<div class="'.$col_class.'">';
        
        $html .= '<div id="digigreg_donation" class="'.$card_class.'">';
        
        $html .= '<div id="digigreg_donation_text" class="'.$card_body_class.'">';
        
        $html .= '<h2 class="'.$card_title_class.' text-light">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_DONATION_TITLE')).'</h2>';
        
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_('MOD_DIGI_SHOWCASE_DONATION_DESC').'<br /><small><i class="text-dark">'.JText::_('MOD_DIGI_SHOWCASE_DONATION_SIGN').'</i></small>'.'</p>';
        $html .= '<p class="'.$card_text_class.' '.$bg_success_class.' text-light rounded p-3">';
        $html .= '<span class="text-uppercase">'.JText::_('BTC_ADDRESS').'</span> <br />'.$btc_address.' <br /><br />';
        $html .= '<span class="text-uppercase">'.JText::_('ETH_ADDRESS').'</span> <br />'.$eth_address.' <br /><br />';
        $html .= '<span class="text-uppercase">'.JText::_('PAYMENT_ADDRESSES').'</span> <br />';
        $html .= '<span class="btn-group btn-group-sm mt-1" role="group">';
        $html .= '<a class="btn btn-outline-light" target="_blank" href="'.$paypal_link.'"><img class="btn-img" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-paypal.png" alt="PayPal" />PayPal</a>';
        $html .= '<a class="btn btn-outline-light" target="_blank" href="'.$revolut_link.'"><img class="btn-img" src="'.URI::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'logo-revolut.png" alt="Revolut" />Revolut</a>';
        $html .= '</span>';
        $html .= '</p>';
        
		$html .= '</div>';
		
		$html .= '<svg class="pulse" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
				  </svg>';
		
		$html .= '</div>';
        
        $html .= '</div>';
        
        $html .= '<div class="'.$col_class.'">';
        
        $html .= '<div id="digigreg_adv" class="'.$card_class.'">';
        
        $html .= '<div id="digigreg_adv_text" class="'.$card_body_class.'">';
        
        $html .= '<h2 class="'.$card_title_class.' text-light">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_TITLE')).'</h2>';
        
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_('MOD_DIGI_SHOWCASE_ADV_DESC').'</p>';
        
		$html .= '<p class="'.$card_text_class.' bg-warning text-dark rounded p-3">';
        $html .= '<span class="text-uppercase">'.JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_ASK_QUESTION_BEFORE_TO_BUY').'</span> <br />';
        $html .= '<a class="btn '.$btn_dark_class.' btn-sm mt-1" href="'.$support_question_link.'" target="_blank">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_ASK_QUESTION')).'</a> <br /><br />';
        $html .= '<span class="text-uppercase">'.JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_BUY_HOURS').'</span> <br />';
        $html .= '<span class="btn-group btn-group-sm mt-1" role="group">';
        $html .= '<a class="btn '.$btn_dark_class.'" target="_blank" href="'.$support_one_hour_link .'">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_ONE_HOUR')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.'" target="_blank" href="'.$support_two_hours_link .'">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_TWO_HOURS')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.'" target="_blank" href="'.$support_three_hours_link .'">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_THREE_HOURS')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.'" target="_blank" href="'.$support_five_hours_link .'">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_FIVE_HOURS')).'</a>';
        $html .= '<a class="btn '.$btn_dark_class.'" target="_blank" href="'.$support_ten_hours_link .'">'.strToUpper(JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_TEN_HOURS')).'</a>';
        $html .= '</span> <br /><br />';
        $html .= '<span class="text-uppercase">'.JText::_('MOD_DIGI_SHOWCASE_ADV_SUPPORT_WORKING_HOURS').'</span>';
        $html .= '</p>';
		
		$html .= '</div>';
		
		$html .= '</div>';
        
        $html .= '</div>';
        
        $html .= '</div>';
        
        return $html;
        
    }
}

?>