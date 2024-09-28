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

// No direct access
defined('_JEXEC') or die;

// Define DS
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.form.formfield');

class JFormFieldDonation extends JFormField {
    protected $type = 'Donation';
    
    protected function getInput() {
		
		// Human defined variables
		/*
		$btc_address = "bc1qnuswkl7jhc2p8dm00ryqlu92ctgg58rzthquy6";
    	$eth_address = "0xBe43A9F77a80AA064FedAE5B427fd5b3077D2cc0";
    	*/
    	$paypal_link = 'https://www.paypal.com/paypalme/gregorionuti';
    	$revolut_link = 'https://revolut.me/gregorionuti';
    	$kofi_link = 'https://ko-fi.com/gregorionuti';
		$extension_family = 'modules';
        $extension_name = 'mod_digi_showcase';
        $text_prefix = 'MOD_DIGI_SHOWCASE';
		
    	// General variables
    	$document = JFactory::getDocument();
    	$joomlaVersion = JVERSION;
    	
    	// Specific classes and styles based on Joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class_12 = 'col-12 col-md-12';
    		$col_class_6 = 'col-12 col-md-6';
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
					#backup_form #digigreg_donation_text .row {
						margin: 0;
					}
				}
    		');
    	} else {
    		$row_class = 'row-fluid';
    		$col_class_12 = 'span12';
    		$col_class_6 = 'span6';
    		$card_class = 'well';
    		$card_title_class = 'title';
    		$card_body_class = 'well';
    		$card_text_class = 'text';
    		$bg_success_class = "alert alert-success";
    		$btn_dark_class = "btn-warning";
    		$document->addStyleDeclaration('
    			#digigreg_donation .well {
					margin: 0;
					background-color: rgba(255, 255, 255, 0.7);
				}
    			#digigreg_donation .well .btn-group,
    			#digigreg_donation .well .mt-1 {
					margin-top: 10px;
				}
				@media (max-width: 1300px) {
					#digigreg_donation .text {
						word-wrap: anywhere;
					}
				}
    		');
    	}
    	
    	// Add css style
		$document->addStyleDeclaration('
			#digigreg_donation {
				background-color: #00b16a;
				background-image: url("'.JURI::root().$extension_family.DS.$extension_name.DS.'assets'.DS.'images'.DS.'pattern-donation.png");
				background-repeat: repeat;
				position: relative;
				z-index: 0;
				overflow: hidden;
				animation: shake 5s;
				animation-iteration-count: infinite; 
			}
			#digigreg_donation:hover {
				animation: none;
			}
			#digigreg_donation a[target="_blank"]::before {
				content: "";
			}
			#digigreg_donation_text {
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
				margin-right: 5px;
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
    	
    	// Create the html
        $html = '';        
        $html .= '<div class="'.$row_class.'">';
        $html .= '<div class="'.$col_class_12.'">';
        $html .= '<div id="digigreg_donation" class="'.$card_class.'">';
        $html .= '<div id="digigreg_donation_text" class="'.$card_body_class.'">';
        $html .= '<h2 class="'.$card_title_class.' text-light">'.strToUpper(JText::_($text_prefix.'_DONATION_TITLE')).'</h2>';
        $html .= '<p class="'.$card_text_class.' bg-light text-dark rounded p-3">'.JText::_($text_prefix.'_DONATION_DESC').'<br /><small><i class="text-dark">'.JText::_($text_prefix.'_DONATION_SIGN').'</i></small>'.'</p>';
        $html .= '<div class="'.$card_text_class.' '.$bg_success_class.' text-light rounded p-3">';
        /*
        $html .= '<div class="'.$row_class.'">';
        $html .= '<div class="'.$col_class_6.'">';
        $html .= '<p><span class="text-uppercase">'.JText::_($text_prefix.'_BTC_ADDRESS').'</span> <br /><small class="crypto-wallet">'.$btc_address.'</small></p>';
        $html .= '</div>';
        $html .= '<div class="'.$col_class_6.'">';
        $html .= '<p><span class="text-uppercase">'.JText::_($text_prefix.'_ETH_ADDRESS').'</span> <br /><small class="crypto-wallet">'.$eth_address.'</small></p>';
        $html .= '</div>';
        $html .= '</div>';
        */
        $html .= '<span class="text-uppercase">'.JText::_($text_prefix.'_PAYMENT_ADDRESSES').'</span> <br />';
        $html .= '<span class="btn-group btn-group-sm mt-1" role="group">';
        $html .= '<a class="btn btn-outline-light" target="_blank" href="'.$paypal_link.'"><img class="btn-img" src="'.JURI::root().$extension_family.DS.$extension_name.DS.'assets'.DS.'images'.DS.'logo-paypal.png" alt="PayPal" />PayPal</a>';
        $html .= '<a class="btn btn-outline-light" target="_blank" href="'.$revolut_link.'"><img class="btn-img" src="'.JURI::root().$extension_family.DS.$extension_name.DS.'assets'.DS.'images'.DS.'logo-revolut.png" alt="Revolut" />Revolut</a>';
        $html .= '<a class="btn btn-outline-light" target="_blank" href="'.$kofi_link.'"><img class="btn-img" src="'.JURI::root().$extension_family.DS.$extension_name.DS.'assets'.DS.'images'.DS.'logo-ko-fi.png" alt="Ko-fi" />Ko-fi</a>';
        $html .= '</span>';
        $html .= '</div>';
		$html .= '</div>';
		$html .= '<svg class="pulse" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
					<circle id="Oval" cx="512" cy="512" r="512"></circle>
				  </svg>';
		$html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>