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

class imageResizer {

	function proportionalImage ($fileimg, $dest, $towidth, $toheight) {
		if (!file_exists($fileimg)) {
			return false;
		}
		if (empty($towidth) && empty($toheight)) {
			copy($fileimg, $dest);
			return true;
		}

		list ($owid, $ohei, $type) = getimagesize($fileimg);

		if ($owid > $towidth || $ohei > $toheight) {
			$xscale = $owid / $towidth;
			$yscale = $ohei / $toheight;
			if ($yscale > $xscale) {
				$new_width = round($owid * (1 / $yscale));
				$new_height = round($ohei * (1 / $yscale));
			} else {
				$new_width = round($owid * (1 / $xscale));
				$new_height = round($ohei * (1 / $xscale));
			}

			$imageresized = imagecreatetruecolor($new_width, $new_height);

			switch ($type) {
				case '1' :
					$imagetmp = imagecreatefromgif($fileimg);
					break;
				case '2' :
					$imagetmp = imagecreatefromjpeg($fileimg);
					break;
				default :
					$imagetmp = imagecreatefrompng($fileimg);
					break;
			}

			imagecopyresampled($imageresized, $imagetmp, 0, 0, 0, 0, $new_width, $new_height, $owid, $ohei);

			switch ($type) {
				case '1' :
					imagegif($imageresized, $dest);
					break;
				case '2' :
					imagejpeg($imageresized, $dest);
					break;
				default :
					imagepng($imageresized, $dest);
					break;
			}

			imagedestroy($imageresized);
			return true;
		} else {
			copy($fileimg, $dest);
		}
		return true;
	}

	function bandedImage ($fileimg, $dest, $towidth, $toheight, $rgb) {
		if (!file_exists($fileimg)) {
			return false;
		}
		if (empty($towidth) && empty($toheight)) {
			copy($fileimg, $dest);
			return true;
		}

		$exp=explode(",", $rgb);
		if (count($exp) == 3) {
			$r=trim($exp[0]);
			$g=trim($exp[1]);
			$b=trim($exp[2]);
		} else {
			$r=0;
			$g=0;
			$b=0;
		}

		list ($owid, $ohei, $type) = getimagesize($fileimg);

		if ($owid > $towidth || $ohei > $toheight) {
			$xscale = $owid / $towidth;
			$yscale = $ohei / $toheight;
			if ($yscale > $xscale) {
				$new_width = round($owid * (1 / $yscale));
				$new_height = round($ohei * (1 / $yscale));
				$ydest = 0;
				$diff = $towidth - $new_width;
				$xdest = ($diff > 0 ? round($diff / 2) : 0);
			} else {
				$new_width = round($owid * (1 / $xscale));
				$new_height = round($ohei * (1 / $xscale));
				$xdest = 0;
				$diff = $toheight - $new_height;
				$ydest = ($diff > 0 ? round($diff / 2) : 0);
			}

			$imageresized = imagecreatetruecolor($towidth, $toheight);

			$bgColor = imagecolorallocate($imageresized, (int)$r, (int)$g, (int)$b);
			imagefill($imageresized, 0, 0, $bgColor);

			switch ($type) {
				case '1' :
					$imagetmp = imagecreatefromgif($fileimg);
					break;
				case '2' :
					$imagetmp = imagecreatefromjpeg($fileimg);
					break;
				default :
					$imagetmp = imagecreatefrompng($fileimg);
					break;
			}

			imagecopyresampled($imageresized, $imagetmp, $xdest, $ydest, 0, 0, $new_width, $new_height, $owid, $ohei);

			switch ($type) {
				case '1' :
					imagegif($imageresized, $dest);
					break;
				case '2' :
					imagejpeg($imageresized, $dest);
					break;
				default :
					imagepng($imageresized, $dest);
					break;
			}

			imagedestroy($imageresized);

			return true;
		} else {
			copy($fileimg, $dest);
		}
		return true;
	}

	
	function scaleImage($fileimg, $dest, $dim_width, $dim_height){
		list($width, $height, $type, $attr) = getimagesize($fileimg);
		$thumb = imagecreatetruecolor($dim_width, $dim_height);
	
		// Salvo l'immagine ridimensionata
		switch($type) {
			case 1:{//gif
				$source = imagecreatefromgif($fileimg);
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $dim_width, $dim_height, $width, $height);
				imagegif($thumb, $dest);
			} break;
			case 2:{//jpeg
				$source = imagecreatefromjpeg($fileimg);
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $dim_width, $dim_height, $width, $height);
				imagejpeg($thumb, $dest);
			} break;
			case 3:{//png
				$source = imagecreatefrompng($fileimg);
				// risoluzione immagini png e gif con sfondo trasparente -> https://stackoverflow.com/questions/2611852/imagecreatefrompng-makes-a-black-background-instead-of-transparent	
				//$background = imagecolorallocate($thumb , 255, 255, 255);
				//imagecolortransparent($thumb, $background);
				//imagealphablending($thumb, false);
				//imagesavealpha($thumb, true);
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $dim_width, $dim_height, $width, $height);
				imagepng($thumb, $dest);
			} break;
		}
	}
	
	function croppedImage ($fileimg, $dest, $towidth, $toheight) {
		if (!file_exists($fileimg)) {
			return false;
		}
		if (empty($towidth) && empty($toheight)) {
			copy($fileimg, $dest);
			return true;
		}

		list ($owid, $ohei, $type) = getimagesize($fileimg);

		if($owid <= $ohei) {
			$new_width = $towidth;
			$new_height = ($towidth/$owid)*$ohei;
		}else {
			$new_height = $toheight;
			$new_width = ($new_height/$ohei)*$owid;
		}
		
		switch ($type) {
			case '1':
				$img_src=imagecreatefromgif($fileimg);
				$img_dest=imagecreate($new_width, $new_height);
				break;
			case '2':
				$img_src=imagecreatefromjpeg($fileimg);
				$img_dest=imagecreatetruecolor($new_width, $new_height);
				break;
			default:
				$img_src=imagecreatefrompng($fileimg);
				$img_dest=imagecreatetruecolor($new_width, $new_height);
				break;
		}

		imagecopyresampled($img_dest, $img_src, 0, 0, 0, 0, $new_width, $new_height, $owid, $ohei);

		switch ($type) {
			case '1':
				$cropped=imagecreate($towidth, $toheight);
				break;
			case '2':
				$cropped=imagecreatetruecolor($towidth, $toheight);
				break;
			default:
				$cropped=imagecreatetruecolor($towidth, $toheight);
				break;
		}

		imagecopy($cropped, $img_dest, 0, 0, 0, 0, $owid, $ohei);

		switch ($type) {
			case '1' :
				imagegif($cropped, $dest);
				break;
			case '2' :
				imagejpeg($cropped, $dest);
				break;
			default :
				imagepng($cropped, $dest);
				break;
		}

		imagedestroy($img_dest);
		imagedestroy($cropped);

		return true;
	}
	
	function croppedCenterImage ($fileimg, $dest, $towidth, $toheight) {
		if (!file_exists($fileimg)) {
			return false;
		}
		if (empty($towidth) && empty($toheight)) {
			copy($fileimg, $dest);
			return true;
		}
	
		list ($owid, $ohei, $type) = getimagesize($fileimg);
	
		$new_width = $owid;
		$new_height = $ohei;
	
		switch ($type) {
			case '1':
				$img_src=imagecreatefromgif($fileimg);
				$img_dest=imagecreate($new_width, $new_height);
				break;
			case '2':
				$img_src=imagecreatefromjpeg($fileimg);
				$img_dest=imagecreatetruecolor($new_width, $new_height);
				break;
			default:
				$img_src=imagecreatefrompng($fileimg);
				$img_dest=imagecreatetruecolor($new_width, $new_height);
				break;
		}
	
		//-- center image
		$src_x = abs(round(($towidth-$new_width)/2));
		$src_y = abs(round(($toheight-$new_height)/2));
		
		//bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
		imagecopyresampled($img_dest, $img_src, 0, 0, $src_x, $src_y, $new_width, $new_height, $owid, $ohei);
	
		switch ($type) {
			case '1':
				$cropped=imagecreate($towidth, $toheight);
				break;
			case '2':
				$cropped=imagecreatetruecolor($towidth, $toheight);
				break;
			default:
				$cropped=imagecreatetruecolor($towidth, $toheight);
				break;
		}
		
		//bool imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
		imagecopy($cropped, $img_dest, 0, 0, 0, 0, $owid, $ohei);
	
		switch ($type) {
			case '1' :
				imagegif($cropped, $dest);
				break;
			case '2' :
				imagejpeg($cropped, $dest);
				break;
			default :
				imagepng($cropped, $dest);
				break;
		}
	
		imagedestroy($img_dest);
		imagedestroy($cropped);
	
		return true;
	}

}

?>