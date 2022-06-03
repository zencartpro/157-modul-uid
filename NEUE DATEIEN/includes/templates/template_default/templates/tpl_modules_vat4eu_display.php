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
 * @version $Id: tpl_modules_vat4eu_display.php 2022-06-02 20:03:16Z webchills $
 */
 
if (defined('VAT4EU_ENABLED') && VAT4EU_ENABLED == 'true') {
    $popup_link = '<a href="javascript:popupVat4EuWindow(\'' . zen_href_link(FILENAME_POPUP_VAT4EU_FORMATS) . '\')">' . VAT4EU_WHATS_THIS . '</a>';
?>
<script type="text/javascript">
function popupVat4EuWindow(url) {
    window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=320,screenX=150,screenY=150,top=150,left=150')
}
</script>
<div class="clearBoth"></div>
<label class="inputLabel" for="vat-number"><?php echo VAT4EU_ENTRY_VAT_NUMBER; ?></label>
<?php echo zen_draw_input_field('vat_number', (!empty($vat_number)) ? $vat_number : '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_vat_number', '40') . ' id="vat-number"') . $popup_link; ?>
<div class="clearBoth"></div>
<?php
}
