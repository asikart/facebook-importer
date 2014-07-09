<?php
/**
 * Part of joomla3304 project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Fbimporter\Helper;

/**
 * Class TempHelper
 *
 * @since 1.0
 */
class TempHelper
{
	/**
	 * getPath
	 *
	 * @return  string
	 */
	public static function getPath()
	{
		return JPATH_CACHE . '/fb-importer-temp';
	}
}
 