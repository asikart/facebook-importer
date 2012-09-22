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

/**
 * Fbimporter helper.
 */
class FbimporterHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		$app = JFactory::getApplication() ;
		
		
		JSubMenuHelper::addEntry(
			'匯入工具',
			'index.php?option=com_fbimporter&view=items',
			$vName == 'items'
		);
		
		$app->triggerEvent( 'onAfterAddSubmenu', array('com_fbimporter.helper' ,$vName) );

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_fbimporter';

		$actions = array(
			'core.admin', 
			'core.manage', 
			'core.create', 
			'core.edit', 
			'core.edit.own', 
			'core.edit.state', 
			'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	public static function addIncludePath( $path='' )
    {
        static $paths;
 
        if (!isset($paths)) {
            $paths = array( FBIMPORTER_ADMIN.DS.'helpers' );
        }
 
        // force path to array
        settype($path, 'array');
 
        // loop through the path directories
        foreach ($path as $dir)
        {
            if (!empty($dir) && !in_array($dir, $paths)) {
                array_unshift($paths, JPath::clean( $dir ));
            }
        }
 
        return $paths;
    }
	
	
	public static function _( $type )
    {
        //Initialise variables
        $prefix = 'FbimporterHelper';
        $file   = '';
        $func   = $type;
 
        // Check to see if we need to load a helper file
        $parts = explode('.', $type);
 
        switch(count($parts))
        {
            case 3 :
            {
                $prefix        = preg_replace( '#[^A-Z0-9_]#i', '', $parts[0] );
                $file        = preg_replace( '#[^A-Z0-9_]#i', '', $parts[1] );
                $func        = preg_replace( '#[^A-Z0-9_]#i', '', $parts[2] );
            } break;
 
            case 2 :
            {
                $file        = preg_replace( '#[^A-Z0-9_]#i', '', $parts[0] );
                $func        = preg_replace( '#[^A-Z0-9_]#i', '', $parts[1] );
            } break;
        }
 
        $className    = $prefix.ucfirst($file);
 
        if (!class_exists( $className ))
        {
            jimport('joomla.filesystem.path');
            if ($path = JPath::find(self::addIncludePath(), strtolower($file).'.php'))
            {
                require_once $path;
 
                if (!class_exists( $className ))
                {
                    JError::raiseWarning( 0, $className.'::' .$func. ' not found in file.' );
                    return false;
                }
            }
            else
            {
                JError::raiseWarning( 0, $prefix.$file . ' not supported. File not found.' );
                return false;
            }
        }
 
        if (is_callable( array( $className, $func ) ))
        {
            $temp = func_get_args();
            array_shift( $temp );
            $args = array();
            foreach ($temp as $k => $v) {
                $args[] = &$temp[$k];
            }
            return call_user_func_array( array( $className, $func ), $args );
        }
        else
        {
            JError::raiseWarning( 0, $className.'::'.$func.' not supported.' );
            return false;
        }
    }
}
