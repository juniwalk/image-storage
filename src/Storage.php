<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage;

interface Storage
{
	/**
	 * @return string
	 */
	public function getName() : string;


	/**
	 * @return string|NULL
	 */
	public function getType();


	/**
	 * @param  Filter  $filter
	 * @return void
	 */
	public function addFilter(Filter $filter);


	/**
	 * @return Filter[]
	 */
	public function getFilters() : array;
}
