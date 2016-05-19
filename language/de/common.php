<?php
/**
*
* @package phpBB Extension - Paypal - German (Casual)
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


	// ACP settings
	'ACP_SETTINGS'					=> 'Einstellungen',
	'ACP_PAYPAL_EMAIL'				=> 'E-Mail',
	'ACP_PAYPAL_EMAIL_EXPLAIN'		=> 'Gib eine E-Mail Adresse an an die Paypal zahlungen gehen sollen.',
	'ACP_PAYPAL_TITLE'				=> 'Seiten Titel',
	'ACP_PAYPAL_TITLE_EXPLAIN'		=> 'Gib einen Titel für die Paypal Seite an.',
	'ACP_PAYPAL_TEXT'				=> 'Seiten Text',
	'ACP_PAYPAL_TEXT_EXPLAIN'		=> 'Gib einen Text ein der auf der Paypal Seite angezeigt wird, du kannst hier BB Code verwenden.',
	'ACP_CURRENCY_CODE'				=> 'Währung',
	'ACP_CURRENCY_CODE_EXPLAIN'		=> 'Wähle eine Währung die als Standard für Zahlungen verwendet wird.',
	'ACP_PAYPAL_SANDBOX'			=> 'Sandbox Modus',
	'ACP_PAYPAL_SANDBOX_EXPLAIN'	=> 'Soll Paypal im <a hre="https://developer.paypal.com/developer/accounts/">Sandbox Modus</a> ausgeführt werden?',
	'ACP_AMOUNT_LIST'				=> 'Beträge',
	'ACP_AMOUNT'					=> 'Betrag',
	'ACP_ADD_AMOUNT'				=> 'Betrag hinzufügen',
	'ACP_SAVED'						=> 'Die Einstellung wurde gespeichert',

	// ACP items
	'ACP_ITEM_NAME'					=> 'Name',
	'ACP_ITEM_NAME_EXPLAIN'			=> 'Gib einen Namen für den Gegenstand ein',
	'ACP_ITEM_TEXT'					=> 'Beschreibung',
	'ACP_ITEM_TEXT_EXPLAIN'			=> 'Gib eine Beschreibung für den Gegenstand ein, du kannst hier BB Code verwenden.',
	'ACP_ADD_ITEM'					=> 'Gegenstand hinzufügen',
	'ACP_ITEM_ADD_SUCCESS'			=> 'Der Gegenstand wurde zur Datenbank hinzugefügt.',
	'ACP_ITEM_EDIT_SUCCESS'			=> 'der Gegenstand wurde erfolgreich bearbeidet',
	'ITEM_DELETED'					=> 'Der Eintrag wurde erfolgreich gelöscht!',
	'TOO_SHORT'						=> 'Der eingegebene Wert ist zu kurz',
	'NO_ITEMS'						=> 'Du hast noch keine Gegenstände angelegt.',


	// ACP donators
	'USER'							=> 'Benutzer',
	'ITEM'							=> 'Gegenstand',
	'NO_DONATIONS'					=> 'Bis jetzt hat noch niemand etwas gespendet.',
	'NO_CURL'						=> 'Dein Server unterstützt kein CURL, installiere die PHP CURL Erweiterung damit Benutzer die gespendet haben erfasst werden können.',
	'DONATION_DELETED'				=> 'Der Spender wurde aus der Liste gelöscht.',

	// Page
	'SANDBOX_MODE_WARNING'			=> 'Paypal läuft im Sandbox Modus, Spenden können nur mit Paypal Testaccounts gemacht werden!',
	'PAYPAL_DONATION'				=> 'Paypal spenden',
	'USER_NOT_LOGGED_IN'			=> 'Du bist nicht angemeldet, melde dich an damit deine Spende auf deinen Benutzer angerechnet werden kann.',

	'DONATION_'					=> 'N/A',
	'DONATION_AUD'				=> 'Australische Dollar (AUD)',
	'DONATION_CAD'				=> 'Kanadische Dollar (CAD)',
	'DONATION_CHF'				=> 'Schweizer Franken (CHF)',
	'DONATION_CZK'				=> 'Tschechische Kronen (CZK)',
	'DONATION_DKK'				=> 'Dänische Kronen (DKK)',
	'DONATION_EUR'				=> 'Euro (EUR)',
	'DONATION_GBP'				=> 'Britische Pfund (GBP)',
	'DONATION_HKD'				=> 'Hongkong-Dollar (HKD)',
	'DONATION_HUF'				=> 'Ungarische Forint (HUF)',
	'DONATION_ILS'				=> 'Neue Israelische Schekel (ILS)',
	'DONATION_JPY'				=> 'Japanische Yen (JPY)',
	'DONATION_MXN'				=> 'Mexikanische Pesos (MXN)',
	'DONATION_NOK'				=> 'Norwegische Kronen (NOK)',
	'DONATION_NZD'				=> 'Neuseeland-Dollar (NZD)',
	'DONATION_PLN'				=> 'Polnische Zloty (PLN)',
	'DONATION_SEK'				=> 'Schwedische Kronen (SEK)',
	'DONATION_SGD'				=> 'Singapur-Dollar (SGD)',
	'DONATION_USD'				=> 'US-Dollar (USD)',

));
