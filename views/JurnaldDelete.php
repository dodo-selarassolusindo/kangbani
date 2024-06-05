<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$JurnaldDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { jurnald: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fjurnalddelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fjurnalddelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fjurnalddelete" id="fjurnalddelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="jurnald">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_jurnald_id" class="jurnald_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jurnal_id->Visible) { // jurnal_id ?>
        <th class="<?= $Page->jurnal_id->headerCellClass() ?>"><span id="elh_jurnald_jurnal_id" class="jurnald_jurnal_id"><?= $Page->jurnal_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akun_id->Visible) { // akun_id ?>
        <th class="<?= $Page->akun_id->headerCellClass() ?>"><span id="elh_jurnald_akun_id" class="jurnald_akun_id"><?= $Page->akun_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->debet->Visible) { // debet ?>
        <th class="<?= $Page->debet->headerCellClass() ?>"><span id="elh_jurnald_debet" class="jurnald_debet"><?= $Page->debet->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kredit->Visible) { // kredit ?>
        <th class="<?= $Page->kredit->headerCellClass() ?>"><span id="elh_jurnald_kredit" class="jurnald_kredit"><?= $Page->kredit->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jurnal_id->Visible) { // jurnal_id ?>
        <td<?= $Page->jurnal_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->jurnal_id->viewAttributes() ?>>
<?= $Page->jurnal_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akun_id->Visible) { // akun_id ?>
        <td<?= $Page->akun_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->akun_id->viewAttributes() ?>>
<?= $Page->akun_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->debet->Visible) { // debet ?>
        <td<?= $Page->debet->cellAttributes() ?>>
<span id="">
<span<?= $Page->debet->viewAttributes() ?>>
<?= $Page->debet->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kredit->Visible) { // kredit ?>
        <td<?= $Page->kredit->cellAttributes() ?>>
<span id="">
<span<?= $Page->kredit->viewAttributes() ?>>
<?= $Page->kredit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
