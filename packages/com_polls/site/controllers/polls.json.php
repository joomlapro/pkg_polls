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
 * Polls JSON controller for Polls Component.
 *
 * @package     Polls
 * @subpackage  com_finder
 * @since       2.5
 */
class PollsControllerPolls extends JControllerLegacy
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('poll', 'getPoll');
	}

	/**
	 * Method to get poll answers.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function getPoll()
	{
		// Initialiase variables.
		$app = JFactory::getApplication();
		$input = $app->input;

		$pollId = $input->getInt('poll');
		$answerId = $input->getInt('answer');

		if (isset($pollId) && isset($answerId))
		{
			// Include dependancies.
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_polls/tables');

			// Get an instance of the affiliate table
			$table = JTable::getInstance('Answer', 'PollsTable');

			if ($table->load(array('id' => $answerId, 'poll_id' => $pollId)))
			{
				$table->votes++;

				// Store the data.
				if (!$table->store())
				{
					$this->setError($table->getError());
					return false;
				}
			}
		}

		// Create query object
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Prepare query.
		$query->select('SUM(a.votes) AS total');
		$query->from('#__polls_answers AS a');

		if ($pollId)
		{
			$query->where('a.poll_id = ' . (int) $pollId);
		}

		// Inject the query and load the items.
		$db->setQuery($query);
		$total = $db->loadResult();

		$return = array();

		// Initialiase variables.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Prepare query.
		$query->select('a.id, a.name, a.color, a.votes');
		$query->from('#__polls_answers AS a');
		$query->order('a.ordering ASC');

		if ($pollId)
		{
			$query->where('a.poll_id = ' . (int) $pollId);
		}

		// Inject the query and load the result.
		$db->setQuery($query);
		$return = $db->loadAssocList();

		foreach ($return as $key => $value)
		{
			$return[$key] = array_merge($value, array('total' => $total));
		}

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
			return null;
		}

		// Check the data.
		if (empty($return))
		{
			$return = array();
		}

		// Use the correct json mime-type
		header('Content-Type: application/json');

		// Send the response.
		echo json_encode($return);

		JFactory::getApplication()->close();
	}
}
