<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Item controller class.
 */
class FbimporterControllerItem extends JControllerForm
{

    function __construct() {
        $this->view_list = 'items';
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Item', $prefix = 'FbimporterModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	/*
	 * function add
	 * @param $arg
	 */
	
	public function saveAll() {
		$model = $this->getModel() ;
		if(!$model->saveAll()){
			$msg = $model->getError();
		}else{
			$msg = '匯入成功' ;
		}
		
		$this->setRedirect( 'index.php?option=com_fbimporter&view=items' , $msg );
	}
	
	
	/*
	 * function add
	 * @param $arg
	 */
	
	public function saveAsCombined() {
		$model = $this->getModel() ;
		$id = $model->saveAsCombined();
		
		$this->setRedirect( 'index.php?option=com_content&task=article.edit&id=' . $id );
	}
	
		
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		return parent::getRedirectToItemAppend($recordId , $urlVar );
	}
}