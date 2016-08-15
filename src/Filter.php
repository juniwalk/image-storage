<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage;

use Nette\Utils\Image;

interface Filter
{
	/**
	 * @param  Image  $image
	 * @return void
	 */
	public function apply(Image $image);
}
