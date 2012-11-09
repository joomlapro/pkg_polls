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
 * Answer Table class
 *
 * @package     Polls
 * @subpackage  com_polls
 * @since       1.6
 */
class PollsTableAnswer extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  Driver A database connector object.
	 *
	 * @since   1.6
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__polls_answers', 'id', $db);
	}
}
