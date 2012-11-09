<?php
/**
 * @package     Polls
 * @subpackage  com_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Polls helper.
 *
 * @package     Polls
 * @subpackage  com_polls
 * @since       1.6
 */
class PollsHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName = 'polls')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_POLLS_SUBMENU_POLLS'),
			'index.php?option=com_polls&view=polls',
			$vName == 'polls'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_POLLS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_polls',
			$vName == 'categories'
		);

		if ($vName == 'categories')
		{
			JToolbarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_polls')),
				'polls-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   int  $categoryId  The category ID.
	 *
	 * @return  JObject  A JObject containing the allowed actions.
	 *
	 * @since   1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		if (empty($categoryId))
		{
			$assetName = 'com_polls';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_polls.category.' . (int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_polls', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;
	}

	/**
	 * Get a list of filter options for the .
	 *
	 * @return  array  An array of JHtmlOption elements.
	 *
	 * @return  1.6
	 */
	public static function getPollOptions()
	{
		// Initialize variables.
		$options = array();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id AS value, name AS text');
		$query->from('#__polls AS a');
		$query->order('a.name');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		return $options;
	}
}
