<?php

/**
 * @author    Martin Procházka <juniwalk@outlook.cz>
 * @package   ImageStorage
 * @link      https://github.com/juniwalk/image-storage
 * @copyright Martin Procházka (c) 2016
 * @license   MIT License
 */

namespace JuniWalk\ImageStorage\Storages;

use JuniWalk\ImageStorage\Filter;
use Nette\Utils\Strings;

final class LocalStorage implements \JuniWalk\ImageStorage\Storage
{
	/** @var string */
	private $name;

	/** @var string */
	private $type;

	/** @var Filter[] */
	private $filters = [];


	/**
	 * @param string       $name
	 * @param string|NULL  $type
	 */
	public function __construct(string $name, string $type = NULL)
	{
		$this->type = Strings::lower($type) ?: NULL;
		$this->name = Strings::webalize($name);
	}


	/**
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}


	/**
	 * @return string|NULL
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * @param Filter  $filter
	 */
	public function addFilter(Filter $filter)
	{
		$this->filters[] = $filter;
	}


	/**
	 * @return Filter[]
	 */
	public function getFilters() : array
	{
		return $this->filters;
	}
}
