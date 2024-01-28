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

jimport('joomla.form.formfield');

class JFormFieldTextareacsv extends JFormField {
    protected $type = 'Textareacsv';
    
    protected function getInput() {
    	
    	// include digigreg api
        include_once "digigreg_api.php";
        
    	// get extension general variables
    	$document = JFactory::getDocument();
    	$joomlaVersion = getJoomlaVersion();
    	
    	// specific classes and styles based on joomla version
    	if (version_compare($joomlaVersion, "4.0.0", ">=")) {
    		$row_class = 'row';
    		$col_class = 'col-12 col-md-6';
    		$card_class = 'card';
    		$badge_success_class = 'badge bg-success';
    		$badge_info_class = 'badge bg-info';
    		$badge_danger_class = 'badge bg-danger';
    		$badge_warning_class = 'badge bg-warning';
    		$bg_light_class = 'bg-light';
    	} else {
    		$row_class = 'row-fluid';
    		$col_class = 'span6';
    		$card_class = 'well';
    		$badge_success_class = 'label label-success';
    		$badge_info_class = 'label label-info';
    		$badge_danger_class = 'label label-important';
    		$badge_warning_class = 'label label-warning';
    		$bg_light_class = 'well';
    		
			$document->addStyleDeclaration('
				.card-body .label {
					margin-right: 3px;
				}
			');
    	}
    	
    	// add css style
		$document->addStyleDeclaration('
			.textarea-csv .badge {
				margin-bottom: 5px;
				margin-right: 5px;
				white-space: normal;
			}
			@media (max-width: 767px) {
				.textarea-csv .card {
					margin-top: 20px;
				}
			}
		');
    	
    	// add javascript code
    	$document->addScriptDeclaration('
			$j(document).ready(function(){
				
				$j(".textarea-csv").each(function() {
				
					var item_id = "#" + $j(this).attr("id");
					var target_id = "#" + $j(item_id).find("textarea").attr("id");
		
				
					$j(target_id).focus(function() {
						$j(item_id).children("div").children(".card").show();
						textareaBeautify();
					});
		
					$j(target_id).focusout(function() {
						$j(item_id).children("div").children(".card").hide();
					});
		
					$j(target_id).keyup(function() {
						textareaBeautify();
					});
		
					function textareaBeautify() {
						$j(item_id).children("div").children(".card").children(".card-body").html("");
						var content = $j(target_id).val();
						var valuesArray = $j(target_id).attr("values").split(",");
						var valuesNumber = valuesArray.length
						if (content) {
							var itemsArray = content.split("\n");
							$j.each(itemsArray,function(i) {
								$j(item_id).children("div").children(".card").children(".card-body").append("<span class=\"'.$badge_info_class.'\"> " + (i + 1) + " </span>");
								var dataArray = itemsArray[i].split(",");
								$j.each(dataArray,function(e) {
									if (e <= (valuesNumber - 1)) {
										if (dataArray[e]) {
											$j(item_id).children("div").children(".card").children(".card-body").append("<span class=\"'.$badge_success_class.'\"> " + valuesArray[e] + ": " + dataArray[e] + " </span>");
										} else {
											$j(item_id).children("div").children(".card").children(".card-body").append("<span class=\"'.$badge_warning_class.'\"> " + valuesArray[e] + ": missing </span>");
										}
									} else {
										if (dataArray[e]) {
											$j(item_id).children("div").children(".card").children(".card-body").append("<span class=\"'.$badge_danger_class.'\"> Unrecognized variable: " + dataArray[e] + " </span>");
										} else {
											$j(item_id).children("div").children(".card").children(".card-body").append("<span class=\"'.$badge_danger_class.'\"> Unneeded comma </span>");
										}
									}
								});
								$j(item_id).children("div").children(".card").children(".card-body").append("<hr />");
							});
						}
					}
		
				});
				
			});
		');
        
        // assign the default data
        $rows = $this->element['rows'];
        $cols = $this->element['cols'];
        $class = '';
        $values = $this->element['values'];
        
        // check if input has a class
        if ($this->element['class']) {
            
            // get input class
            $class .= $this->element['class'];
			
        }
        
        // generate input html
        $html = '';
        
        $html .= '<div id="'.$this->id.'_wrapper" class="'.$row_class.' textarea-csv">';
        
        $html .= '<div class="'.$col_class.'">';
        
        $html .= '<textarea name="'.$this->name.'" id="'.$this->id.'"
        '.($rows ? 'rows="'.$this->element['rows'].'"' : '').'
        '.($cols ? 'cols="'.$this->element['cols'].'"' : '').'
        '.($values ? 'values="'.$this->element['values'].'"' : '').'
        '.($class ? 'class="input-'.$this->element['class'].'"' : '').'
        >'. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
        
        $html .= '</div>';
        
        $html .= '<div class="'.$col_class.'">';
        $html .= '<div class="card '.$bg_light_class.' hide">';
        $html .= '<div class="card-body">';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        return $html;
    }
}

?>