<?php
/**
*
* @package phpBB Extension - Sticky Bar
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\stickybar\acp;

class stickybar_module
{
var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $phpbb_log, $config, $language;

		$this->tpl_name		= 'acp_stickybar_config';
		$this->page_title	= $user->lang('STICKYBAR_CONFIG');
		$form_name			= 'acp_stickybar_config';
		$this->language		= $language;

		$this->language->add_lang('common', 'hifikabin/stickybar');

		add_form_key($form_name);

		$submit = $request->is_set_post('submit');
		if ($submit)
		{
			if (!check_form_key('acp_stickybar_config'))
			{
				trigger_error('FORM_INVALID');
			}
			$config->set('stickybar_colour', $request->variable('stickybar_colour', ''));
			$config->set('stickybar_text_colour', $request->variable('stickybar_text_colour', ''));
			$config->set('stickybar_search', $request->variable('stickybar_search', 0));
			$config->set('stickybar_select', $request->variable('stickybar_select', 0));
			$config->set('stickybar_logo', $request->variable('stickybar_logo', ''));
			$config->set('stickybar_left', $request->variable('stickybar_left', 0));
			$config->set('stickybar_top', $request->variable('stickybar_top', 0));

			$user_id = $user->data['user_id'];
			$user_ip = $user->ip;

			$phpbb_log->add('admin', $user_id, $user_ip, 'LOG_STICKYBAR_SAVE');
			trigger_error($user->lang('STICKYBAR_SAVED') . adm_back_link($this->u_action));
		}
		$template->assign_vars(array(
			'STICKYBAR_COLOUR'			=> $config['stickybar_colour'],
			'STICKYBAR_TEXT_COLOUR'		=> $config['stickybar_text_colour'],
			'STICKYBAR_SEARCH'			=> $config['stickybar_search'],
			'STICKYBAR_SELECT'			=> $config['stickybar_select'],
			'STICKYBAR_LOGO'			=> $config['stickybar_logo'],
			'STICKYBAR_LEFT'			=> $config['stickybar_left'],
			'STICKYBAR_TOP'				=> $config['stickybar_top'],
			'U_ACTION'					=> $this->u_action,
		));
	}
}
