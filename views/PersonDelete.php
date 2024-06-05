<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$PersonDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { person: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fpersondelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpersondelete")
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
<form name="fpersondelete" id="fpersondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="person">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_person_id" class="person_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_person_kode" class="person_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_person_nama" class="person_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kontak->Visible) { // kontak ?>
        <th class="<?= $Page->kontak->headerCellClass() ?>"><span id="elh_person_kontak" class="person_kontak"><?= $Page->kontak->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
        <th class="<?= $Page->type_id->headerCellClass() ?>"><span id="elh_person_type_id" class="person_type_id"><?= $Page->type_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telp1->Visible) { // telp1 ?>
        <th class="<?= $Page->telp1->headerCellClass() ?>"><span id="elh_person_telp1" class="person_telp1"><?= $Page->telp1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
        <th class="<?= $Page->matauang_id->headerCellClass() ?>"><span id="elh_person_matauang_id" class="person_matauang_id"><?= $Page->matauang_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_person__username" class="person__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><span id="elh_person__password" class="person__password"><?= $Page->_password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telp2->Visible) { // telp2 ?>
        <th class="<?= $Page->telp2->headerCellClass() ?>"><span id="elh_person_telp2" class="person_telp2"><?= $Page->telp2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
        <th class="<?= $Page->fax->headerCellClass() ?>"><span id="elh_person_fax" class="person_fax"><?= $Page->fax->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><span id="elh_person_hp" class="person_hp"><?= $Page->hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_person__email" class="person__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
        <th class="<?= $Page->website->headerCellClass() ?>"><span id="elh_person_website" class="person_website"><?= $Page->website->caption() ?></span></th>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
        <th class="<?= $Page->npwp->headerCellClass() ?>"><span id="elh_person_npwp" class="person_npwp"><?= $Page->npwp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_person_alamat" class="person_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kota->Visible) { // kota ?>
        <th class="<?= $Page->kota->headerCellClass() ?>"><span id="elh_person_kota" class="person_kota"><?= $Page->kota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
        <th class="<?= $Page->zip->headerCellClass() ?>"><span id="elh_person_zip" class="person_zip"><?= $Page->zip->caption() ?></span></th>
<?php } ?>
<?php if ($Page->klasifikasi_id->Visible) { // klasifikasi_id ?>
        <th class="<?= $Page->klasifikasi_id->headerCellClass() ?>"><span id="elh_person_klasifikasi_id" class="person_klasifikasi_id"><?= $Page->klasifikasi_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
        <th class="<?= $Page->id_FK->headerCellClass() ?>"><span id="elh_person_id_FK" class="person_id_FK"><?= $Page->id_FK->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td<?= $Page->kode->cellAttributes() ?>>
<span id="">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td<?= $Page->nama->cellAttributes() ?>>
<span id="">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kontak->Visible) { // kontak ?>
        <td<?= $Page->kontak->cellAttributes() ?>>
<span id="">
<span<?= $Page->kontak->viewAttributes() ?>>
<?= $Page->kontak->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
        <td<?= $Page->type_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->type_id->viewAttributes() ?>>
<?= $Page->type_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telp1->Visible) { // telp1 ?>
        <td<?= $Page->telp1->cellAttributes() ?>>
<span id="">
<span<?= $Page->telp1->viewAttributes() ?>>
<?= $Page->telp1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
        <td<?= $Page->matauang_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->matauang_id->viewAttributes() ?>>
<?= $Page->matauang_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td<?= $Page->_username->cellAttributes() ?>>
<span id="">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <td<?= $Page->_password->cellAttributes() ?>>
<span id="">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telp2->Visible) { // telp2 ?>
        <td<?= $Page->telp2->cellAttributes() ?>>
<span id="">
<span<?= $Page->telp2->viewAttributes() ?>>
<?= $Page->telp2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
        <td<?= $Page->fax->cellAttributes() ?>>
<span id="">
<span<?= $Page->fax->viewAttributes() ?>>
<?= $Page->fax->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <td<?= $Page->hp->cellAttributes() ?>>
<span id="">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
        <td<?= $Page->website->cellAttributes() ?>>
<span id="">
<span<?= $Page->website->viewAttributes() ?>>
<?= $Page->website->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
        <td<?= $Page->npwp->cellAttributes() ?>>
<span id="">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= $Page->npwp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td<?= $Page->alamat->cellAttributes() ?>>
<span id="">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kota->Visible) { // kota ?>
        <td<?= $Page->kota->cellAttributes() ?>>
<span id="">
<span<?= $Page->kota->viewAttributes() ?>>
<?= $Page->kota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
        <td<?= $Page->zip->cellAttributes() ?>>
<span id="">
<span<?= $Page->zip->viewAttributes() ?>>
<?= $Page->zip->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->klasifikasi_id->Visible) { // klasifikasi_id ?>
        <td<?= $Page->klasifikasi_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->klasifikasi_id->viewAttributes() ?>>
<?= $Page->klasifikasi_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
        <td<?= $Page->id_FK->cellAttributes() ?>>
<span id="">
<span<?= $Page->id_FK->viewAttributes() ?>>
<?= $Page->id_FK->getViewValue() ?></span>
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
