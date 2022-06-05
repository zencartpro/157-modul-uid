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
 * @version $Id: vat4eu_extra_definitions_admin.php 2022-06-05 07:42:16Z webchills $
 */
 
define('VAT4EU_TEXT_MESSAGE_INSTALLED', 'Das <em>UID</em> Modul wurde erfolgreich in Version v%s installiert.');
define('VAT4EU_TEXT_MESSAGE_UPDATED', 'Das <em>UID</em> Modul wurde erfolgreich aktualisiert von v%1$s auf v%2$s.');

define('BOX_CONFIG_VAT4EU', 'UID Einstellungen');

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

define('VAT4EU_ENTRY_OVERRIDE_VALIDATION', 'UID Prüfung übergehen:');

define('VAT4EU_CUSTOMERS_HEADING', 'UID');

define('VAT4EU_ENTRY_VAT_MIN_ERROR', '<span class="errorText">Mindestens %u Zeichen.</span>');
define('VAT4EU_ENTRY_VAT_PREFIX_INVALID', '<span class="errorText">Muss beginnen mit <b>%1$s</b>, da die Adresse in <em>%2$s</em> ist.</span>');
define('VAT4EU_ENTRY_VAT_INVALID_CHARS', '<span class="errorText">Ungültige Zeichen entdeckt</span>');
define('VAT4EU_ENTRY_VAT_VIES_INVALID', '<span class="errorText">VIES Überprüfung fehlgeschlagen.</span>');
define('VAT4EU_ENTRY_VAT_REQUIRED', '<span class="errorText">Das ist ein Pflichtfeld</span>');

// -----
// Used as in the title attribute when displaying VAT Numbers' status in Customers->Customers.
//
define('VAT4EU_ADMIN_OVERRIDE', 'von Administrator übergangen');
define('VAT4EU_VIES_OK', 'von VIES überprüft');
define('VAT4EU_NOT_VALIDATED', 'erfordert Prüfung durch Admin');
define('VAT4EU_VIES_NOT_OK', 'von VIES als ungültig erkannt');

// -----
// Used as the title attribute for the heading sorts in Customers->Customers.
//
define('VAT4EU_SORT_ASC', 'Sortiere nach Status, Aufsteigend');
define('VAT4EU_SORT_DESC', 'Sortiere nach Status, Absteigend');

// -----
// Issued during Edit Orders processing if the admin has changed either the VAT Number or its
// validation status.
//
define('VAT4EU_EO_CUSTOMER_UPDATE_REQUIRED', 'Die <em>UID</em> oder ihr Status wurde geändert <em>nur für diese Bestellung</em>! Bearbeiten Sie die Kundeninformationen, um diese Änderung auch für kommende Bestellungen bereitzustellen.');