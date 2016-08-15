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

final class BlurFilter implements \JuniWalk\ImageStorage\Filter
{
	/** @var int */
	private $level;


	/**
	 * @param int  $level
	 */
	public function __construct(int $level = 1)
	{
		$this->level = max($level, 1);
	}


	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$level = 0;

		do {
			$image->filter(IMG_FILTER_GAUSSIAN_BLUR);
			$level++;

		} while ($this->level > $level);
	}
}
