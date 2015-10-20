<?php
/**
*
* @package phpBB Extension - Paypal
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tas2580\paypal\controller;

class main
{
	/* @var \phpbb\config\config */
	protected $config;
	/* @var \phpbb\db\driver\driver */
	protected $db;
	/* @var \phpbb\controller\helper */
	protected $helper;
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, $table_amount)
	{
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->table_amount = $table_amount;
	}
	/**
	* Controller for route /paypal
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function handle()
	{
		$this->user->add_lang_ext('tas2580/paypal', 'common');

		$amount_list = '';
		$sql = 'SELECT *
			FROM ' . $this->table_amount . '
			ORDER BY amount_value';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$amount_list .= '<option value="' . number_format($row['amount_value'] / 100, 2) . '">' . number_format($row['amount_value'] / 100, 2) . '</option>';
		}

		$this->template->assign_vars(array(
			'PAYPAL_DESCRIPTION'		=> isset($this->config['paypal_description']) ? $this->config['paypal_description'] : '',
			'PAYPAL_DEFAULT_ITEM'		=> isset($this->config['paypal_default_item']) ? $this->config['paypal_default_item'] : '',
			'PAYPAL_EMAIL'				=> isset($this->config['paypal_email']) ? $this->config['paypal_email'] : '',
			'AMOUNT_LIST'				=> $amount_list,
			'CURRENCY_CODE'			=> $this->currency_code_select($this->config['currency_code']),
		));
		return $this->helper->render('paypal_body.html', $this->user->lang['PAYPAL']);
	}

	private function currency_code_select($sel)
	{
		$codes = array(
			'USD'	=> $this->user->lang('DONATION_USD'),
			'EUR'		=> $this->user->lang('DONATION_EUR'),
			'GBP'	=> $this->user->lang('DONATION_GBP'),
			'JPY'		=> $this->user->lang('DONATION_JPY'),
			'AUD'	=> $this->user->lang('DONATION_AUD'),
			'CAD'	=> $this->user->lang('DONATION_CAD'),
			'HKD'	=> $this->user->lang('DONATION_HKD'),
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
