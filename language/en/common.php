<?php
/**
*
* @package phpBB Extension - Paypal - Englisch
* @copyright (c) 2015 tas2580 (https://tas2580.net)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//
$lang = array_merge($lang, array(
	'PAYPAL'							=> 'Paypal Donation',
	'ACP_PAYPAL_TITLE'					=> 'Paypal-Settings',
	'ACP_PAYPAL_DEFAULT_ITEM'			=> 'Paypal-Description',
	'ACP_PAYPAL_DEFAULT_ITEM_EXPLAIN'	=> 'Please set your text, a description',
	'ACP_PAYPAL_EMAIL'					=> 'Paypal-E-Mail',
	'ACP_PAYPAL_EMAIL_EXPLAIN'			=> 'Set your Paypal-E-Mail here - example: xxxx@xxx.tld',
	'ACP_PAYPAL_DESCRIPTION'			=> 'Some text',
	'ACP_PAYPAL_DESCRIPTION_EXPLAIN'	=> 'You can set some text which is displayed into your board on the Paypal-Page.',
	'ACP_CURRENCY_CODE'					=> 'Currencies',
	'ACP_CURRENCY_CODE_EXPLAIN'			=> 'Choose the currency that is displayed by default in the drop-down-menu on your Paypalpage in your board. Currencies, you can add or remove into the common.php - Please adapt your statement on their own responsibility and with great care.',
	'ACP_SUBMIT'						=> 'Submit your settings',
	'ACP_AMOUNT_LIST'					=> 'Your amount list',
	'ACP_AMOUNT'						=> 'Your amounts',
	'ACP_ADD_AMOUNT'					=> 'Set your amounts here - example: 1000 the result is 10.00',
	'ACP_SETTINGS'						=> 'Set your Paypal-Information',
	'ACP_SAVED'							=> 'Your details have been stored',

	'PAYPAL_INFO'						=> 'Donate with PayPal online a fixed amount',
	'PAYPAL_TEXT'						=> 'Everybody who wants to help this project could do it with a little donation.',
	'PAYPAL_MSG'						=> 'Please click on the drop down menu for instructing a selected amount of you, click on the button to donate.',
	'PAYPAL_DONATION'					=> 'Your payment amount instruct',
	'DONATION_INFO'						=> 'Thank you for your friendly assistance.',

	'DONATION_TITLE'			=> 'Donate an amount and instruct to pay:',
	'PAYPALINFO_EXPLAIN'		=> 'Support this project; Instruct an amount via PayPal to pay voluntarily.',

	'DONATION_'					=> 'N/A',
	'DONATION_AUD'				=> 'Australian Dollars (AUD)',
	'DONATION_CAD'				=> 'Canadian Dollars (CAD)',
	'DONATION_CHF'				=> 'Swiss Francs (CHF)',
	'DONATION_CZK'				=> 'Czech Koruna (CZK)',
	'DONATION_DKK'				=> 'Danish Kroner (DKK)',
	'DONATION_EUR'				=> 'Euros (EUR)',
	'DONATION_GBP'				=> 'British Pounds (GBP)',
	'DONATION_HKD'				=> 'Hong Kong Dollars (HKD)',
	'DONATION_HUF'				=> 'Hungarian Forint (HUF)',
	'DONATION_ILS'				=> 'Israeli New Shekels (ILS)',
	'DONATION_JPY'				=> 'Japanese Yen (JPY)',
	'DONATION_MXN'				=> 'Mexican Pesos (MXN)',
	'DONATION_NZD'				=> 'New Zealand Dollars (NZD)',
	'DONATION_NOK'				=> 'Norwegian Kroner (NOK)',
	'DONATION_PLN'				=> 'Polish Zlotych (PLN)',
	'DONATION_SEK'				=> 'Swedish Kronor (SEK)',
	'DONATION_SGD'				=> 'Singapore Dollars (SGD)',
	'DONATION_USD'				=> 'U.S. Dollars (USD)',

	'COPYRIGHT_PAYPALEXTENSION'	=> 'Paypal-Extension created by <a href="https://tas2580.net">tas2580</a> 2015',
	'PAYPALDESIGNANDINFO'		=> 'Paypalsite: <a href="http://www.ongray-design.de/">Design by Talk19Zehn</a> 2014-2015',
));
