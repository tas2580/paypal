<?php
/**
*
* @package phpBB Extension - Paypal
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tas2580\paypal\controller;

use Symfony\Component\HttpFoundation\Response;

class main
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $table_amount, $table_config, $table_donations, $table_items)
	{
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->table_amount = $table_amount;
		$this->table_config = $table_config;
		$this->table_donations = $table_donations;
		$this->table_items = $table_items;
	}
	/**
	* Controller for route /paypal
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function page()
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

		$sql = 'SELECT *
			FROM ' . $this->table_items . '
			ORDER BY item_name';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('items', array(
				'ITEM_NAME'	=> $row['item_name'],
				'ITEM'		=> generate_text_for_display($row['item_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], 7),
				'ITEM_ID'	=> $row['item_id'],
			));
		}
		$sql = 'SELECT *
			FROM ' . $this->table_config;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$this->template->assign_vars(array(
			'PAYPAL_TITLE'				=> $row['paypal_title'],
			'PAYPAL_TEXT'				=> generate_text_for_display($row['paypal_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], 7),
			'PAYPAL_EMAIL'				=> $row['paypal_email'],
			'AMOUNT_LIST'				=> $amount_list,
			'PAYPAL_ACTION'				=> ($row['paypal_sandbox'] == 1) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr',
			'S_SANDBOX'					=> ($row['paypal_sandbox'] == 1) ? true : false,
			'S_CURL'					=> function_exists('curl_init'),
			'CURRENCY_CODE'				=> $this->currency_code_select($row['paypal_currency']),
			'CURRENCY'					=> $row['paypal_currency'],
			'USER_ID'					=> $this->user->data['user_id'],
			'IPN_URL'					=> $this->helper->route('tas2580_paypal_ipn', array(), true, '', \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
			'RETURN_URL'				=> $this->helper->route('tas2580_paypal_controller', array(), true, '', \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
		));
		return $this->helper->render('paypal_body.html', $row['paypal_title']);
	}


	/**
	 *
	 * https://github.com/paypal/ipn-code-samples/blob/master/paypal_ipn.php
	 *
	 * @return boolean
	 */
	public function ipn()
	{
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval)
		{
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
			{
				$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if (function_exists('get_magic_quotes_gpc'))
		{
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value)
		{
			if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
			{
				$value = urlencode(stripslashes($value));
			}
			else
			{
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}

		$sql = 'SELECT paypal_sandbox
			FROM ' . $this->table_config;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$paypal_url = ($row['paypal_sandbox'] == 1) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

		$ch = curl_init($paypal_url);
		if ($ch == false)
		{
			return false;
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);
		curl_close($ch);

		// Inspect IPN validation result and act accordingly
		// Split response headers and payload, a better way for strcmp
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp($res, 'VERIFIED') == 0)
		{
			$sql_data = array(
				'user_id'			=> (int) $this->request->variable('custom', '0'),
				'item_id'			=> (int) $this->request->variable('item_number', '0'),
				'item_name'			=> $this->request->variable('item_number', '', true),
				'donation_time'		=> time(),
				'donation_amount'	=> $this->request->variable('mc_gross', '0'),
			);

			$sql = 'INSERT INTO ' . $this->table_donations . '
				' . $this->db->sql_build_array('INSERT', $sql_data);
			$this->db->sql_query($sql);
		}

		$headers = array(
			'Content-Type'		=> 'application/xml; charset=UTF-8',
		);
		return new Response('', '200', $headers);
	}

	private function currency_code_select($sel)
	{
		$codes = array(
			'AUD'		=> $this->user->lang('DONATION_AUD'),
			'CAD'		=> $this->user->lang('DONATION_CAD'),
			'CHF'		=> $this->user->lang('DONATION_CHF'),
			'CZK'		=> $this->user->lang('DONATION_CZK'),
			'DKK'		=> $this->user->lang('DONATION_DKK'),
			'EUR'		=> $this->user->lang('DONATION_EUR'),
			'GBP'		=> $this->user->lang('DONATION_GBP'),
			'HKD'		=> $this->user->lang('DONATION_HKD'),
			'HUF'		=> $this->user->lang('DONATION_HUF'),
			'ILS'		=> $this->user->lang('DONATION_ILS'),
			'JPY'		=> $this->user->lang('DONATION_JPY'),
			'MXN'		=> $this->user->lang('DONATION_MXN'),
			'NOK'		=> $this->user->lang('DONATION_NOK'),
			'NZD'		=> $this->user->lang('DONATION_NZD'),
			'PLN'		=> $this->user->lang('DONATION_PLN'),
			'SEK'		=> $this->user->lang('DONATION_SEK'),
			'SGD'		=> $this->user->lang('DONATION_SGD'),
			'USD'		=> $this->user->lang('DONATION_USD'),
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
