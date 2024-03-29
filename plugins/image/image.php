<?php
// Copyright (c) 2013-2014 Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.

// Image parser plugin
class YellowImage
{
	const Version = "0.1.7";
	var $yellow;			//access to API
	var $graphicsLibrary;	//graphics library support? (boolean)

	// Handle plugin initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->yellow->config->setDefault("imageThumbnailLocation", "/media/thumbnails/");
		$this->yellow->config->setDefault("imageThumbnailDir", "media/thumbnails/");
		$this->yellow->config->setDefault("imageAlt", "Image");
		$this->yellow->config->setDefault("imageJpegQuality", 80);
		$this->graphicsLibrary = $this->isGraphicsLibrary();
	}

	// Handle page custom type parsing
	function onParseType($page, $name, $text, $typeShortcut)
	{
		$output = NULL;
		if($name=="image" && $typeShortcut)
		{
			if(!$this->graphicsLibrary)
			{
				$this->yellow->page->error(500, "Plugin 'image' requires GD library with JPEG and PNG support!");
				return $output;
			}
			list($name, $alt, $style, $widthOutput, $heightOutput, $mode) = $this->yellow->toolbox->getTextArgs($text);
			$width = $height = 0;
			$src = $name;
			if(!preg_match("/^\w+:/", $src))
			{
				list($width, $height, $type) = $this->yellow->toolbox->detectImageInfo($this->yellow->config->get("imageDir").$src);
				$src = $this->yellow->config->get("serverBase").$this->yellow->config->get("imageLocation").$src;
				if(empty($alt)) $alt = $this->yellow->config->get("imageAlt");
				if(empty($heightOutput)) $heightOutput = $widthOutput;
				if($width && $height && $widthOutput && $heightOutput)
				{
					list($width, $height, $src) = $this->createThumbnail($name, $width, $height, $widthOutput, $heightOutput, $type, $mode);
				}
			} else {
				$src = $this->yellow->toolbox->normaliseLocation($src, $page->base, $page->location);
			}
			$output = "<img src=\"".htmlspecialchars($src)."\"";
			if($width && $height) $output .= " width=\"".htmlspecialchars($width)."\" height=\"".htmlspecialchars($height)."\"";
			if(!empty($alt)) $output .= " alt=\"".htmlspecialchars($alt)."\" title=\"".htmlspecialchars($alt)."\"";
			if(!empty($style)) $output .= " class=\"".htmlspecialchars($style)."\"";
			$output .= " />";
		}
		return $output;
	}
	
	// Handle command
	function onCommand($args)
	{
		list($name, $command) = $args;
		switch($command)
		{
			case "clean":	$statusCode = $this->cleanCommand($args); break;
			default:		$statusCode = 0;
		}
		return $statusCode;
	}

	// Clean thumbnails
	function cleanCommand($args)
	{
		$statusCode = 0;
		$path = $this->yellow->config->get("imageThumbnailDir");
		foreach($this->yellow->toolbox->getDirectoryEntries($path, "/.*/", false, false) as $entry)
		{
			if(!$this->yellow->toolbox->deleteFile($entry)) $statusCode = 500;
		}
		if($statusCode == 500) echo "ERROR cleaning thumbnails: Can't delete files in directory '$path'!\n";
		return $statusCode;
	}

	// Create thumbnail on demand
	function createThumbnail($fileName, $widthInput, $heightInput, $widthOutput, $heightOutput, $type, $mode)
	{
		$widthOutput = $this->convertValueAndUnit($widthOutput, $widthInput);
		$heightOutput = $this->convertValueAndUnit($heightOutput, $heightInput);
		$mode = strtolower($mode); if($mode != "cut") $mode = "fit";
		$fileNameThumb = ltrim(str_replace(array("/", "\\", "."), "-", dirname($fileName)."/".pathinfo($fileName, PATHINFO_FILENAME)), "-");
		$fileNameThumb .= "-".$widthOutput."x".$heightOutput."-".$mode;
		$fileNameThumb .= ".".pathinfo($fileName, PATHINFO_EXTENSION);
		$fileNameInput = $this->yellow->config->get("imageDir").$fileName;
		$fileNameOutput = $this->yellow->config->get("imageThumbnailDir").$fileNameThumb;
		if($this->isFileNotUpdated($fileNameInput, $fileNameOutput))
		{
			$image = $this->loadImage($fileNameInput, $type);
			if($image)
			{
				$image = $this->resizeImage($image, $widthInput, $heightInput, $widthOutput, $heightOutput, $mode);
				if(!$this->saveImage($fileNameOutput, $type, $image) ||
				   !$this->yellow->toolbox->modifyFile($fileNameOutput, filemtime($fileNameInput)))
				{
					$this->yellow->page->error(500, "Image '$fileNameOutput' can't be saved!");
				}
			}
		}
		list($width, $height) = $this->yellow->toolbox->detectImageInfo($fileNameOutput);
		$src = $this->yellow->config->get("serverBase").$this->yellow->config->get("imageThumbnailLocation").$fileNameThumb;
		return array($width, $height, $src);
	}

	// Load image from file
	function loadImage($fileName, $type)
	{
		$image = false;
		switch($type)
		{
			case "jpg":	$image = @imagecreatefromjpeg($fileName); break;
			case "png":	$image = @imagecreatefrompng($fileName); break;
		}
		return $image;
	}

	// Save image as file
	function saveImage($fileName, $type, $image)
	{
		$ok = false;
		switch($type)
		{
			case "jpg":	$ok = @imagejpeg($image, $fileName, $this->yellow->config->get("imageJpegQuality")); break;
			case "png":	$ok = @imagepng($image, $fileName); break;
		}
		return $ok;
	}

	// Create image
	function createImage($width, $height)
	{
		$image = imagecreatetruecolor($width, $height);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		return $image;
	}

	// Resize image
	function resizeImage($imageInput, $widthInput, $heightInput, $widthOutput, $heightOutput, $mode)
	{
		$widthFit = $widthInput * ($heightOutput / $heightInput);
		$heightFit = $heightInput * ($widthOutput / $widthInput);
		$widthDiff = abs($widthOutput - $widthFit);
		$heightDiff = abs($heightOutput - $heightFit);
		if($mode == "cut")
		{
			if($widthFit < $widthOutput)
			{
				$imageOutput = $this->createImage($widthFit, $heightOutput);
				imagecopyresampled($imageOutput, $imageInput, 0, 0, 0, 0, $widthFit, $heightOutput, $widthInput, $heightInput);
			} else {
				$imageOutput = $this->createImage($widthOutput, $heightFit);
				imagecopyresampled($imageOutput, $imageInput, 0, 0, 0, 0, $widthOutput, $heightFit, $widthInput, $heightInput);
			}
		} else {
			$imageOutput = $this->createImage($widthOutput, $heightOutput);
			if($heightFit > $heightOutput)
			{
				imagecopyresampled($imageOutput, $imageInput, 0, $heightDiff/-2, 0, 0, $widthOutput, $heightFit, $widthInput, $heightInput);
			} else {
				imagecopyresampled($imageOutput, $imageInput, $widthDiff/-2, 0, 0, 0, $widthFit, $heightOutput, $widthInput, $heightInput);
			}
		}
		return $imageOutput;
	}

	// Return value according to unit
	function convertValueAndUnit($text, $valueBase)
	{
		$value = $unit = "";
		if(preg_match("/(\d+)(\S*)/", $text, $matches))
		{
			$value = $matches[1];
			$unit = $matches[2];
			if($unit == "%") $value = intval($valueBase * $value / 100);
		}
		return $value;
	}

	// Check if file needs to be updated
	function isFileNotUpdated($fileNameInput, $fileNameOutput)
	{
		$fileDateInput = is_file($fileNameInput) ? filemtime($fileNameInput) : 0;
		$fileDateOutput = is_file($fileNameOutput) ? filemtime($fileNameOutput) : 0;
		return $fileDateInput != $fileDateOutput;
	}

	// Check graphics library support
	function isGraphicsLibrary()
	{
		return extension_loaded("gd") && function_exists("gd_info") &&
			((imagetypes()&(IMG_JPG|IMG_PNG)) == (IMG_JPG|IMG_PNG));
	}
}

$yellow->plugins->register("image", "YellowImage", YellowImage::Version);
?>