<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Items list controller class.
 */
class FbimporterControllerItems extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'item', $prefix = 'FbimporterModel')
	{
		$model = parent::getModel($name, $prefix, array());
		return $model;
	}
	
	/*
	 * function refresh
	 * @param $
	 */
	
	public function refresh() {
		$model = $this->getModel('items');
		$model->refresh();
		
		$this->setRedirect('index.php?option=com_fbimporter&view=items') ;
	}
}