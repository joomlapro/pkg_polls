<?php
/**
 * @package     Polls
 * @subpackage  mod_polls
 * @copyright   Copyright (C) 2012 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Polls module helper.
 *
 * @package     Polls
 * @subpackage  mod_polls
 * @since       1.6
 */
abstract class ModPollsHelper
{
	/**
	 * Get a list of the answer items.
	 *
	 * @param   JRegistry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   1.6
	 */
	public static function getAnswers(&$params)
	{
		// Create query object
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Prepare query.
		$query->select('a.id, a.name, a.color, a.votes');
		$query->from('#__polls_answers AS a');
		$query->where('a.poll_id = ' . (int) $params->get('poll'));
		$query->order('a.ordering ASC');

		// Inject the query and load the items.
		$db->setQuery($query);
		$items = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
			return null;
		}

		return $items;
	}

	/**
	 * Get a list of the poll items.
	 *
	 * @param   JRegistry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   1.6
	 */
	public static function getPoll(&$params)
	{
		// Create query object
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Prepare query.
		$query->select('a.id, a.name');
		$query->from('#__polls AS a');
		$query->where('id = ' . (int) $params->get('poll'));
		$query->where('a.state = 1');

		// Inject the query and load the items.
		$db->setQuery($query);
		$items = $db->loadObject();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
			return null;
		}

		return $items;
	}

	/**
	 * Get a list of the total of answer.
	 *
	 * @param   JRegistry  &$params  The module options.
	 *
	 * @return  array
	 *
	 * @since   1.6
	 */
	public static function getTotal(&$params)
	{
		// Create query object
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Prepare query.
		$query->select('SUM(a.votes) AS total');
		$query->from('#__polls_answers AS a');
		$query->where('a.poll_id = ' . (int) $params->get('poll'));

		// Inject the query and load the items.
		$db->setQuery($query);
		$items = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
			return null;
		}

		return $items;
	}
}
