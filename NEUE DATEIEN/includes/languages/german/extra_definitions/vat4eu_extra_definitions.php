<?php
/**
 * @package UID 
 * Zen Cart German Specific 
 * based on VAT4EU plugin by Cindy Merkin a.k.a. lat9 (cindy@vinosdefrutastropicales.com)
 * Copyright (c) 2017-2022 Vinos de Frutas Tropicales
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: vat4eu_extra_definitions.php 2022-06-05 07:49:16Z webchills $
 */

// -----
// These two definitions are used in different spots.
//
// 1) VAT4EU_ENTRY_VAT_NUMBER is used during VAT Number "gathering" and should not be an empty string.
// 2) VAT4EU_DISPLAY_VAT_NUMBER is used when formatting an address-block with a previously-entered VAT Number.
//    If you don't want to precede the actual VAT Number with that text, just set the value to ''; otherwise,
//    remember to keep the final space so that there's separation from the text and the actual VAT Number!
//
define('VAT4EU_ENTRY_VAT_NUMBER', 'UID:');
define('VAT4EU_DISPLAY_VAT_NUMBER', 'UID: ');

// -----
// This definition is used by tpl_modules_vat4eu_display.php's link to the popup_vat4eu_formats page.
//
define('VAT4EU_WHATS_THIS', 'Info zur UID Eingabe');

define('VAT4EU_ENTRY_VAT_MIN_ERROR', 'Ihre <em>UID</em> muss mindestens ' . VAT4EU_MIN_LENGTH . ' Zeichen haben.');
define('VAT4EU_ENTRY_VAT_PREFIX_INVALID', 'Ihre <em>UID</em> muss mit <b>%1$s</b> beginnen, da Ihre Adresse in <em>%2$s</em> ist.');
define('VAT4EU_ENTRY_REQUIRED_ERROR', 'Ihre <em>UID</em> ist ein Pflichtfeld.');

define('VAT4EU_VAT_NOT_VALIDATED', 'Wir konnten die <em>UID</em>, die Sie eingegeben haben nicht prüfen.  Bitte neu eingeben. Bei weiteren Schwierigkeiten <a href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '">kontaktieren Sie uns</a> für Hilfe.');
define('VAT4EU_APPROVAL_PENDING', 'Sobald Ihre <em>UID</em> (%s) geprüft wurde, verrechnen wir Ihnen für Ihre Bestellungen keine Mehrwertsteuer (<em>innergemeinschaftliche steuerfreie Lieferung</em>).  Bitte <a href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '">kontaktieren Sie uns</a>, falls Sie dazu Fragen haben.');

define('VAT4EU_MESSAGE_YOUR_VAT_REFUND', 'Ihre Bestellung ist zur <em>Mehrwertsteuer Erstattung</em> berechtigt in der Höhe von %s.');     //- The $s is the formatted monetary amount of the refund

define('VAT4EU_TEXT_VAT_REFUND', 'Mehrwertsteuer Erstattung aufgrund von UID:');