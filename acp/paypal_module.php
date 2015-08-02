<?php
/**
*
* @package phpBB Extension - tas2580 Paypal
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tas2580\paypal\acp;

class paypal_module
{
	var $u_action;

	public function main($id, $mode)
	{
		global $config, $user, $template, $request;

		$user->add_lang_ext('tas2580/paypal', 'common');


		switch($mode)
		{
			case 'settings':
				$this->tpl_name = 'acp_paypal_body';
				$this->page_title = $user->lang('ACP_PAYPAL_TITLE');

				add_form_key('acp_paypal');

				// Form is submitted
				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('acp_paypal'))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$config->set('paypal_email', $request->variable('paypal_email', ''));
					$config->set('paypal_default_item', $request->variable('paypal_default_item', ''));
					$config->set('paypal_description', $request->variable('paypal_description', ''));

					trigger_error($user->lang('ACP_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars(array(
					'U_ACTION'				=> $this->u_action,
					'PAYPAL_EMAIL'				=> isset($config['paypal_email']) ? $config['paypal_email'] : '',
					'PAYPAL_DEFAULT_ITEM'		=> isset($config['paypal_default_item']) ? $config['paypal_default_item'] : '',
					'PAYPAL_DESCRIPTION'		=> isset($config['paypal_description']) ? $config['paypal_description'] : '',
				));

				break;

			case 'items':
				$this->tpl_name = 'acp_paypal_items_body';
				$this->page_title = $user->lang('ACP_PAYPAL_ITEMS');


				break;
		}


	}
}
