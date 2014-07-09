<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

include_once JPATH_LIBRARIES . '/windwalker/src/init.php';

JLoader::registerPrefix('Fbimporter', JPATH_BASE . '/components/com_fbimporter');
JLoader::registerNamespace('Fbimporter', JPATH_ADMINISTRATOR . '/components/com_fbimporter/src');
JLoader::registerNamespace('Windwalker', __DIR__);
JLoader::register('FbimporterComponent', JPATH_BASE . '/components/com_fbimporter/component.php');
