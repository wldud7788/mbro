<?php
define("TL", 1);		// TOP LEFT
define("TM", 2);		// TOP MIDDLE
define("TR", 4);		// TOP RIGHT
define("ML", 8); 		// MIDDLE LEFT
define("MM", 16); 		// MIDDLE MIDDLE
define("MR", 32);		// MIDDLE RIGHT
define("BL", 64);		// BOTTOM LEFT
define("BM", 128);		// BOTTOM MIDDLE
define("BR", 256);		// BOTTOM RIGHT
define("SCALE_NUM", 0.25);

/**
 * Apply watermark image
 * http://github.com/josemarluedke/Watermark/apply
 *
 * Copyright 2011, Josemar Davi Luedke <josemarluedke@gmail.com>
 *
 * Licensed under the MIT license
 * Redistributions of part of code must retain the above copyright notice.
 *
 * @author Josemar Davi Luedke <josemarluedke@gmail.com>
 * @version 0.1.1
 * @copyright Copyright 2010, Josemar Davi Luedke <josemarluedke.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class watermarklib
{

	/**
	 *
	 * Erros
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 *
	 * Image Source
	 *
	 * @var img
	 */
	protected $imgSource = null;

	/**
	 *
	 * Image Watermark
	 *
	 * @var img
	 */
	protected $imgWatermark = null;

	/**
	 *
	 * Positions watermark
	 * 0: Centered
	 * 1: Top Left
	 * 2: Top Right
	 * 3: Footer Right
	 * 4: Footer left
	 * 5: Top Centered
	 * 6: Center Right
	 * 7: Footer Centered
	 * 8: Center Left
	 *
	 * @var number
	 */
	protected $watermarkPosition = 0;

	/**
	 * Check PHP GD is enabled
	 */
	public function __construct()
	{
		if (! function_exists("imagecreatetruecolor")) {
			if (! function_exists("imagecreate")) {
				$this->error[] = "You do not have the GD library loaded in PHP!";
			}
		}
	}

	/**
	 *
	 * Get function name for use in apply
	 *
	 * @param string $name
	 *        	Image Name
	 * @param string $action
	 *        	|open|save|
	 */
	protected function getFunction($name, $action = 'open')
	{
		$aImageInfo = getimagesize($name);
		$sImageType = $aImageInfo[2];
		if ($sImageType == IMAGETYPE_JPEG) {
			if ($action == "open") {
				return "imagecreatefromjpeg";
			} else {
				return "imagejpeg";
			}
		} elseif ($sImageType == IMAGETYPE_GIF) {
			if ($action == "open") {
				return "imagecreatefromgif";
			} else {
				return "imagegif";
			}
		} elseif ($sImageType == IMAGETYPE_PNG) {
			if ($action == "open") {
				return "imagecreatefrompng";
			} else {
				return "imagepng";
			}
		} else {
			$this->error[] = "Image Format Invalid!";
		}
	}

	/**
	 *
	 * Get image sizes
	 *
	 * @param object $img
	 *        	Image Object
	 */
	public function getImgSizes($img)
	{
		return array(
			'width' => imagesx($img),
			'height' => imagesy($img)
		);
	}

	/**
	 * Get positions for use in apply
	 * Enter description here ...
	 */
	public function getPositions()
	{
		$imgSource = $this->getImgSizes($this->imgSource);
		$imgWatermark = $this->getImgSizes($this->imgWatermark);
		$positionX = 0;
		$positionY = 0;

		// Centered
		if ($this->watermarkPosition == 0) {
			$positionX = ($imgSource['width'] / 2) - ($imgWatermark['width'] / 2);
			$positionY = ($imgSource['height'] / 2) - ($imgWatermark['height'] / 2);
		}

		// Top Left
		if ($this->watermarkPosition == 1) {
			$positionX = 0;
			$positionY = 0;
		}

		// Top Right
		if ($this->watermarkPosition == 2) {
			$positionX = $imgSource['width'] - $imgWatermark['width'];
			$positionY = 0;
		}

		// Footer Right
		if ($this->watermarkPosition == 3) {
			$positionX = ($imgSource['width'] - $imgWatermark['width']) - 5;
			$positionY = ($imgSource['height'] - $imgWatermark['height']) - 5;
		}

		// Footer left
		if ($this->watermarkPosition == 4) {
			$positionX = 0;
			$positionY = $imgSource['height'] - $imgWatermark['height'];
		}

		// Top Centered
		if ($this->watermarkPosition == 5) {
			$positionX = (($imgSource['height'] - $imgWatermark['width']) / 2);
			$positionY = 0;
		}

		// Center Right
		if ($this->watermarkPosition == 6) {
			$positionX = $imgSource['width'] - $imgWatermark['width'];
			$positionY = ($imgSource['height'] / 2) - ($imgWatermark['height'] / 2);
		}

		// Footer Centered
		if ($this->watermarkPosition == 7) {
			$positionX = (($imgSource['width'] - $imgWatermark['width']) / 2);
			$positionY = $imgSource['height'] - $imgWatermark['height'];
		}

		// Center Left
		if ($this->watermarkPosition == 8) {
			$positionX = 0;
			$positionY = ($imgSource['height'] / 2) - ($imgWatermark['height'] / 2);
		}

		return array(
			'x' => $positionX,
			'y' => $positionY
		);
	}

	/**
	 *
	 * Apply watermark in image
	 *
	 * @param string $imgSource
	 *        	Name image source
	 * @param string $imgTarget
	 *        	Name image target
	 * @param string $imgWatermark
	 *        	Name image watermark
	 * @param number $position
	 *        	Position watermark
	 */
	public function apply($imgSource, $imgTarget,  $imgWatermark, $position = 0){
		# Set watermark position
		$this->watermarkPosition = $position;

		# Get function name to use for create image
		$functionSource = $this->getFunction($imgSource, 'open');
		$this->imgSource = $functionSource($imgSource);

		# Get function name to use for create image
		$functionWatermark = $this->getFunction($imgWatermark, 'open');
		$this->imgWatermark = $functionWatermark($imgWatermark);

		# Get watermark images size
		$sizesWatermark = $this->getImgSizes($this->imgWatermark);

		# Get watermark position
		$positions = $this->getPositions();

		# Apply watermark
		imagecopy($this->imgSource, $this->imgWatermark, $positions['x'], $positions['y'], 0, 0, $sizesWatermark['width'], $sizesWatermark['height']);

		# Get function name to use for save image
		$functionTarget = $this->getFunction($imgTarget, 'save');

		# Save image
		$functionTarget($this->imgSource, $imgTarget, 100);

		# Destroy temp images
		imagedestroy($this->imgSource);
		imagedestroy($this->imgWatermark);
	}

	public function save($imgTarget, $position = 0)
	{
		# Set watermark position
		$this->watermarkPosition = $position;

		# Get watermark images size
		$sizesWatermark = $this->getImgSizes($this->imgWatermark);

		# Get watermark position
		$positions = $this->getPositions();

		# Apply watermark
		imagecopy($this->imgSource, $this->imgWatermark, $positions['x'], $positions['y'], 0, 0, $sizesWatermark['width'], $sizesWatermark['height']);

		# Get function name to use for save image
		$functionTarget = $this->getFunction($imgTarget, 'save');

		# Save image
		if ($functionTarget == 'imagejpeg') {
			$functionTarget($this->imgSource, $imgTarget, 95);
		} else {
			$functionTarget($this->imgSource, $imgTarget);
		}

		# Destroy temp images
		imagedestroy($this->imgSource);
		imagedestroy($this->imgWatermark);
	}

	protected function resizeWaterMark($width, $height, $watermark_width, $watermark_height) {
		$new_image = imagecreatetruecolor($width, $height);

		imagealphablending($new_image, false);
		$col=imagecolorallocatealpha($new_image,255,255,255,127);
		imagefilledrectangle($new_image,0,0,$width, $height,$col);
		imagealphablending($new_image,true);

		imagecopyresampled($new_image, $this->watermarkImage, 0, 0, 0, 0, $width, $height, $watermark_width, $watermark_height);
		$this->watermarkImage = $new_image;

		$this->isResizeWarterMark = true;
	}

	public function addWaterMark($imgSourcePath, $watermarkPath, $position = BR, $offset = 0)
	{
		$functionSource = $this->getFunction($imgSourcePath, 'open');
		$this->imgSource = $functionSource($imgSourcePath);

		// Get function name to use for create image
		$functionWatermark = $this->getFunction($watermarkPath, 'open');
		$this->watermarkImage = $functionWatermark($watermarkPath);

		$imgSource = $this->getImgSizes($this->imgSource);
		$imgWatermark = $this->getImgSizes($this->watermarkImage);

		$image_width = $imgSource['width'];
		$image_height = $imgSource['height'];

		$watermark_width = $imgWatermark['width'];
		$watermark_height = $imgWatermark['height'];

		if ($image_height * SCALE_NUM < $watermark_height) {
			$temp_height = $image_height * SCALE_NUM;
			$percent = $temp_height / $watermark_height;
			$temp_width = $image_width * SCALE_NUM;
			$percentW = $temp_width / $watermark_width;
			if ($percent > $percentW) {
				$percent = $percentW;
			}
			$watermark_width = $watermark_width * $percent;
			$watermark_height = $watermark_height * $percent;
			$this->resizeWaterMark($watermark_width, $watermark_height, $imgWatermark['width'], $imgWatermark['height']);
		}

		$largeWaterMark = imagecreatetruecolor($image_width, $image_height);
		imagealphablending($largeWaterMark, false);
		$col = imagecolorallocatealpha($largeWaterMark, 255, 255, 255, 127);
		imagefilledrectangle($largeWaterMark, 0, 0, $image_width, $image_height, $col);
		imagealphablending($largeWaterMark, true);
		imagesavealpha($largeWaterMark, true);

		$dest_x = 0;
		$dest_y = 0;
		if ($position & TL) {
			$dest_x = $offset;
			$dest_y = $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// top middle
		if ($position & TM) {
			$dest_x = (($image_width - $watermark_width) / 2);
			$dest_y = $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// top right
		if ($position & TR) {
			$dest_x = ($image_width - $watermark_width) - $offset;
			$dest_y = $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// middle left
		if ($position & ML) {
			$dest_x = $offset;
			$dest_y = (($image_height / 2) - ($watermark_height / 2));

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// middle middle
		if ($position & MM) {
			$dest_x = (($image_width / 2) - ($watermark_width / 2));
			$dest_y = (($image_height / 2) - ($watermark_height / 2));

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// middle right
		if ($position & MR) {
			$dest_x = ($image_width - $watermark_width) - $offset;
			$dest_y = (($image_height / 2) - ($watermark_height / 2));

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// bottom left
		if ($position & BL) {
			$dest_x = $offset;
			$dest_y = ($image_height - $watermark_height) - $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// bottom middle
		if ($position & BM) {
			$dest_x = (($image_width - $watermark_width) / 2);
			$dest_y = ($image_height - $watermark_height) - $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		// bottom right
		if ($position & BR) {
			$dest_x = ($image_width - $watermark_width) - $offset;
			$dest_y = ($image_height - $watermark_height) - $offset;

			imagecopyresampled($largeWaterMark, $this->watermarkImage, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
		}

		$this->imgWatermark = $largeWaterMark;
	}

	public function addPatternWaterMark($imgSourcePath, $watermarkPath, $offset = 0)
	{
		$functionSource = $this->getFunction($imgSourcePath, 'open');
		$this->imgSource = $functionSource($imgSourcePath);

		// Get function name to use for create image
		$functionWatermark = $this->getFunction($watermarkPath, 'open');
		$this->watermarkImage = $functionWatermark($watermarkPath);
		$this->imgWatermark = '';

		$imgSource = $this->getImgSizes($this->imgSource);
		$imgWatermark = $this->getImgSizes($this->watermarkImage);

		$image_width = $imgSource['width'];
		$image_height = $imgSource['height'];

		$watermark_width = $imgWatermark['width'];
		$watermark_height = $imgWatermark['height'];

		if ($image_height * SCALE_NUM < $watermark_height) {
			$temp_height = $image_height * SCALE_NUM;
			$percent = $temp_height / $watermark_height;
			$temp_width = $image_width * SCALE_NUM;
			$percentW = $temp_width / $watermark_width;
			if ($percent > $percentW) {
				$percent = $percentW;
			}
			$watermark_width = $watermark_width * $percent;
			$watermark_height = $watermark_height * $percent;
			$this->resizeWaterMark($watermark_width, $watermark_height, $imgWatermark['width'], $imgWatermark['height']);
		}

		$new_width = $image_width + $image_height;
		$new_height = $image_height + $image_width;

		$largeWaterMark = imagecreatetruecolor($new_width, $new_height);

		// make $base_image transparent
		imagealphablending($largeWaterMark, false);
		$col = imagecolorallocatealpha($largeWaterMark, 255, 255, 255, 127);
		imagefilledrectangle($largeWaterMark, 0, 0, $new_width, $new_height, $col);
		imagealphablending($largeWaterMark, true);
		imagesavealpha($largeWaterMark, true);

		$offset_x = $watermark_width * 0.3;
		$offset_y = $watermark_height * 5;

		// drawing center
		$center_y = ($image_height + $watermark_height) / 2;
		$iGap = ($image_height - $watermark_height) / 1.3;
		$chk = true;
		$x = 0;
		$y = $center_y;

		$x = 0;
		$chk = true;
		while ($chk) {
			imagecopyresampled($largeWaterMark, $this->watermarkImage, $x, $y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
			$x = $x + $watermark_width + $offset_x;
			if ($x > $new_width) {
				$chk = false;
			}
		}

		// center -> top
		for ($y = ($center_y - $iGap); $y > 0; $y -= $iGap) {
			$x = 0;
			$chk = true;
			while ($chk) {
				imagecopyresampled($largeWaterMark, $this->watermarkImage, $x, $y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
				$x = $x + $watermark_width + $offset_x;
				if ($x > $new_width) {
					$chk = false;
				}
			}
		}

		// center -> bottom
		for ($y = ($center_y + $iGap); $y < ($image_height * 2); $y += $iGap) {
			$x = 0;
			$chk = true;
			while ($chk) {
				imagecopyresampled($largeWaterMark, $this->watermarkImage, $x, $y, 0, 0, $watermark_width, $watermark_height, $watermark_width, $watermark_height);
				$x = $x + $watermark_width + $offset_x;
				if ($x > $new_width) {
					$chk = false;
				}
			}
		}

		// 회전
		$rotate = 20;

		// 회전 후 배경이 투명을 유지 하기 위해서..
		$transColor = imagecolorallocatealpha($largeWaterMark, 255, 255, 255, 127);
		$largeWaterMark = imagerotate($largeWaterMark, $rotate, $transColor);
		$this->imgWatermark = $largeWaterMark;
	}
}
?>