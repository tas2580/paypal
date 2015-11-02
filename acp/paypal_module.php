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
		global $config, $db, $user, $template, $table_prefix, $request;

		$user->add_lang_ext('tas2580/paypal', 'common');

		switch ($mode)
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
					$config->set('currency_code', $request->variable('currency_code', ''));

					trigger_error($user->lang('ACP_SAVED') . adm_back_link($this->u_action));
				}

				// Form is submitted
				if ($request->is_set_post('submit_amount'))
				{
					$add_amount = $request->variable('add_amount', 0);
					$sql_data = array(
						'amount_value'			=> $add_amount,
					);
					$sql = 'INSERT INTO ' . $table_prefix . 'paypal_amount
						' . $db->sql_build_array('INSERT', $sql_data);
					$db->sql_query($sql);
					trigger_error($user->lang('ACP_SAVED') . adm_back_link($this->u_action));
				}

				$sql = 'SELECT *
					FROM ' . $table_prefix . 'paypal_amount
					ORDER BY amount_value';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('amounts', array(
						'AMOUNT'		=> number_format($row['amount_value'] / 100, 2),
					));
				}

				$template->assign_vars(array(
					'U_ACTION'				=> $this->u_action,
					'PAYPAL_EMAIL'				=> isset($config['paypal_email']) ? $config['paypal_email'] : '',
					'PAYPAL_DEFAULT_ITEM'		=> isset($config['paypal_default_item']) ? $config['paypal_default_item'] : '',
					'PAYPAL_DESCRIPTION'		=> isset($config['paypal_description']) ? $config['paypal_description'] : '',
					'SEL_CURRENCY_CODE'		=> isset($config['currency_code']) ? $user->lang('DONATION_' . $config['currency_code']) : '',
					'CURRENCY_CODE'			=> $this->currency_code_select($config['currency_code']),
				));

				break;

			case 'items':
				$this->tpl_name = 'acp_paypal_items_body';
				$this->page_title = $user->lang('ACP_PAYPAL_ITEMS');
				break;
		}
	}

	private function currency_code_select($sel)
	{
		global $user;
		$codes = array(
			'AUD'	=> $user->lang('DONATION_AUD'),
			'CAD'	=> $user->lang('DONATION_CAD'),
			'CHF'		=> $user->lang('DONATION_CHF'),
			'CZK'		=> $user->lang('DONATION_CZK'),
			'DKK'		=> $user->lang('DONATION_DKK'),
			'EUR'		=> $user->lang('DONATION_EUR'),
			'GBP'	=> $user->lang('DONATION_GBP'),
			'HKD'	=> $user->lang('DONATION_HKD'),
			'HUF'		=> $user->lang('DONATION_HUF'),
			'ILS'		=> $user->lang('DONATION_ILS'),
			'JPY'		=> $user->lang('DONATION_JPY'),
			'MXN'	=> $user->lang('DONATION_MXN'),
			'NOK'	=> $user->lang('DONATION_NOK'),
			'NZD'	=> $user->lang('DONATION_NZD'),
			'PLN'		=> $user->lang('DONATION_PLN'),
			'SEK'		=> $user->lang('DONATION_SEK'),
			'SGD'	=> $user->lang('DONATION_SGD'),
			'USD'	=> $user->lang('DONATION_USD'),
		);

		$retrun = '';
		foreach ($codes as $value => $title)
		{
			$selected = ($value == $sel) ? ' selected="selected"' : '';
			$retrun .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		return $retrun;
	}
}
