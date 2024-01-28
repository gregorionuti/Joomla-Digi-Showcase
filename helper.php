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

// include other files with the right path depending if this helper is an override or it's the default one
if (file_exists(dirname(__DIR__, 1).DS.'override'.DS.'helper.php')) {
	// avoid redeclaration of simple html dom if it's declared in another joomla extension
	if (!function_exists('str_get_html')) {
		require_once dirname(__DIR__, 1).DS.'include'.DS.'simple_html_dom.php';
	}
	require_once dirname(__DIR__, 1).DS.'include'.DS.'image_resizer.php';
	include_once dirname(__DIR__, 1).DS.'administrator'.DS.'elements'.DS.'digigreg_api.php';
} else {
	if (!function_exists('str_get_html')) {
		require_once dirname(__FILE__).DS.'include'.DS.'simple_html_dom.php';
	}
	require_once dirname(__FILE__).DS.'include'.DS.'image_resizer.php';
	include_once dirname(__FILE__).DS.'administrator'.DS.'elements'.DS.'digigreg_api.php';
}

class Digi_Showcase_Helper {
    
    private $dataSource;
	private $dataFilter;
	private $rows;
	private $columns;
	private $itemsQty;
	private $mode;
	private $orderBy;
	private $orderType;
	private $showImage;
	private $generateThumbnail;
	private $imageWidth;
	private $imageHeight;
	private $showTitle;
	private $titleCharacters;
	private $showDescription;
	private $descriptionCharacters;
	private $stripHtmlText;
	private $showExtraInfo;
	private $showFeaturedItems;
	private $showExpiredItems;
	private $itemsTimeCorrection;
	private $itemsOffse;
	private $items;
	
	// construct
	public function __construct($dataSource=0, $dataFilter=0, $rows=1, $columns=1, 
								$itemsQty, $mode, $orderBy, $orderType, 
								$showImage, $generateThumbnail, $imageWidth, $imageHeight, 
								$showTitle, $titleCharacters, 
								$showDescription, $descriptionCharacters, $stripHtmlText, 
								$showExtraInfo, 
								$showFeaturedItems, $showExpiredItems, $itemsTimeCorrection, $itemsOffset) {
								
            $this->data_source = $dataSource;
            $this->data_filter = $dataFilter;
            $this->rows = $rows;
            $this->columns = $columns;
            $this->items_qty = $itemsQty;
            $this->mode = $mode;
            $this->order_by = $orderBy;
            $this->order_type = $orderType;
            $this->show_image = $showImage;
            $this->generate_thumbnail = $generateThumbnail;
            $this->image_width = $imageWidth;
            $this->image_height = $imageHeight;
            $this->show_title = $showTitle;
            $this->title_characters = $titleCharacters;
            $this->show_description = $showDescription;
            $this->description_characters = $descriptionCharacters;
            $this->strip_html_text = $stripHtmlText;
            $this->show_extra_info = $showExtraInfo;
            $this->show_featured_items = $showFeaturedItems;
            $this->show_expired_items = $showExpiredItems;
            $this->items_time_correction = $itemsTimeCorrection;
            $this->items_offset = $itemsOffset;
            $this->items = array();
    }
    
    
/**
 * 
 * functions to get item attributes
 * 
 */
	
	// get item image
	public static function getImage($imageArray,$item) {
		
		// get variables from image array
		$show = $imageArray['show'];
		$type = $imageArray['type'];
		$placeholder = $imageArray['placeholder'];
		$placeholderImage = $imageArray['placeholder-image'];
		$thumbnail = $imageArray['thumbnail'];
		$width = $imageArray['width'];
		$height = $imageArray['height'];
		
		$image = '';
		
		if ($show) {
			
			if ($placeholderImage) {
				$placeholderPath = Uri::root().$placeholderImage;
			} else {
				$placeholderPath = Uri::root().'modules'.DS.'mod_digi_showcase'.DS.'assets'.DS.'images'.DS.'no-image.png';
			}
		
			if (trim($item['intro-image']) != '' && $type == 0) {
				// return intro item image
				$image = $item['intro-image'];
			} else if (trim($item['full-image']) != '' && $type == 2) {
				// return full item image
				$image = $item['full-image'];
			} else if ($type == 3) {
				// return an image depending which is available
				if (trim($item['image']) != '') {
					$image = $item['image'];
				} else if (trim($item['intro-image']) != '') {
					$image = $item['intro-image'];
				} else if (trim($item['full-image']) != '') {
					$image = $item['full-image'];
				} else if ($placeholder == 1) {
					$image = $placeholderPath;
				}
			} else if (trim($item['image']) != '' && $type == 1) {
				// return the first image in the content
				$image = $item['image'];
			} else if ($placeholder == 1) {
				// return the placeholder
				$image = $placeholderPath;
			}
		}
		
		return $image;
	}
	
	// get item background
	public static function getBackground($backgroundArray,$image) {

		// get variables from background array
		$background = $backgroundArray['background'];
		$backgroundType = $backgroundArray['background-type'];
		$backgroundColor = $backgroundArray['background-color'];
		$backgroundImage = $backgroundArray['background-image'];
		$backgroundImageType = $backgroundArray['background-image-type'];
		
		if ($background == 1) {
			if ($backgroundType == 1) {
				if ($backgroundImageType == 0) {
					$itemBackground = 'background-image: url('.$backgroundImage.');';
				} else if ($image && $backgroundImageType == 1) {
					$itemBackground = 'background-image: url('.$image.');';
				}
			} else {
				$itemBackground = 'background-color: '.$backgroundColor.';';
			}
		} else {
			$itemBackground = '';
		}
	
		return $itemBackground;
	}
	
	// get item link
	public static function getLink($linkArray,$item) {
		
		// get variables from link array
		$linkAlias = $linkArray['link-alias'];
		$linkCategory = $linkArray['link-category'];
		$linkItem = $linkArray['link-item'];
		$forcedLinkMenuItemSwitch = $linkArray['forced-link-item-switch'];
		$forcedLinkMenuItem = $linkArray['forced-link-item'];
		$source = $linkArray['source'];
		$plugin = $linkArray['plugin'];
		
		// get variables from item
		$itemLink = $item['link'];
		$itemId = $item['id'];
		$itemAlias = $item['alias'];
		$categoryId = $item['categoryid'];
		$menuId = $item['itemid'];
		
		// build link based on module settings
		if ($source == 0 || $source == 1 || $source == 2) {
			// data source is com_content
			$link = $itemLink.'&id='.$itemId;
			$link .= $linkAlias == 1 ? ':'.$itemAlias : '';
			$link .= $linkCategory == 1 ? '&catid='.$categoryId : '';
			if ($forcedLinkMenuItemSwitch == 1) {
				// if assigned print forced menu item in the url
				$link .= $linkItem == 1 ? '&Itemid='.$forcedLinkMenuItem : '';
			} else if ($forcedLinkMenuItemSwitch == 0 && !empty($menuId)) {
				// check if the article has an item id assigned and try to give the proper one to the link
				$link .= $linkItem == 1 ? '&Itemid='.$menuId : '';
			}
		} else if ($source == 50) {
			// data source is custom csv
			$link = $itemLink;
		} else if ($source == 99) {
			// load expansion pack
			
			// include plugin file
			require_once JPATH_ROOT.DS.'plugins'.DS.'digishowcase'.DS.$plugin.DS.$plugin.'.php';
			
			// get plugin class name
			$pluginClass = 'plgDigishowcase'.ucfirst($plugin);
			
			$link = $pluginClass::getItemLink($item,$linkArray);
		}
	
		return JRoute::_($link);
	}


/**
 * 
 * functions to generate html code
 * 
 */
	
	// generate html code of text
	public static function getTextHTML($position,$dataArray,$linkArray,$tagsArray) {
	
		$showTitle = $dataArray['show-title'];
		$showDesc = $dataArray['show-desc'];
		$showCategory = $dataArray['show-category'];
		$showExtraInfo = $dataArray['show-extra-info'];
		$showReadMore = $dataArray['show-read-more'];
		$readMoreText = $dataArray['read-more-text'];
		$readMoreStyle = $dataArray['read-more-style'];
		$readMoreClass = $dataArray['read-more-class'];
		$titlePos = $dataArray['title-position'];
		$categoryPos = $dataArray['category-position'];
		$descPos = $dataArray['desc-position'];
		$extraInfoPos = $dataArray['extra-info-position'];
		$titleAlign = $dataArray['title-alignment'];
		$descAlign = $dataArray['desc-alignment'];
		$categoryAlign = $dataArray['category-alignment'];
		$extraInfoAlign = $dataArray['extra-info-alignment'];
		$title = $dataArray['title'];
		$category = $dataArray['category'];
		$text = $dataArray['content'];
		$extraInfo = $dataArray['extra-info'];
		$showModuleTitleInside = $dataArray['show-module-title-inside'];
		$moduleTitle = $dataArray['module-title'];
		$linkSwitch = $linkArray['link-switch'];
		$link = $linkArray['link'];
		$moduleTitleTag = $tagsArray['module-title-tag'];
		$titleTag = $tagsArray['title-tag'];
		$descTag = $tagsArray['desc-tag'];
		$categoryTag = $tagsArray['category-tag'];
		$extraInfoTag = $tagsArray['extra-info-tag'];
		
		$html = '';
		
		if ($showTitle == 1 || $showDesc == 1 || $showCategory == 1 || $showExtraInfo == 1 || $showModuleTitleInside == 1) {
			
			// module title
			if ($showModuleTitleInside == 1 && $position == 0) {
				$html .= '<'.$moduleTitleTag.' class="module-title">';
				$html .= $moduleTitle;
				$html .= '</'.$moduleTitleTag.'>';
			}
			
			// title
			if ($showTitle == 1 && $titlePos == $position) {
				$html .= '<'.$titleTag.' class="title'.$titleAlign.'">';
				if ($linkSwitch == 1) {
					$html .= '<a href="'.$link.'" title="'.$title.'">';
				}
				$html .= $title;
				if ($linkSwitch == 1) {
					$html .= '</a>';
				}
				$html .= '</'.$titleTag.'>';
			}
			
			// description
			if ($showDesc == 1 && $descPos == $position) {
				$html .= '<'.$descTag.' class="text'.$descAlign.'">';
				if ($linkSwitch == 1) {
					$html .= '<a href="'.$link.'" title="'.$title.'">';
				}
				$html .= $text;
				if ($linkSwitch == 1) {
					$html .= '</a>';
				}
				$html .= '</'.$descTag.'>';
				
				// read more
				if ($linkSwitch == 1 && $showReadMore == 1) {
					$html .= '<div class="readmore-wrapper'.$descAlign.'">';
					if ($readMoreStyle == 1 && !($readMoreClass)) {
						$readMoreClass = 'readmore-default';
					} else if ($readMoreStyle == 0) {
						$readMoreClass = 'readmore-default';
					}
					$html .= '<a class="readmore '.$readMoreClass.'" href="'.$link.'" title="'.$title.'">';
					$html .= $readMoreText;
					$html .= '</a>';
					$html .= '</div>';
				}
			}
			
			// category
			if ($showCategory == 1 && $categoryPos == $position) {
				$html .= '<'.$categoryTag.' class="category'.$categoryAlign.'">';
				$html .= $category;
				$html .= '</'.$categoryTag.'>';
			}
			
			// extra info
			if ($showExtraInfo == 1 && $extraInfoPos == $position) {
				$html .= '<'.$extraInfoTag.' class="extra-info'.$extraInfoAlign.'">';
				
				// chech if extra info is a date
				if (DateTime::createFromFormat('Y-m-d G:i:s', $extraInfo) !== false) {
					
					// format the date
					$html .= date('d-m-Y', strtotime($extraInfo));
				} else {
					$html .= $extraInfo;
				}
				$html .= '</'.$extraInfoTag.'>';
			}
			
		}
		
		return $html;
	}
	
	// generate html code of image
	public static function getImageHTML($image,$dataArray,$linkArray,$mode) {
		
		$title = $dataArray['title'];
		$linkSwitch = $linkArray['link-switch'];
		$link = $linkArray['link'];
		
		$html = '';
		
		if ($image) {
			
			if ($mode == 4) {
				// masonry mode
				$html .= '<div class="image" style="background-image: url('.$image.');"></div>';
			} else {
				// normal mode, carousel mode, timeline mode, tag cloud mode
				$html .= '<p class="image">';
				if ($linkSwitch == 1) {
					$html .= '<a href="'.$link.'" title="'.$title.'">';
				}
				$html .= '<img src="'.$image.'" alt="'.$title.'">';
				if ($linkSwitch == 1) {
					$html .= '</a>';
				}
				$html .= '</p>';
			}
			
		}
				
		return $html;
	}
	
	// generate html code of filter
	public static function getFilterHTML($filterArray) {
		
		$show = $filterArray['filter'];
		$source = $filterArray['source'];
		$data = $filterArray['data'];
		$raw = $filterArray['raw'];
		$plugin = $filterArray['plugin'];
		$keyword = $filterArray['keyword'];
		$group = $filterArray['group'];
		$class = "nav nav-pills";
		$justify = $filterArray['justify'];
		
		if ($justify == '1') {
			$class = "nav nav-pills nav-fill nav-justified mx-0";
		}
		
		$html = '';
		
		if ($show) {
			
			$html .= '<ul id="digi_showcase_filter" class="'.$class.'">';
	
			$html .= '<li class="nav-item active '.$keyword.'-all"><a class="nav-link" href="#" title="'.$keyword.'-all">'.jText::_('MOD_DIGI_SHOWCASE_FIELD_FILTER_ALL_LABEL').'</a></li>';
	
			if ($data) {
				
				// declare an array to avoid duplicates
				$filtersArray = [];
				
				foreach($data As $filter) {
					
					if ($filter || $filter == 0) {
					
						$push = 0;
					
						if ($source == 0) {
							// data source is joomla categories
							$filterTitle = Digi_Showcase_Helper::getJoomlaCategoryTitle($filter,0);
						} else if ($source == 1) {
							// data source is joomla tags
							$filterTitle = Digi_Showcase_Helper::getJoomlaTagTitle($filter);
						} else if ($source == 2) {
							// data source is joomla articles
							if ($group) {
								$filterTitle = Digi_Showcase_Helper::getJoomlaCategoryTitle($filter,1);
								$filter = str_replace(' ', '-', strtolower($filterTitle));
								$push = 1;
							} else {
								$filterTitle = Digi_Showcase_Helper::getJoomlaArticleTitle($filter);
							}
						} else if ($source == 50) {
							// data source is custom csv
							if ($group) {
								$filterTitle = Digi_Showcase_Helper::getCustomCSVCategory($filter,$raw);
								$filter = str_replace(' ', '-', strtolower($filterTitle));
								$push = 1;
							} else {
								$filterTitle = Digi_Showcase_Helper::getCustomCSVTitle($filter,$raw);
							}
						} else if ($source == 99) {
							// load external plugins
							
							// include plugin file
							require_once JPATH_ROOT.DS.'plugins'.DS.'digishowcase'.DS.$plugin.DS.$plugin.'.php';
							
							// get plugin class name
							$pluginClass = 'plgDigishowcase'.ucfirst($plugin);
							
							if ($group) {
								$filterTitle = $pluginClass::getGroupTitle($filter);
								$filter = str_replace(' ', '-', strtolower($filterTitle));
								$push = 1;
							} else {
								$filterTitle = $pluginClass::getItemTitle($filter);
							}
						}
						
						// print the filter if is not already printed in previous cycles
						if ($group && !in_array($filterTitle,$filtersArray) || !$group) {
							$html .= '<li class="nav-item '.$keyword.'-'.$filter.'"><a class="nav-link" href="#" title="'.$keyword.'-'.$filter.'">'.$filterTitle.'</a></li>';
						}
						
						// push the filter in the array to avoid duplicates on the next cycle
						if ($push == 1) {
							array_push($filtersArray, $filterTitle);
						}
						
					}
				}
				
			}
			
			$html .= '</ul>';

			$html .= '<div class="clearfix"></div>';
		
		}
		
		return $html;
	}


/**
 * 
 * functions to generate javascript code
 * 
 */
	
	// generate javascript code of filter
	public static function getFilterJS($filterArray) {
		
		$show = $filterArray['filter'];
		$id = $filterArray['module-id'];
		$keyword = $filterArray['keyword'];
		$alignment = $filterArray['alignment'];
		$justify = $filterArray['justify'];
		$mode = $filterArray['mode'];
		$jQuery = $filterArray['jquery'];
		
		$js = '';
		
		if ($show) {
			
			if ($mode != 1) {
				
				$js .= $jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("a:not([title='.$keyword.'-all])").each(function(){
						
						// hide or show items by filters
						'.$jQuery.'(this).click(function(e) {
							e.preventDefault();
				
							// manage nav pill class
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("li").removeClass("active");
							'.$jQuery.'(this).parent().addClass("active");
				
							// define category id got from title attribute of anchor
							var categoryId = '.$jQuery.'(this).attr("title");
				
							// hide all items of different categories than the selected one
							'.$jQuery.'("#digi_showcase_'.$id.'").find(".showcase-item").each(function(){
								if ('.$jQuery.'(this).hasClass(categoryId)) {
									'.$jQuery.'(this).animate({"opacity" : 1}, 500, "swing", function () {
										'.$jQuery.'(this).slideDown("500");
									});
								} else {
									'.$jQuery.'(this).animate({"opacity" : 0}, 500, "swing", function () {
										'.$jQuery.'(this).slideUp("500");
									});
								}
							});
				
						});
				});';
		
				$js .= $jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("a[title='.$keyword.'-all]").each(function(){
						
						// show all items removing active filter
						'.$jQuery.'(this).click(function(e) {
							e.preventDefault();
				
							// manage nav pill class
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("li").removeClass("active");
							'.$jQuery.'(this).parent().addClass("active");
				
							// restore all items visible
							'.$jQuery.'("#digi_showcase_'.$id.'").find(".showcase-item").each(function(){
								'.$jQuery.'(this).animate({"opacity" : 1}, 500, "swing", function () {
									'.$jQuery.'(this).slideDown("500");
								});
							});
				
						});
				});';
			
			} else if ($mode == 1) {
				
				$js .= 'var carouselFilter = 0;';
				
				$js .= $jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("a:not([title='.$keyword.'-all])").each(function(){
						
						// hide or show items by filters
						'.$jQuery.'(this).click(function(e) {
							e.preventDefault();
							
							if (carouselFilter == 1) {
								// restore all items visible
								'.$jQuery.'("#digi_showcase_'.$id.'").find("#digi_showcase_carousel").slick("slickUnfilter");
							}
							
							carouselFilter = 1;
							
							// manage nav pill class
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("li").removeClass("active");
							'.$jQuery.'(this).parent().addClass("active");
							
							// define category id got from title attribute of anchor
							var categoryId = '.$jQuery.'(this).attr("title");
							
							// hide all items of different categories than the selected one
							'.$jQuery.'("#digi_showcase_'.$id.'").find("#digi_showcase_carousel").slick("slickFilter","." + categoryId);
							
						});
				});';
				
				$js .= $jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("a[title='.$keyword.'-all]").each(function(){
						
						// show all items removing active filter
						'.$jQuery.'(this).click(function(e) {
							e.preventDefault();
							
							carouselFilter = 0;
							
							// manage nav pill class
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("li").removeClass("active");
							'.$jQuery.'(this).parent().addClass("active");
							
							// show all filter buttons
							//'.$jQuery.'(this).parent().parent().children("li").children("a").fadeIn();
							
							// restore all items visible
							'.$jQuery.'("#digi_showcase_'.$id.'").find("#digi_showcase_carousel").slick("slickUnfilter");
							
						});
				});';
				
			}
		
			$js .= '// give the correct position to filters
					filterAlignment = '.$alignment.';
					filterJustify = '.$justify.';
					if (filterJustify != 1) {
						if (filterAlignment == 1 && ('.$jQuery.'(window).width() >= 769)) {
							// if window width is less than 769px do not apply the position because bootstrap nav-pills on mobile will look ugly
							containerWidth = '.$jQuery.'("#digi_showcase_'.$id.'").width();
							filtersWidth = 0;
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").find("a").each(function(){
								filtersWidth = filtersWidth + '.$jQuery.'(this).outerWidth(true);
							});
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").css("margin-left",(containerWidth / 2) - (filtersWidth / 2));
						} else if (filterAlignment == 0) {
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").addClass("float-start");
						} else if (filterAlignment == 2) {
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").addClass("float-end");
						} else if ('.$jQuery.'(window).width() <= 768) {
							'.$jQuery.'("#digi_showcase_'.$id.' #digi_showcase_filter").addClass("nav-stacked");
						}
					}';
		
		}
		
		return $js;
	}


/**
 * 
 * functions to generate css code
 * 
 */
	
	// generate css code of filter
	public static function getFilterCSS($filterArray) {
		
		$show = $filterArray['filter'];
		$id = $filterArray['module-id'];
		$color = $filterArray['color'];
		$hoverColor = $filterArray['hover-color'];
		$backgroundColor = $filterArray['background-color'];
		$backgroundHoverColor = $filterArray['background-hover-color'];
	
		$css = '';
		
		if ($show) {
		
			$css .= '#digi_showcase_'.$id.' .nav-pills > li > a:hover,
					#digi_showcase_'.$id.' .nav-pills > li > a:focus,
					#digi_showcase_'.$id.' .nav-pills > .active > a,
					#digi_showcase_'.$id.' .nav-pills > .active > a:hover,
					#digi_showcase_'.$id.' .nav-pills > .active > a:focus {
						color: '.$hoverColor.';
						background-color: '.$backgroundHoverColor.';
					}
					#digi_showcase_'.$id.' .nav-pills > li > a {
						color: '.$color.';
						background-color: '.$backgroundColor.';
					}';
		
		}
		
		return $css;
	}
	
	
/**
 * 
 * functions to get item data
 * 
 */
	
	// get article data from article
	private function getArticleData($article) {
        
        $articleId = $article['id'];
        $itemId = '';
        $title = $article['title'];
        $category = Digi_Showcase_Helper::getJoomlaCategoryTitle($article['catid'],0);
        $categoryId = $article['catid'];
        $articleAlias = $article['alias'];
        $itemAlias = '';
        $content = $article['introtext'];
        $extraInfo = $article['created'];
        $articleImages = $article['images'];
        $imagesData = json_decode($articleImages);
        $introImage = $imagesData->image_intro;
        $fullImage = $imagesData->image_fulltext;
        $image = '';
        $generateThumbnail = $this->generate_thumbnail;
        
        // if exist get the associated item id to build the correct link
        $dbo = JFactory::getDBO();
        $query = $dbo->getQuery(true);
        $query->SELECT('menu.id AS id,menu.alias AS alias,menu.link AS link');
        $query->FROM('#__menu AS menu');
        $query->GROUP('menu.id,menu.alias,menu.link');
        $dbo->setQuery($query);
        $results = $dbo->loadAssocList();
        
        foreach ($results as &$result) {
            // if current article is associated with a single article menu voice
            if (strpos($result['link'], 'view=article&id='.$articleId) !== false) {
                $itemId = $result['id'];
                $itemAlias = $result['alias'];
                break;
            }
        }
        if ($itemId == '') {
            foreach ($results as &$result) {
                // if current article is associated with a blog category menu voice
                if (strpos($result['link'], 'view=category&layout=blog&id='.$categoryId) !== false) {
                    $itemId = $result['id'];
                    $itemAlias = $result['alias'];
                    break;
                }
            }
        }
        if ($itemId == '') {
            foreach ($results as &$result) {
                // if current article is associated with a list category menu voice
                if (strpos($result['link'], 'view=category&id='.$categoryId) !== false) {
                    $itemId = $result['id'];
                    $itemAlias = $result['alias'];
                     break;
                }
            }
        }
        
        // if exist find the first image inside the article
		if(trim($content)!='') {
			$html_obj = str_get_html ( $content );
			$images = $html_obj->find('img');
			
			// if exist create thumbnail of the first image inside the article
			if(!empty($images)) {
				if ($generateThumbnail == 1) {
					$image_fullpath = JPATH_BASE.DS.$images[0]->attr['src'];
					$image = $this->getResizedImage($articleId, $image_fullpath, $this->image_width, $this->image_height);
				} else {
					$image = $images[0]->attr['src'];
				}
			}
		}
        
    	// if exist create thumbnail of intro image
        if ($generateThumbnail == 1) {
			if(!empty($introImage)) {
				$image_fullpath = JPATH_BASE.DS.$introImage;
				$introImage = $this->getResizedImage($articleId, $image_fullpath, $this->image_width, $this->image_height);
			}
        }
        
        // if exist create thumbnail of full image
    	if ($generateThumbnail == 1) {
			if(!empty($fullImage)) {
				$image_fullpath = JPATH_BASE.DS.$fullImage;
				$fullImage = $this->getResizedImage($articleId, $image_fullpath, $this->image_width, $this->image_height);
			}
        }
        
        // if exist get associated tags
        $dbo = JFactory::getDBO();
        $query = $dbo->getQuery(true);
        $query->SELECT('map.tag_id AS tagid');
        $query->FROM('#__contentitem_tag_map AS map');
        $query->WHERE('map.content_item_id = '.$articleId);
        $dbo->setQuery($query);
        $results = $dbo->loadAssocList();
        $tagsId = $results;
        
        // build article array which contain all parsed data
        $data = array(
	                'id'=>$articleId,
                    'itemid'=>$itemId,
                    'title'=>$this->truncateSentence($title, $this->title_characters, 0),
                    'categoryid'=>$categoryId,
                    'category'=>$category,
                    'tagsid'=>$tagsId,
                    'alias'=>$articleAlias,
                    'itemalias'=>$itemAlias,
                    'content'=>$this->truncateSentence($content, $this->description_characters, $this->strip_html_text),
                    'extra-info'=>$extraInfo,
                    'intro-image'=>$introImage,
                    'full-image'=>$fullImage,
                    'image'=>$image,
                    'link'=>'index.php?option=com_content&view=article'
                    );
        
        return $data;
	}
	
	// get items data from csv
	private function getCSVData($item) {
		
		// get csv data
        $id = $item['id'];
        $title = $item['title'];
        $category = $item['category'];
        $content = $item['content'];
        $image = $item['image'];
        $extraInfo = $item['extra-info'];
        $link = $item['link'];
        $generateThumbnail = $this->generate_thumbnail;
        $imageWidth = $this->image_width;
        $imageHeight = $this->image_height;
		
		// if exist create thumbnail of image
    	if ($generateThumbnail == 1) {
			if(!empty($image)) {
				$image = $this->getResizedImage($id, $image, $imageWidth, $imageHeight);
			}
        }
		
		// build the item array which contain all parsed data
        $data = array(
                'id'=>$id,
                'title'=>$this->truncateSentence($title, $this->title_characters, 0),
                'category'=>$category,
                'content'=>$this->truncateSentence($content, $this->description_characters, $this->strip_html_text),
                'extra-info'=>$extraInfo,
                'image'=>$image,
                'link'=>trim(str_replace(PHP_EOL, '', $link))
                );
        
        return $data;
	}
	
	
/**
 * 
 * functions to get items
 * 
 */
    
    // get joomla articles
	public function getJoomlaArticles() {
		
		$currentLang = JFactory::getLanguage();
        $lang = $currentLang->getTag();
        $dbo = JFactory::getDBO();
		$dataSource = $this->data_source;
		$itemsQty = $this->items_qty;
		$mode = $this->mode;
		$showExpiredItems = $this->show_expired_items;
		$showFeaturedItems = $this->show_featured_items;
		$itemsOffset = $this->items_offset;
		$itemsTimeCorrection = $this->items_time_correction;
		
		// define current date and time
		$now = date('Y-m-d H:i:s', strtotime($itemsTimeCorrection.' hour'));
		
		// select all articles without filters
		$query = sprintf("SELECT co.* FROM `#__content` co ");
		
		// manage data source variables and queries
		if ($dataSource == 0) {
			// data source is joomla categories
			
			// split categories array
			$showCatRoot = 0;
			$catFilter = 'ca.id = %d';
			$catsIDs = $this->data_filter;
			if ($catsIDs && is_array($catsIDs)) {
				for ($i = 0; $i < count($catsIDs); ++$i) {
					if ($catsIDs[$i] != 0) {
						$catFilter .= ' OR ca.id = '.$catsIDs[$i];
					} else {
						$showCatRoot = 1;
					}
				}
			} else {
				$showCatRoot = 1;
			}
			
			// join categories table
			if ($catsIDs) {
				$query .= "JOIN `#__categories` ca ON co.catid = ca.id WHERE co.state = 1 ";
			} else {
				$query .= "JOIN `#__categories` ca WHERE co.state = 1 ";
			}
			
			// apply filter by categories if root category is not selected
			if ($showCatRoot == 0) {
				$query .= "AND (".$catFilter.") ";
			}
		} else if ($dataSource == 1) {
			// data source is joomla tags
			
			// split tags array
			$tagFilter = 'ta.tag_id = %d';
			$tagsIDs = $this->data_filter;
			if ($tagsIDs) {
				for ($i = 0; $i < count($tagsIDs); ++$i) {
					$tagFilter .= ' OR ta.tag_id = '.$tagsIDs[$i];
				}
			}
			
			// join tags table
			if ($tagsIDs) {
				$query .= "INNER JOIN `#__contentitem_tag_map` ta ON co.id = ta.content_item_id WHERE co.state = 1 ";
				$query .= "AND (".$tagFilter.") AND ta.type_id = 1 ";
			} else {
				$query .= "INNER JOIN `#__contentitem_tag_map` ta WHERE co.state = 1 ";
				$query .= "AND (".$tagFilter.") AND ta.type_id = 1 ";
			}
		} else if ($dataSource == 2) {
			// data source is joomla articles
			
			// split articles array
			$articlesIDs = $this->data_filter;
			if ($articlesIDs) {
				$articleFilter = 'co.id =';
				for ($i = 0; $i < count($articlesIDs); ++$i) {
					$articleFilter .= ' '.$articlesIDs[$i];
					if ($i <= (count($articlesIDs) - 2)) {
						$articleFilter .= ' OR co.id =';
					}
				}
			} else {
				$articleFilter = 'co.id = 0';
			}
			
			$query .= "WHERE (".$articleFilter.") ";
		}
		
		// apply filter by date
		$query .= "AND (co.publish_up < '".$now."') ";
		
		// manage featured items
		if ($showFeaturedItems == 0) {
			$query .= "AND (co.featured = '0' OR co.featured IS NULL) ";
		} else if ($showFeaturedItems == 2) {
			$query .= "AND (co.featured = '1') ";
		}
		
		// manage expired items
		if ($showExpiredItems == 0) {
			$query .= "AND (co.publish_down > '".$now."' OR co.publish_down IS NULL) ";
		}
		
		// apply filter by language
		$query .= "AND (co.language='".$lang."' OR co.language='*') ";
		
		// group to avoid duplicate items
		$query .= "GROUP BY co.id";
		
		$query = sprintf($query, $this->data_filter);
            
        // define the correct limit
        if ($mode == 0) {
        	// normal mode
			$limit = ((int)$this->rows)*((int)$this->columns);
		} else {
			// other modes
			$limit = $itemsQty;
		}
		
		// define the offset
        $offset = $itemsOffset;
        
        // define items ordering
        if ($this->order_by != "rand()") {
        	$query .= sprintf(" ORDER BY co.%s %s LIMIT %d OFFSET %d", $this->order_by, $this->order_type, $limit, $offset);
        } else {
            $query .= sprintf(" ORDER BY %s %s LIMIT %d OFFSET %d", $this->order_by, $this->order_type, $limit, $offset);
        }
        
        // get items
        $dbo->setQuery($query);
        $dbo->execute($query);
        $results = $dbo->loadAssocList();
        
        if(!empty($results)) {
            foreach($results AS $result) {
                $this->items[] = $this->getArticleData($result);
            }	
        }
        
        return $this->items;
	}
	
	// get custom csv
	public function getCustomCSV($items) {
		
		// define and manage the offset
		$offset = $this->items_offset;
		$itemsArray = explode(PHP_EOL, $items);
		$itemsArray = array_slice($itemsArray, $offset);
		$items = implode(PHP_EOL, $itemsArray);
		
		$item = explode(PHP_EOL, $items);
		
		if (is_array($item)) {
			
			$i = 0;
			$limit = $this->items_qty;
        	
			foreach ($item as $itemDataArr) {
				if ($i < $limit) {
					$itemData = explode(',', $itemDataArr);
				
					$itemArr = ['id'=>$i, 'title'=>$itemData[0], 'category'=>$itemData[1], 'content'=>$itemData[2], 'image'=>$itemData[3], 'extra-info'=>$itemData[4], 'link'=>$itemData[5]];
			
					$this->items[] = $this->getCSVData($itemArr);
				}
				$i++;
			}
			
			// define items ordering
			if ($this->order_by == 'created') {
				
				if ($this->order_type == 'desc') {
					// sort by extra-info descendant
					uasort($this->items, function($a, $b) {
						return strcmp($a['created'],$b['created']);
					});
				} else if ($this->order_type == 'asc') {
					// sort by extra-info ascendant
					uasort($this->items, function($a, $b) {
						return strcmp($b['created'],$a['created']);
					});
				}
				
			} else if ($this->order_by == 'title') {
				
				if ($this->order_type == 'desc') {
					// sort by title descendant
					uasort($this->items, function($a, $b) {
						return strnatcmp($a['title'],$b['title']);
					});
				} else if ($this->order_type == 'asc') {
					// sort by title ascendant
					uasort($this->items, function($a, $b) {
						return strnatcmp($b['title'],$a['title']);
					});
				}
				
			} else if ($this->order_by == 'ordering') {
				
				if ($this->order_type == 'asc') {
					// reverse the manual ordering
					uasort($this->items, function($a, $b) {
						return strnatcmp($b['id'],$a['id']);
					});
				}
				
			} else if ($this->order_by == 'rand()') {
				
				// shuffle randomly
				shuffle($this->items);
				
			}
			
		}
		
		return $this->items;
	}
	
	// manage expansion pack
	public function manageExpansionPack($plugin,$data) {
		
		if ($plugin && $data) {
			
			// include plugin file
			require_once JPATH_ROOT.DS.'plugins'.DS.'digishowcase'.DS.$plugin.DS.$plugin.'.php';
		
			// populate data array to send helper variables to plugin function
			$helperVars = ['source'=>$this->data_source,
						'mode'=>$this->mode,
						'qty'=>$this->items_qty,
						'rows'=>$this->rows,
						'columns'=>$this->columns,
						'order-by'=>$this->order_by,
						'order-type'=>$this->order_type,
						'show-featured'=>$this->show_featured_items,
						'show-expired'=>$this->show_expired_items,
						'time-correction'=>$this->items_time_correction,
						'offset'=>$this->items_offset,
						'title-characters'=>$this->title_characters,
						'desc-characters'=>$this->description_characters,
						'strip-html'=>$this->strip_html_text,
						'thumbnails'=>$this->generate_thumbnail,
						'image-width'=>$this->image_width,
						'image-height'=>$this->image_height];
		
			// get plugin class name
			$pluginClass = 'plgDigishowcase'.ucfirst($plugin);
		
			return $pluginClass::getItems($helperVars,$data);
			
		} else {
			
			return;
			
		}
	}
	
	
/**
 * 
 * extra functions
 * 
 */
	
	// get module params of current module istance from module id
	public static function getModuleParamsFromId($id) {
		
		// define database
		$dbo = JFactory::getDbo();
		
		// execute the query
		$query = $dbo->getQuery(true);
		$query->select('m.*');
		$query->from('#__modules AS m');
		$query->where('id = '.$id);
		$dbo->setQuery($query);
		
		$module = $dbo->loadObject();
		
		if ($module) {
			
			// get params
			$params = new JRegistry($module->params); 
		}
		
		return $params;
	}
	
	// get plugin params from plugin name
	public static function getPluginParamsFromName($name) {
		
		$plugin = JPluginHelper::getPlugin('digishowcase', $name);
		
		if ($plugin) {
		
			// get params
			$params = new JRegistry($plugin->params);
		} 
		
		return $params;
	}
	
	// create thumbnail of image
	protected static function getResizedImage($itemId, $image_fullpath, $imageWidth='120', $imageHeight='80') {
        $image_fullpath_arr = explode('#', $image_fullpath);
        if	($image_fullpath_arr[0]) {
        	$image_fullpath = $image_fullpath_arr[0];
        }
        $pathinfo = pathinfo($image_fullpath);
        $temp_imagepath = JPATH_BASE.DS.'modules'.DS.'mod_digi_showcase'.DS.'images'.DS.'temp_'.$itemId.'.'.$pathinfo['extension'];
        $dest_image = 'item_'.$itemId.'.'.$pathinfo['extension'];
        $dest_imagepath = JPATH_BASE.DS.'modules'.DS.'mod_digi_showcase'.DS.'images'.DS.$dest_image;
        
        list ($owid, $ohei) = getimagesize($image_fullpath);
        if($owid>$ohei) {
            $toheight = $imageHeight;
            $towidth = round(($owid*$imageHeight)/$ohei);
            if($towidth<$imageWidth) {
                $towidth = $imageWidth;
                $toheight = round(($ohei*$imageWidth)/$owid);
            }	
        } else {
            $towidth = $imageWidth;
            $toheight = round(($ohei*$imageWidth)/$owid);
            if($toheight<$imageHeight) {
                $toheight = $imageHeight;
                $towidth = round(($owid*$imageHeight)/$ohei);
            }
        }
        
        $imageResizer = new imageResizer();
        $imageResizer->scaleImage($image_fullpath, $temp_imagepath, $towidth, $toheight);
        $imageResizer->croppedCenterImage($temp_imagepath, $dest_imagepath, $imageWidth, $imageHeight);
        
        unlink($temp_imagepath);
        
        return Uri::root().'modules/mod_digi_showcase/images/'.$dest_image;
	}
	
	// truncate string after certain number of characters
	protected static function truncateSentence($sentence, $characters, $strip) {
		
		// strip all html tags
		if ($strip == 1) {
			$sentence = strip_tags($sentence);
		}
		
		// cut text to n characters
		$sentence_a = explode(' ', $sentence);
		$sentence_text = '';
		$i=0;
		while((strlen($sentence_text) < $characters) && ($i < (count($sentence_a)))) {
			$sentence_text .= ($i > 0) ? ' '.$sentence_a[$i]:$sentence_a[$i];
			$i++;
		}	

		if(trim($sentence_text) == '') {
			$sentence_text .= $sentence_a[0];
		}	
		
		if(strlen(trim($sentence_text))<strlen(trim($sentence))) {
			$sentence_text = trim($sentence_text)."&hellip;";
		}	
		
		return $sentence_text;
	}
	
	// explode csv
	public static function explodeCSV($csv) {
		
		$csv = explode(PHP_EOL, $csv);
		if (is_array($csv)) {
			$i = 0;
			foreach ($csv as $item) {
				$csvArr[] = $i;
				$i++;
			}
			$csv = $csvArr;
		} else {
			$csv = 0;
		}
		
		return $csv;
	}
	
	// convert hex color to rgb color
	public static function hexToRgb($color) {
		
		// remove #
		$color = ltrim($color, '#');
		
		// split the hex value
		$colorArray = str_split($color);
		
		// generate rgb value
		$color = hexdec($colorArray[0].$colorArray[1]).', '.hexdec($colorArray[2].$colorArray[3]).', '.hexdec($colorArray[4].$colorArray[5]).', ';
		
		return $color;
	}
	
	// get filter css class
	public static function getFilterClass($filterArray,$item) {
		
		$show = $filterArray['filter'];
		$source = $filterArray['source'];
		$data = $filterArray['data'];
		$plugin = $filterArray['plugin'];
		$id = $filterArray['module-id'];
		$keyword = $filterArray['keyword'];
		$group = $filterArray['group'];
		$alignment = $filterArray['alignment'];
		$color = $filterArray['color'];
		$hoverColor = $filterArray['hover-color'];
		$backgroundColor = $filterArray['background-color'];
		$backgroundHoverColor = $filterArray['background-hover-color'];
		
		if ($source == 0) {
			// data source is joomla categories
			$filterId = $item['categoryid'];
		} else if ($source == 1) {
			// data source is joomla tags
			$filterId = $item['tagsid'];
		} else if ($source == 2) {
			// data source is joomla articles
			if ($group) {
				$filterId = str_replace(' ', '-', strtolower($item['category']));
			} else {
				$filterId = $item['id'];
			}
		} else if ($source == 50) {
			// data source is custom csv
			if ($group) {
				$filterId = str_replace(' ', '-', strtolower($item['category']));
			} else {
				$filterId = $item['id'];
			}
		} else if ($source == 99) {
			// load expansion pack
			
			// include plugin file
			require_once JPATH_ROOT.DS.'plugins'.DS.'digishowcase'.DS.$plugin.DS.$plugin.'.php';
			
			// get plugin class name
			$pluginClass = 'plgDigishowcase'.ucfirst($plugin);
			
			$filterId = $pluginClass::getFilter($item,$group);
			
		}
		
		// define if to print one or more css classes depending is there are only one or more filters assigned to the item
		if (is_array($filterId)) {
			$filterClass = '';
			foreach ($filterId as $id) {
				$filterClass .= $keyword.'-'.array_shift($id).' ';
			}
		} else {
			$filterClass = $keyword.'-'.$filterId;
		}
		
		return $filterClass;
	}
	
	// get joomla category title
	public static function getJoomlaCategoryTitle($id,$titleSource) {
		
		$dbo = JFactory::getDBO();
		
		if (!$titleSource || $titleSource == 0) {
			// get title from category id
			$dbo->setQuery('SELECT cat.title FROM #__categories cat WHERE cat.id='.$id);  
		} else if ($titleSource == 1) {
			// get title from article id
			$dbo->setQuery('SELECT cat.title FROM #__categories cat JOIN #__content co ON cat.id=co.catid WHERE co.id='.$id);
		}
		
		$title = $dbo->loadResult();
		
    	return $title;
	}
	
	// get joomla tag title
	public static function getJoomlaTagTitle($id) {
		
		$dbo = JFactory::getDBO();
		
		$dbo->setQuery('SELECT tag.title FROM #__tags tag WHERE tag.id='.$id);  
		 
    	$title = $dbo->loadResult();
    	
    	return $title;
	}
	
	// get joomla article title
	public static function getJoomlaArticleTitle($id) {
		
		$dbo = JFactory::getDBO();
		
		$dbo->setQuery('SELECT article.title FROM #__content article WHERE article.id='.$id);  
			
    	$title = $dbo->loadResult();
    	
    	return $title;
	}
	
	// get title from custom csv
	public static function getCustomCSVTitle($item,$raw) {
    	
    	$dataArray = explode(',', $raw[$item]);
    	
    	return $dataArray[0];
	}
	
	// get category from custom csv
	public static function getCustomCSVCategory($item,$raw) {
    	
    	$dataArray = explode(',', $raw[$item]);
    	
    	return $dataArray[1];
	}

	// get text alignment
	public static function getTextAlignment($alignment) {
	
		// get alignment class
		if ($alignment == 0) {
			$alignment = ' text-left';
		} else if ($alignment == 1) {
			$alignment = ' text-center';
		} else if ($alignment == 2) {
			$alignment = ' text-right';
		}
	
		return $alignment;
	}
	
}

?>