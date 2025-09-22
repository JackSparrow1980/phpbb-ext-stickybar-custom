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
* Event listener
*/

class listener implements EventSubscriberInterface
{
	protected $ext_manager;

	protected $path_helper;

	protected $user;

	protected $template;

	protected $config;
	
	protected $ext_path;
	
	protected $ext_path_web;

	public function __construct(
		\phpbb\extension\manager $ext_manager,
		\phpbb\path_helper $path_helper,
		\phpbb\user $user,
		\phpbb\template\template $template,
		\phpbb\config\config $config)
	{
		$this->ext_manager	= $ext_manager;
		$this->path_helper	= $path_helper;
		$this->user			= $user;
		$this->template		= $template;
		$this->config		= $config;
		$this->ext_path		= $this->ext_manager->get_extension_path('hifikabin/stickybar', true);
		$this->ext_path_web	= $this->path_helper->update_web_root_path($this->ext_path);
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'	=> 'add_page_header_link',
		);
	}

	public function add_page_header_link($event)
	{
		$this->template->assign_vars(array(
		'S_STICKY_PATH'			=> $this->ext_path_web,
		'STICKYBAR_COLOUR'		=> $this->config['stickybar_colour'],
		'STICKYBAR_TEXT_COLOUR'	=> $this->config['stickybar_text_colour'],
		'STICKYBAR_SEARCH'		=> $this->config['stickybar_search'],
		'STICKYBAR_SELECT'		=> $this->config['stickybar_select'],
		'STICKYBAR_LOGO'		=> $this->config['stickybar_logo'],
		'STICKYBAR_LEFT'		=> $this->config['stickybar_left'],
		'STICKYBAR_TOP'			=> $this->config['stickybar_top'] ,
		'USER_STICKYBAR'		=> $this->user->data['stickybar'],
		));
	}
}
