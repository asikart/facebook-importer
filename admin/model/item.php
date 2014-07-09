<?php
/**
 * Part of joomla3304 project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */
use Fbimporter\Helper\TempHelper;
use Windwalker\Helper\DateHelper;

/**
 * Class FbimporterModelItem
 */
class FbimporterModelItem extends \Windwalker\Model\AbstractAdvancedModel
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
	protected $name = 'item';

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
	 * saveAll
	 *
	 * @param array $items
	 * @param array $ids
	 *
	 * @throws  RuntimeException
	 * @return  bool
	 */
	public function saveAll($items, $ids)
	{
		$table  = JTable::getInstance('content');
		$format = $this->getTable('Format');
		$params = $this->getParams();

		// if sort by current, reverse ids
		/*
		if( $params->get('sort_by_current', 0) ){
			$ids = array_reverse($ids) ;
		}
		*/

		$temp = TempHelper::getPath();

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

				$item->id = explode('_', $item->id);
				$item->id = $item->id[1];

				if (isset($items[$item->id]))
				{
					$items[$item->id]['type']    = $item->type;
					$items[$item->id]['name']    = isset($item->name) ? $item->name : '';
					$items[$item->id]['picture'] = base64_encode(isset($item->picture) ? $item->picture : '');
					$items[$item->id]['link']    = base64_encode(isset($item->link) ? $item->link : '');
					$items[$item->id]['source']  = base64_encode(isset($item->source) ? $item->source : '');
					$items[$item->id]['likes']   = isset($item->likes->summary->total_count) ? $item->likes->summary->total_count : 0;
					$items[$item->id]['created'] = $item->created_time;
				}
			}
		}
		else
		{
			throw new \RuntimeException(JText::_('COM_FBIMPORTER_CANNOT_GET_DATA'));
		}

		foreach ($ids as $id)
		{
			// Reset article
			$table->id           = null;
			$table->created      = null;
			$table->publish_up   = null;
			$table->publish_down = null;

			// Get item
			$item = $items[$id];

			$date = DateHelper::getDate($item['created']);

			// Get format
			$sample = isset($item['format']) ? $item['format'] : $params->get('format', 1);

			if (!$format->load($sample))
			{
				throw new \RuntimeException(JText::_('COM_FBIMPORTER_CANNOT_GET_IMPORT_FORMAT'));
			}

			// Set article information
			$table->title     = $item['title'];
			$table->catid     = $item['catid'] ? $item['catid'] : $format->catid;
			$table->introtext = $this->replaceText($item, $format->introtext, $id);
			$table->fulltext  = $this->replaceText($item, $format->fulltext, $id);
			$table->created    = $params->get('sort_by_current', 0) ? DateHelper::getDate()->toSQL(true) : $date->toSQL(true);
			$table->alias      = JFilterOutput::stringURLSafe($table->title . ' ' . $date->format('Y-m-d-H-i-s', true));
			$table->state      = $format->published;
			$table->hits       = 0;
			$table->created_by = JFactory::getUser()->get('id');
			$table->language   = $format->language;

			// Save
			$app = JFactory::getApplication();

			$app->triggerEvent('onContentBeforeSave', array('com_content.form', $table, true));

			$table->store();

			$app->triggerEvent('onContentAfterSave', array('com_content.form', $table, true));
		}

		return true;
	}

	/**
	 * saveAsCombined
	 *
	 * @param array $items
	 * @param array $cids
	 *
	 * @throws  RuntimeException
	 * @return  boolean
	 */
	public function saveAsCombined($items, $cids)
	{
		$params = JComponentHelper::getParams('com_fbimporter');
		$format = $this->getTable('Format');
		$table  = JTable::getInstance('Content');
		$sample = $this->state->get('combined.sample', $params->get('combined_sample', 2));
		$params = JComponentHelper::getParams('com_fbimporter');

		if (!$format->load($sample))
		{
			throw new \RuntimeException(JText::_('COM_FBIMPORTER_CANNOT_GET_IMPORT_FORMAT'));
		}

		$catid = $this->state->get('combined.catid', $params->get('combined_catid', $format->catid));

		$sample_intro = $format->introtext;
		$sample_full  = $format->fulltext;

		$temp = TempHelper::getPath();

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

				$item->id = explode('_', $item->id);
				$item->id = $item->id[1];

				if (isset($items[$item->id]))
				{
					$items[$item->id]['type']    = $item->type;
					$items[$item->id]['name']    = isset($item->name) ? $item->name : '';
					$items[$item->id]['picture'] = base64_encode(isset($item->picture) ? $item->picture : '');
					$items[$item->id]['link']    = base64_encode(isset($item->link) ? $item->link : '');
					$items[$item->id]['source']  = base64_encode(isset($item->source) ? $item->source : '');
					$items[$item->id]['likes']   = isset($item->likes->summary->total_count) ? $item->likes->summary->total_count : 0;
					$items[$item->id]['created'] = $item->created_time;
				}
			}
		}
		else
		{
			throw new \RuntimeException(JText::_('COM_FBIMPORTER_CANNOT_GET_DATA'));
		}

		// Sort
		// ========================================================================
		$ids = array();
		$key = $this->state->get('combined.sort', $params->get('combined_sort', 'likes'));

		foreach ($cids as $cid)
		{
			$ids[$cid] = $items[$cid][$key];
		}

		if ($this->state->get('combined.dir', $params->get('combined_dir', 'desc')) == 'desc')
		{
			asort($ids);
		}
		else
		{
			arsort($ids);
		}

		$posts = array();

		foreach ($ids as $cid => $id)
		{
			// Get item
			$item = $items[$cid];

			$posts[] = $this->replaceText($item, $sample_full, $cid);
		}

		// reset article
		$table->id             = null;
		$table->created        = null;
		$table->published_up   = null;
		$table->published_down = null;

		$table->title      = $params->get('combined_article_title', 'A Combined Article');
		$table->alias      = JFilterOutput::stringURLSafe('content-from-facebook-' . uniqid());
		$table->introtext  = $sample_intro;
		$table->fulltext   = implode("\n", $posts);
		$table->state      = 0;
		$table->hits       = 0;
		$table->catid      = $catid;
		$table->created_by = JFactory::getUser()->get('id');

		$table->store();

		$this->state->set('content.id', $table->id);

		return true;
	}

	/**
	 * replaceText
	 *
	 * @param \stdClass $item
	 * @param string    $text
	 * @param integer   $id
	 *
	 * @return  string
	 */
	public function replaceText($item, $text, $id)
	{
		$date = DateHelper::getDate('now');
		$params = $this->getParams();

		// Video type
		$link     = base64_decode($item['link']);
		$r        = $this->handleVideoType($link);
		$platform = $r['platform'];
		$vid      = $r['vid'];

		// Handel message
		$message = nl2br($item['message']);
		$message = str_replace("\n", '', $message);
		$message = str_replace("\r", '', $message);
		$message = explode('<br /><br />', $message);
		$intro   = array_shift($message);
		$full    = implode('<br /><br />', $message);

		// Handle image
		$uri   = JUri::getInstance(base64_decode($item['picture']));
		$width = $params->get('image_width', 550);
		$image = $uri->getVar('url');

		if (!$image)
		{
			$image = str_replace('_s.', '_n.', base64_decode($item['picture']));
		}

		$width = $width ? $width . 'px' : '';
		$image = '<img src="' . $image . '" alt="' . $item['title'] . '" style="max-width: ' . $width . ';" />';

		// Set replaces
		$replace['{TITLE}']         = $item['title'];
		$replace['{VIDEO}']         = $vid ? "{{$platform}}$vid{/{$platform}}" : $vid;
		$replace['{INTRO_MESSAGE}'] = $this->addLink($intro);
		$replace['{IMAGE}']         = $image;
		$replace['{LINK_URL}']      = $link;
		$replace['{FULL_MESSAGE}']  = $this->addLink($full);
		$replace['{READMORE_LINK}'] = "http://www.facebook.com/" . $params->get('fb_uid') . "/posts/$id";
		$replace['{LINK_NAME}']     = $item['name'];
		$replace['{LIKES}']         = $item['likes'];
		$replace['{CREATED_TIME}']  = $date->toSQL(true);

		$text = strtr($text, $replace);

		return $text;
	}

	/**
	 * handleVideoType
	 *
	 * @param string $link
	 *
	 * @return  mixed
	 */
	public function handleVideoType($link)
	{
		if (strpos($link, 'youtube'))
		{
			$platform = 'youtube';
			$uri      = JUri::getInstance($link);
			$vid      = $uri->getVar('v');
		}
		elseif (strpos($link, 'vimeo'))
		{
			$platform = 'vimeo';
			$uri      = JUri::getInstance($link);
			$vid      = $uri->getPath();
			$vid      = trim($vid, '/');
		}
		else
		{
			$platform = 'unknown';
			$vid      = null;
		}

		$r['platform'] = $platform;
		$r['vid']      = $vid;

		return $r;
	}

	/**
	 * addLink
	 *
	 * @param string $str
	 *
	 * @return  mixed
	 */
	function addLink($str)
	{
		/*
		 * Convert URL to link.
		 *
		 * Code from: http://stackoverflow.com/questions/12538358#answer-12590772
		 */
		return preg_replace('$(https?://[a-z0-9_./?=&#-]+)(?![^<>]*>)$i', ' <a href="$1" target="_blank">$1</a> ', $str . " ");
	}
}
 