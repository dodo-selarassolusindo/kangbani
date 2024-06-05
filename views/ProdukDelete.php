<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$ProdukDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { produk: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fprodukdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprodukdelete")
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
<form name="fprodukdelete" id="fprodukdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="produk">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_produk_id" class="produk_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_produk_kode" class="produk_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_produk_nama" class="produk_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
        <th class="<?= $Page->kelompok_id->headerCellClass() ?>"><span id="elh_produk_kelompok_id" class="produk_kelompok_id"><?= $Page->kelompok_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
        <th class="<?= $Page->satuan_id->headerCellClass() ?>"><span id="elh_produk_satuan_id" class="produk_satuan_id"><?= $Page->satuan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
        <th class="<?= $Page->satuan_id2->headerCellClass() ?>"><span id="elh_produk_satuan_id2" class="produk_satuan_id2"><?= $Page->satuan_id2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gudang_id->Visible) { // gudang_id ?>
        <th class="<?= $Page->gudang_id->headerCellClass() ?>"><span id="elh_produk_gudang_id" class="produk_gudang_id"><?= $Page->gudang_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->minstok->Visible) { // minstok ?>
        <th class="<?= $Page->minstok->headerCellClass() ?>"><span id="elh_produk_minstok" class="produk_minstok"><?= $Page->minstok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->minorder->Visible) { // minorder ?>
        <th class="<?= $Page->minorder->headerCellClass() ?>"><span id="elh_produk_minorder" class="produk_minorder"><?= $Page->minorder->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akunhpp->Visible) { // akunhpp ?>
        <th class="<?= $Page->akunhpp->headerCellClass() ?>"><span id="elh_produk_akunhpp" class="produk_akunhpp"><?= $Page->akunhpp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
        <th class="<?= $Page->akunjual->headerCellClass() ?>"><span id="elh_produk_akunjual" class="produk_akunjual"><?= $Page->akunjual->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
        <th class="<?= $Page->akunpersediaan->headerCellClass() ?>"><span id="elh_produk_akunpersediaan" class="produk_akunpersediaan"><?= $Page->akunpersediaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
        <th class="<?= $Page->akunreturjual->headerCellClass() ?>"><span id="elh_produk_akunreturjual" class="produk_akunreturjual"><?= $Page->akunreturjual->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hargapokok->Visible) { // hargapokok ?>
        <th class="<?= $Page->hargapokok->headerCellClass() ?>"><span id="elh_produk_hargapokok" class="produk_hargapokok"><?= $Page->hargapokok->caption() ?></span></th>
<?php } ?>
<?php if ($Page->p->Visible) { // p ?>
        <th class="<?= $Page->p->headerCellClass() ?>"><span id="elh_produk_p" class="produk_p"><?= $Page->p->caption() ?></span></th>
<?php } ?>
<?php if ($Page->l->Visible) { // l ?>
        <th class="<?= $Page->l->headerCellClass() ?>"><span id="elh_produk_l" class="produk_l"><?= $Page->l->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_t->Visible) { // t ?>
        <th class="<?= $Page->_t->headerCellClass() ?>"><span id="elh_produk__t" class="produk__t"><?= $Page->_t->caption() ?></span></th>
<?php } ?>
<?php if ($Page->berat->Visible) { // berat ?>
        <th class="<?= $Page->berat->headerCellClass() ?>"><span id="elh_produk_berat" class="produk_berat"><?= $Page->berat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { // supplier_id ?>
        <th class="<?= $Page->supplier_id->headerCellClass() ?>"><span id="elh_produk_supplier_id" class="produk_supplier_id"><?= $Page->supplier_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->waktukirim->Visible) { // waktukirim ?>
        <th class="<?= $Page->waktukirim->headerCellClass() ?>"><span id="elh_produk_waktukirim" class="produk_waktukirim"><?= $Page->waktukirim->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><span id="elh_produk_aktif" class="produk_aktif"><?= $Page->aktif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
        <th class="<?= $Page->id_FK->headerCellClass() ?>"><span id="elh_produk_id_FK" class="produk_id_FK"><?= $Page->id_FK->caption() ?></span></th>
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
<?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
        <td<?= $Page->kelompok_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->kelompok_id->viewAttributes() ?>>
<?= $Page->kelompok_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
        <td<?= $Page->satuan_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->satuan_id->viewAttributes() ?>>
<?= $Page->satuan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
        <td<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="">
<span<?= $Page->satuan_id2->viewAttributes() ?>>
<?= $Page->satuan_id2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gudang_id->Visible) { // gudang_id ?>
        <td<?= $Page->gudang_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->gudang_id->viewAttributes() ?>>
<?= $Page->gudang_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->minstok->Visible) { // minstok ?>
        <td<?= $Page->minstok->cellAttributes() ?>>
<span id="">
<span<?= $Page->minstok->viewAttributes() ?>>
<?= $Page->minstok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->minorder->Visible) { // minorder ?>
        <td<?= $Page->minorder->cellAttributes() ?>>
<span id="">
<span<?= $Page->minorder->viewAttributes() ?>>
<?= $Page->minorder->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akunhpp->Visible) { // akunhpp ?>
        <td<?= $Page->akunhpp->cellAttributes() ?>>
<span id="">
<span<?= $Page->akunhpp->viewAttributes() ?>>
<?= $Page->akunhpp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
        <td<?= $Page->akunjual->cellAttributes() ?>>
<span id="">
<span<?= $Page->akunjual->viewAttributes() ?>>
<?= $Page->akunjual->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
        <td<?= $Page->akunpersediaan->cellAttributes() ?>>
<span id="">
<span<?= $Page->akunpersediaan->viewAttributes() ?>>
<?= $Page->akunpersediaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
        <td<?= $Page->akunreturjual->cellAttributes() ?>>
<span id="">
<span<?= $Page->akunreturjual->viewAttributes() ?>>
<?= $Page->akunreturjual->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hargapokok->Visible) { // hargapokok ?>
        <td<?= $Page->hargapokok->cellAttributes() ?>>
<span id="">
<span<?= $Page->hargapokok->viewAttributes() ?>>
<?= $Page->hargapokok->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->p->Visible) { // p ?>
        <td<?= $Page->p->cellAttributes() ?>>
<span id="">
<span<?= $Page->p->viewAttributes() ?>>
<?= $Page->p->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->l->Visible) { // l ?>
        <td<?= $Page->l->cellAttributes() ?>>
<span id="">
<span<?= $Page->l->viewAttributes() ?>>
<?= $Page->l->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_t->Visible) { // t ?>
        <td<?= $Page->_t->cellAttributes() ?>>
<span id="">
<span<?= $Page->_t->viewAttributes() ?>>
<?= $Page->_t->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->berat->Visible) { // berat ?>
        <td<?= $Page->berat->cellAttributes() ?>>
<span id="">
<span<?= $Page->berat->viewAttributes() ?>>
<?= $Page->berat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { // supplier_id ?>
        <td<?= $Page->supplier_id->cellAttributes() ?>>
<span id="">
<span<?= $Page->supplier_id->viewAttributes() ?>>
<?= $Page->supplier_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->waktukirim->Visible) { // waktukirim ?>
        <td<?= $Page->waktukirim->cellAttributes() ?>>
<span id="">
<span<?= $Page->waktukirim->viewAttributes() ?>>
<?= $Page->waktukirim->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <td<?= $Page->aktif->cellAttributes() ?>>
<span id="">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
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
