<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter Component
 *
 * @since 1.0
 */
final class FbimporterComponent extends \Fbimporter\Component\FbimporterComponent
{
	/**
	 * Default task name.
	 *
	 * @var string
	 */
	protected $defaultController = 'formats.display';

	/**
	 * Prepare hook of this component.
	 *
	 * Do some customize initialise through extending this method.
	 *
	 * @return void
	 */
	public function prepare()
	{
		parent::prepare();
	}
}
