<?php
/**
 * Part of Component Fbimporter files.
 *
 * @copyright   Copyright (C) 2014 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Windwalker\DI\Container;
use Windwalker\Joomla\DataMapper\DataMapper;
use Windwalker\Model\Filter\FilterHelper;
use Windwalker\Model\ListModel;

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter Items model
 *
 * @since 1.0
 */
class FbimporterModelItems extends ListModel
{
	/**
	 * Component prefix.
	 *
	 * @var  string
	 */
	protected $prefix = 'fbimporter';

	/**
	 * The URL option for the component.
	 *
	 * @var  string
	 */
	protected $option = 'com_fbimporter';

	/**
	 * The prefix to use with messages.
	 *
	 * @var  string
	 */
	protected $textPrefix = 'COM_FBIMPORTER';

	/**
	 * The model (base) name
	 *
	 * @var  string
	 */
	protected $name = 'items';

	/**
	 * Item name.
	 *
	 * @var  string
	 */
	protected $viewItem = 'item';

	/**
	 * List name.
	 *
	 * @var  string
	 */
	protected $viewList = 'items';

	/**
	 * Property formats.
	 *
	 * @var \Windwalker\Data\Data
	 */
	protected $formats;

	/**
	 * Constructor
	 *
	 * @param   array                 $config    An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   \Joomla\DI\Container  $container Service container.
	 * @param   \JRegistry            $state     The model state.
	 * @param   \JDatabaseDriver      $db        The database adapter.
	 */
	public function __construct($config = array(), \Joomla\DI\Container $container = null, \JRegistry $state = null, \JDatabaseDriver $db = null)
	{
		parent::__construct($config, $container, $state, $db);

		$this->temp = JPATH_CACHE . '/fb-importer-temp';

		$this->params = JComponentHelper::getParams('com_fbimporter');
	}

	/**
	 * refresh
	 *
	 * @return  void
	 */
	public function refresh()
	{
		JLoader::register('Facebook', FBIMPORTER_ADMIN . '/src/Facebook/facebook.php');

		$temp   = $this->temp;
		$params = $this->getParams();

		$config = array();

		$config['appId']  = $params->get('app_id', '420381114686923');
		$config['secret'] = $params->get('secret', 'e5fcb4294864136013ae747090b07778');

		$fb = new Facebook($config);

		$limit = $this->state->get('import_num', 50);
		$uid = $params->get('fb_uid', 'facebook');

		$r = $fb->api(
			"/{$uid}/posts?limit=" . $limit
			. "&fields=id,from,to,name,source,story,story_tags,message,message_tags,picture,link,icon,privacy,type,status_type,object_id,created_time,updated_time,"
			. "likes.limit(1).summary(true)"
		);

		JPath::setPermissions($temp);

		file_put_contents($temp, json_encode($r));
		file_put_contents($temp . 'X.txt', print_r($r, 1));
	}

	/**
	 * getItems
	 *
	 * @return  array
	 */
	public function getItems()
	{
		$db         = JFactory::getDbo();
		$q          = $db->getQuery(true);
		$params     = $this->getParams();
		$temp       = $this->temp;
		$categories = $this->getCategories();

		$r = '';

		if (is_file($temp))
		{
			$r = file_get_contents($temp);
		}

		$r = json_decode($r);

		if (isset($r->data))
		{
			foreach ($r->data as $key => &$item)
			{
				$item = new JObject($item);

				$item->continue = false;

				if (!property_exists($item, 'message'))
				{
					unset($r->data[$key]);

					$item->continue = true;

					continue;
				}

				// Separate First Line As Title
				// ====================================================================
				$item->message = nl2br($item->message);
				$item->message = explode('<br />', $item->message);
				$item->title   = $title = array_shift($item->message);
				$item->title   = str_ireplace('https://', '', $item->title);
				$item->title   = str_ireplace('http://', '', $item->title);

				// Set message and id
				$item->message = implode('<br />', $item->message);
				$item->id      = explode('_', $item->id);
				$item->id      = $item->id[1];

				// Set Category Detect Rules
				// ====================================================================
				$escape = "[]{}()$^.*?-=+&%#!";

				$lft = $params->get('category_match_left');
				$rgt = $params->get('category_match_right');

				if (strpos($escape, $lft) !== false)
				{
					$lft = '\\' . $lft;
				}

				if (strpos($escape, $rgt) !== false)
				{
					$rgt = '\\' . $rgt;
				}

				// Match Category Name
				// ====================================================================
				$regex = "/{$lft}(.*){$rgt}(.*)/";
				preg_match($regex, trim($title), $matches); // get cat name

				$item->catid       = null;
				$item->cat_matched = 0;

				if (isset($matches[1]) && $matches[2])
				{
					$category_name = trim($matches[1]);

					$result = \Windwalker\Helper\ArrayHelper::query($categories, array('title' => strtolower($category_name)));

					if (count($result) > 0)
					{
						$item->catid       = $result[0]->id;
						$item->title       = trim($matches[2]);
						$item->cat_name    = $category_name;
						$item->cat_matched = 1;
					}
				}
				else
				{
					// If not match, continue
					if ($params->get('category_not_match_continue'))
					{
						$item->continue = true;
					}
				}

				// title Max Char
				// ====================================================================
				$max = $params->get('title_max_char');

				if ($max)
				{
					if (JString::strlen($item->title) > $max)
					{
						$item->message = JString::substr($item->title, $max) . "\n\n" . $item->message;
						$title = JString::substr($item->title, 0, $max);

						$title = explode(' ', $title);
						$last_word = array_pop($title);
						if ($last_word && JString::strlen($last_word) < 10)
						{
							$item->message = $last_word . $item->message;
						}
						else
						{
							$title[] = $last_word;
						}

						$item->title = implode(' ', $title);
					}
				}

				// Get date & alias
				// ====================================================================
				$q->clear();

				$item->date = JFactory::getDate($item->created_time, JFactory::getConfig()->get('offset'));

				$item->alias = JFilterOutput::stringURLSafe($item->title . ' ' . $item->date->format('Y-m-d-H-i-s', true));

				$q->select('id')
					->from('#__content')
					->where("alias = '{$item->alias}'");

				$db->setQuery($q);

				$itemid = $db->loadResult();

				$q->clear();

				$item->exists = $itemid;
			}

			return $r->data;
		}
		else
		{
			return array();
		}
	}

	/**
	 * getCategories
	 *
	 * @param string $extension
	 *
	 * @return  array
	 */
	public function getCategories($extension = 'com_content')
	{
		$db = JFactory::getDbo();
		$q = $db->getQuery(true) ;

		$q->select("*")
			->from("#__categories")
			->where("extension = '{$extension}'");

		$db->setQuery($q);
		$cats = $db->loadObjectList('id');

		foreach( $cats as &$cat )
		{
			$cat->title = strtolower($cat->title) ;
		}

		return $cats;
	}

	/**
	 * getFormats
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getFormats()
	{
		if (!$this->formats)
		{
			$this->formats = with(new DataMapper('#__fbimporter_formats'))->findAll();
		}

		return $this->formats;
	}

	public function getFormatForm()
	{
		JLoader::register('JFormFieldFormat', FBIMPORTER_ADMIN . '/model/field/format.php');

		// Get format form
		$format_form = new JFormFieldFormat;
		$format_form->value = $this->getParams()->get('format');

		return $format_form;
	}

	/**
	 * getPagination
	 *
	 * @return  bool|JPagination
	 */
	public function getPagination()
	{
		return new \Fbimporter\Object\NullObject;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method will only called in constructor. Using `ignore_request` to ignore this method.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = 'ASC')
	{
		parent::populateState($ordering, $direction);
	}
}
