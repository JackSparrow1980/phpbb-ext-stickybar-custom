<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\stickybar\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener for UCP related actions
*/
class ucp_listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language */
	protected $language;

	/**
	* Constructor
	*
	* @param \phpbb\config\config $config
	* @param \phpbb\request\request $request
	* @param \phpbb\template\template $template
	* @param \phpbb\user $user
	* @access public
	*/
	public function __construct(\phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language)
	{
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->language		= $language;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_user_setup'					=> 'load_lang',
			'core.ucp_prefs_personal_data'			=> 'ucp_prefs_get_data',
			'core.ucp_prefs_personal_update_data'	=> 'ucp_prefs_set_data',
		);
	}

	/**
	* Get user's option and display it in UCP Prefs View page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function ucp_prefs_get_data($event)
	{
		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], array(
			'stickybar'	=> $this->request->variable('stickybar', (int) $this->user->data['stickybar']),
		));

		// Output the data vars to the template (except on form submit)
		if (!$event['submit'])
		{
			$this->language->add_lang('stickybar_ucp', 'hifikabin/stickybar');
			$this->template->assign_vars(array(
				'USER_STICKYBAR'	=> $event['data']['stickybar'],
			));
		}
	}

	/**
	* Add user's Stickybar option state into the sql_array
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'stickybar' => $event['data']['stickybar'],
		));
	}
}
