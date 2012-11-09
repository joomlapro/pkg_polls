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
 * Polls Component Category Tree
 *
 * @static
 * @package     Polls
 * @subpackage  com_polls
 * @since       1.6
 */
class PollsCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   1.6
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__polls';
		$options['extension'] = 'com_polls';
		$options['statefield'] = 'state';
		$options['countItems'] = 1;

		parent::__construct($options);
	}
}
