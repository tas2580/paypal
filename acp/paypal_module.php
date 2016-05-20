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

	/** @var \phpbb\user */
	protected $user;

	public function main($id, $mode)
	{
		global $config, $db, $user, $template, $table_prefix, $request, $phpbb_root_path, $phpEx;

		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;

		$user->add_lang_ext('tas2580/paypal', 'common');

		$sql = 'SELECT *
			FROM ' . $table_prefix . 'paypal_config';
		$result = $db->sql_query($sql);
		$paypal_config = $db->sql_fetchrow($result);

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'acp_paypal_body';
				$this->page_title = $user->lang('ACP_PAYPAL_TITLE');

				add_form_key('acp_paypal');

				// delete amount
				if ($request->is_set('delete'))
				{
					$id = $request->variable('delete', 0);
					if (confirm_box(true))
					{
						$sql = 'DELETE FROM ' . $table_prefix . 'paypal_amount WHERE amount_id = ' . (int) $id;
						$result = $db->sql_query($sql);
						trigger_error($user->lang['AMOUNT_DELETED'] . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'action'	=> 'delete',
							'id'		=> $id))
						);
					}
				}

				$error = array();
				// Form is submitted
				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('acp_paypal'))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$data['paypal_email'] = $request->variable('paypal_email', '', true);
					$data['paypal_sandbox'] = $request->variable('paypal_sandbox', 0);
					$data['paypal_currency'] = $request->variable('paypal_currency', '');
					$data['paypal_title'] = $request->variable('paypal_title', '', true);
					$data['paypal_text'] = $request->variable('paypal_text', '', true);

					// Validate user input
					$validate_array = array(
						'paypal_email'				=> array('email'),
						'paypal_title'				=> array('string', true, 0, 255),
					);

					if (!function_exists('validate_data'))
					{
						include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
					}
					$error = validate_data($data, $validate_array);

					if (!sizeof($error))
					{
						$bbcode_options = 7;
						generate_text_for_storage($data['paypal_text'], $bbcode_uid, $bbcode_bitfield, $bbcode_options, true, true, true);

						$sql_data = array(
							'paypal_email'				=> $data['paypal_email'],
							'paypal_title'				=> $data['paypal_title'],
							'paypal_currency'			=> $data['paypal_currency'],
							'paypal_text'				=> $data['paypal_text'],
							'bbcode_uid'				=> $bbcode_uid,
							'bbcode_bitfield'			=> $bbcode_bitfield,
							'paypal_sandbox'			=> $data['paypal_sandbox'],
						);
						$sql = 'UPDATE ' . $table_prefix . 'paypal_config SET
							' . $db->sql_build_array('UPDATE', $sql_data);

						$db->sql_query($sql);
						trigger_error($user->lang('ACP_SAVED') . adm_back_link($this->u_action));
					}
					else
					{
						$template->assign_vars(array(
							'ERROR'						=> implode('<br />', $error),
							'U_ACTION'					=> $this->u_action,
							'PAYPAL_EMAIL'				=> $data['paypal_email'],
							'PAYPAL_TITLE'				=> $data['paypal_title'],
							'PAYPAL_SANDBOX'			=> $data['paypal_sandbox'],
							'PAYPAL_TEXT'				=> $data['paypal_text'],
							'CURRENCY_CODE'				=> $this->currency_code_select($data['paypal_currency']),
						));
					}
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
						'U_DELETE'	=> $this->u_action . '&delete=' . $row['amount_id'],
					));
				}

				if (!sizeof($error))
				{
					$paypal_text = generate_text_for_edit($paypal_config['paypal_text'], $paypal_config['bbcode_uid'], $paypal_config['bbcode_bitfield']);

					$template->assign_vars(array(
						'U_ACTION'					=> $this->u_action,
						'PAYPAL_EMAIL'				=> $paypal_config['paypal_email'],
						'PAYPAL_TITLE'				=> $paypal_config['paypal_title'],
						'PAYPAL_SANDBOX'			=> $paypal_config['paypal_sandbox'],
						'PAYPAL_TEXT'				=> $paypal_text['text'],
						'CURRENCY_CODE'				=> $this->currency_code_select($paypal_config['paypal_currency']),
					));
				}

				break;

			case 'items':
				$this->tpl_name = 'acp_paypal_items_body';
				$this->page_title = $user->lang('ACP_PAYPAL_ITEMS');

				$item_id = $request->variable('item_id', 0);
				$action    = $request->variable('action', '');
				switch ($action)
				{
					case 'add':
						add_form_key('acp_paypal');
						$template->assign_vars(array(
							'ITEM_FORM_NAME'		=> $this->user->lang('ACP_ADD_ITEM'),
							'U_ACTION'				=> $this->u_action . '&amp;action=add',
							'S_FORM'				=> true,
							'ITEM_NAME'				=> $request->variable('item_name', '', true),
						));
						break;

					case 'edit':
						add_form_key('acp_paypal');
						$sql = 'SELECT *
							FROM ' . $table_prefix . 'paypal_items
							WHERE item_id = ' . (int) $item_id;
						$result = $db->sql_query($sql);
						$data = $db->sql_fetchrow($result);

						$item_text = generate_text_for_edit($data['item_text'], $data['bbcode_uid'], $data['bbcode_bitfield']);

						$template->assign_vars(array(
							'ITEM_FORM_NAME'		=> $this->user->lang('ACP_EDIT_ITEM'),
							'U_ACTION'				=> $this->u_action . '&amp;action=edit&amp;item_id=' . $data['item_id'],
							'S_FORM'				=> true,
							'ITEM_NAME'				=> $data['item_name'],
							'ITEM_TEXT'				=> $item_text['text'],
						));
						break;

					case 'delete':

						if (confirm_box(true))
						{
							$sql = 'DELETE FROM ' . $table_prefix . 'paypal_items WHERE item_id = ' . (int) $item_id;
							$result = $db->sql_query($sql);
							trigger_error($user->lang['ITEM_DELETED'] . adm_back_link($this->u_action));
						}
						else
						{
							confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
								'action'		=> 'delete',
								'i'				=> $id,
								'item_id'		=> $item_id))
							);
						}

						break;
				}
				switch ($action)
				{
					case 'add':
					case 'edit':

						// Form is submitted
						if ($request->is_set_post('submit'))
						{
							if (!check_form_key('acp_paypal'))
							{
								trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
							}
							$data['item_name'] = $request->variable('item_name', '', true);
							$data['item_text'] = $request->variable('item_text', '', true);

							// Validate user input
							$validate_array = array(
								'item_name'				=> array('string', false, 1, 255),
								'item_text'				=> array('string', false, 1, 99999),
							);

							if (!function_exists('validate_data'))
							{
								include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
							}
							$error = validate_data($data, $validate_array);
							if (!sizeof($error))
							{
								$bbcode_options = 7;
								generate_text_for_storage($data['item_text'], $bbcode_uid, $bbcode_bitfield, $bbcode_options, true, true, true);
								$sql_data = array(
									'item_name'			=> $data['item_name'],
									'item_text'			=> $data['item_text'],
									'bbcode_uid'		=> $bbcode_uid,
									'bbcode_bitfield'	=> $bbcode_bitfield,
								);
								if ($action == 'add')
								{
									$sql = 'INSERT INTO ' . $table_prefix . 'paypal_items
										' . $db->sql_build_array('INSERT', $sql_data);
									$db->sql_query($sql);
									trigger_error($user->lang('ACP_ITEM_ADD_SUCCESS') . adm_back_link($this->u_action));
								}
								else if ($action == 'edit')
								{
									$sql = 'UPDATE ' . $table_prefix . 'paypal_items SET
										' . $db->sql_build_array('UPDATE', $sql_data) .'
										WHERE item_id = ' . (int) $item_id;
									$db->sql_query($sql);
									trigger_error($user->lang('ACP_ITEM_EDIT_SUCCESS') . adm_back_link($this->u_action));
								}
							}
							else
							{
								$template->assign_vars(array(
									'ERROR'			=> implode('<br />', $error),
									'ITEM_NAME'		=> $data['item_name'],
									'ITEM_TEXT'		=> $data['item_text'],
								));
							}
						}
						break;

					default:
						$ammount = array();
						$sql = 'SELECT item_id, donation_amount
							FROM ' . $table_prefix . 'paypal_donations
							ORDER BY item_name';
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							if (isset($ammount[$row['item_id']]))
							{
								$ammount[$row['item_id']] += $row['donation_amount'];
							}
							else
							{
								$ammount[$row['item_id']] = $row['donation_amount'];
							}
						}

						$sql = 'SELECT item_name, item_id
							FROM ' . $table_prefix . 'paypal_items
							ORDER BY item_name';
						$result = $db->sql_query($sql);
						while ($row = $db->sql_fetchrow($result))
						{
							$template->assign_block_vars('items', array(
								'ITEM'		=> $row['item_name'],
								'AMMOUNT'	=> (isset($ammount[$row['item_id']]) ? number_format($ammount[$row['item_id']], 2) : '0.00') . ' ' . $paypal_config['paypal_currency'],
								'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;item_id=' . $row['item_id'],
								'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;item_id=' . $row['item_id'],
							));
						}
						$template->assign_vars(array(
								'U_ACTION'					=> $this->u_action . '&amp;action=add',
						));

						break;
				}

				break;

			case 'donations':
				$this->tpl_name = 'acp_paypal_donations_body';
				$this->page_title = $user->lang('ACP_PAYPAL_DONATIONS');

				$action    = $request->variable('action', '');
				if ($action == 'delete')
				{
					$donation_id = $request->variable('donation_id', 0);
					if (confirm_box(true))
					{
						$sql = 'DELETE FROM ' . $table_prefix . 'paypal_donations WHERE donation_id = ' . (int) $donation_id;
						$result = $db->sql_query($sql);
						trigger_error($user->lang['DONATION_DELETED'] . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'action'		=> 'delete',
							'i'				=> $id,
							'donation_id'	=> $donation_id))
						);
					}
				}

				$sql_array = array(
					'SELECT'		=> 'd.*, u.user_id, u.username, u.user_colour, i.item_name',
					'FROM'			=> array($table_prefix . 'paypal_donations' => 'd'),
					'LEFT_JOIN'		=> array(
						array(
							'FROM'		=> array(USERS_TABLE => 'u'),
							'ON'		=> 'u.user_id = d.user_id'
						),
						array(
							'FROM'		=> array($table_prefix . 'paypal_items' => 'i'),
							'ON'		=> 'i.item_id = d.item_id'
						)
					),
					'ORDER_BY'		=> 'd.donation_time DESC',
				);
				$sql = $db->sql_build_query('SELECT', $sql_array);
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('donations', array(
						'USER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'ITEM'		=> $row['item_name'],
						//'USER'		=> $row['item_name'],
						'TIME'		=> $this->user->format_date($row['donation_time']),
						'AMOUNT'	=> number_format($row['donation_amount'], 2) . ' ' . $paypal_config['paypal_currency'],
						'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;donation_id=' . $row['donation_id'],
					));
				}
				$template->assign_vars(array(
					'S_CURL'					=> function_exists('curl_init'),
				));
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
