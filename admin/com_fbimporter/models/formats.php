<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Fbimporter records.
 */
class FbimporterModelFormats extends JModelList
{

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'filter_order_Dir', 'filter_order', 
				'search' , 'filter'
            );
            
        $config['tables'] = array(
				'#__fbimporter_formats',
				'#__categories',
				'#__viewlevels',
				'#__languages'
			);
            
            $config['filter_fields'] = FbimporterHelper::_('db.mergeFilterFields', $config['filter_fields'] , $config['tables'] );
        }
		
		$this->config = $config ;

        parent::__construct($config);
    }


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_fbimporter');
		$this->setState('params', $params);
		
		
		foreach( $this->filter_fields as $field ){
			$this->setState($field, $app->getUserStateFromRequest($this->context.'.field.'.$field, $field) );
		}

		// List state information.
		parent::populateState('a.id', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('search');
		$id.= ':' . $this->getState('filter');

		return parent::getStoreId($id);
	}
	
	
	public function getFilter()
	{
		// Get filter inputs from from xml files in /models/form.
		JForm::addFormPath(FBIMPORTER_ADMIN.'/models/forms');
        JForm::addFieldPath(FBIMPORTER_ADMIN.'/models/fields');
		
		// load forms
		$form['search'] = JForm::getInstance('com_fbimporter.formats.search', 'formats_search', array( 'control' => 'search' ,'load_data'=>'true'));
		$form['filter'] = JForm::getInstance('com_fbimporter.formats.filter', 'formats_filter', array( 'control' => 'filter' ,'load_data'=>'true'));
		
		// Get default data of this form. Any State key same as form key will auto match.
		$form['search']->bind( $this->getState('search') );
		$form['filter']->bind( $this->getState('filter') );
		
		return $form;
	}
	

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$q		= $db->getQuery(true);
		$order 	= $this->getState('list.ordering' , 'a.id');
		$dir	= $this->getState('list.direction', 'asc');

		// Filter and Search
		$filter = $this->getState('filter',array()) ;
		$search = $this->getState('search') ;
		
		if($search['index']){
			$q->where("{$search['field']} LIKE '%{$search['index']}%'");
		}
		
		foreach($filter as $k => $v ){
			if($v !== '*')
				$q->where("{$k}='{$v}'") ;
		}
		// Filter and search
		
		// get select columns
		$select = FbimporterHelper::_( 'db.getSelectList', $this->config['tables'] );
		
		//build query
		$q->select($select)
			->from('#__fbimporter_formats AS a')
			->leftJoin('#__categories 	AS b ON a.catid = b.id')
			->leftJoin('#__viewlevels 	AS c ON a.access = c.id')
			->leftJoin('#__languages 	AS d ON a.language = d.lang_code')
			//->where("")
			->order( " {$order} {$dir}" ) ;
		
		return $q;
	}
}
