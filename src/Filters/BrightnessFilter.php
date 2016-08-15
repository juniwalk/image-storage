<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage\Filters;

use Nette\Utils\Image;

final class BrightnessFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var int */
	private $level;


	/**
	 * @param int  $level
	 */
	public function __construct(int $level)
	{
		$this->level = max(min($level, 255), -255);
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->filter(IMG_FILTER_BRIGHTNESS, $this->level);
	}
}
