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

final class SketchFilter implements \JuniWalk\ImageStorage\Filter
{
	/**
	 * @param Image  $image
	 */
	public function apply(Image $image)
	{
		$image->filter(IMG_FILTER_MEAN_REMOVAL);
	}
}
