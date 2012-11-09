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
 * View to edit a poll.
 *
 * @package     Polls
 * @subpackage  com_polls
 * @since       1.6
 */
class PollsViewPoll extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	protected $answers;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form    = $this->get('Form');
		$this->item    = $this->get('Item');
		$this->state   = $this->get('State');
		$this->answers = $this->get('Answers');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user       = JFactory::getUser();
		$userId     = $user->get('id');
		$isNew      = ($this->item->id == 0);
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

		// Since we don't track these assets at the item level, use the category id.
		$canDo      = PollsHelper::getActions($this->item->catid, 0);

		JToolbarHelper::title($isNew ? JText::_('COM_POLLS_MANAGER_POLL_NEW') : JText::_('COM_POLLS_MANAGER_POLL_EDIT'), 'poll.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || (count($user->getAuthorisedCategories('com_polls', 'core.create')))))
		{
			JToolbarHelper::apply('poll.apply');
			JToolbarHelper::save('poll.save');
		}

		if (!$checkedOut && (count($user->getAuthorisedCategories('com_polls', 'core.create'))))
		{
			JToolbarHelper::save2new('poll.save2new');
		}

		// If an existing item, can save to a copy.
		if (!$isNew && (count($user->getAuthorisedCategories('com_polls', 'core.create')) > 0))
		{
			JToolbarHelper::save2copy('poll.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('poll.cancel');
		}
		else
		{
			JToolbarHelper::cancel('poll.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolBarHelper::help('poll', $com = true);
	}
}
