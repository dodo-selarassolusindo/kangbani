<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$ProdukView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fprodukview" id="fprodukview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { produk: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fprodukview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprodukview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="produk">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_produk_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode"<?= $Page->kode->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode"<?= $Page->kode->cellAttributes() ?>>
<span id="el_produk_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama"<?= $Page->nama->cellAttributes() ?>>
<span id="el_produk_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
    <tr id="r_kelompok_id"<?= $Page->kelompok_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_kelompok_id"><?= $Page->kelompok_id->caption() ?></span></td>
        <td data-name="kelompok_id"<?= $Page->kelompok_id->cellAttributes() ?>>
<span id="el_produk_kelompok_id">
<span<?= $Page->kelompok_id->viewAttributes() ?>>
<?= $Page->kelompok_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
    <tr id="r_satuan_id"<?= $Page->satuan_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_satuan_id"><?= $Page->satuan_id->caption() ?></span></td>
        <td data-name="satuan_id"<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el_produk_satuan_id">
<span<?= $Page->satuan_id->viewAttributes() ?>>
<?= $Page->satuan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
    <tr id="r_satuan_id2"<?= $Page->satuan_id2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_satuan_id2"><?= $Page->satuan_id2->caption() ?></span></td>
        <td data-name="satuan_id2"<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="el_produk_satuan_id2">
<span<?= $Page->satuan_id2->viewAttributes() ?>>
<?= $Page->satuan_id2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gudang_id->Visible) { // gudang_id ?>
    <tr id="r_gudang_id"<?= $Page->gudang_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_gudang_id"><?= $Page->gudang_id->caption() ?></span></td>
        <td data-name="gudang_id"<?= $Page->gudang_id->cellAttributes() ?>>
<span id="el_produk_gudang_id">
<span<?= $Page->gudang_id->viewAttributes() ?>>
<?= $Page->gudang_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minstok->Visible) { // minstok ?>
    <tr id="r_minstok"<?= $Page->minstok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_minstok"><?= $Page->minstok->caption() ?></span></td>
        <td data-name="minstok"<?= $Page->minstok->cellAttributes() ?>>
<span id="el_produk_minstok">
<span<?= $Page->minstok->viewAttributes() ?>>
<?= $Page->minstok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->minorder->Visible) { // minorder ?>
    <tr id="r_minorder"<?= $Page->minorder->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_minorder"><?= $Page->minorder->caption() ?></span></td>
        <td data-name="minorder"<?= $Page->minorder->cellAttributes() ?>>
<span id="el_produk_minorder">
<span<?= $Page->minorder->viewAttributes() ?>>
<?= $Page->minorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akunhpp->Visible) { // akunhpp ?>
    <tr id="r_akunhpp"<?= $Page->akunhpp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_akunhpp"><?= $Page->akunhpp->caption() ?></span></td>
        <td data-name="akunhpp"<?= $Page->akunhpp->cellAttributes() ?>>
<span id="el_produk_akunhpp">
<span<?= $Page->akunhpp->viewAttributes() ?>>
<?= $Page->akunhpp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
    <tr id="r_akunjual"<?= $Page->akunjual->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_akunjual"><?= $Page->akunjual->caption() ?></span></td>
        <td data-name="akunjual"<?= $Page->akunjual->cellAttributes() ?>>
<span id="el_produk_akunjual">
<span<?= $Page->akunjual->viewAttributes() ?>>
<?= $Page->akunjual->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
    <tr id="r_akunpersediaan"<?= $Page->akunpersediaan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_akunpersediaan"><?= $Page->akunpersediaan->caption() ?></span></td>
        <td data-name="akunpersediaan"<?= $Page->akunpersediaan->cellAttributes() ?>>
<span id="el_produk_akunpersediaan">
<span<?= $Page->akunpersediaan->viewAttributes() ?>>
<?= $Page->akunpersediaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
    <tr id="r_akunreturjual"<?= $Page->akunreturjual->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_akunreturjual"><?= $Page->akunreturjual->caption() ?></span></td>
        <td data-name="akunreturjual"<?= $Page->akunreturjual->cellAttributes() ?>>
<span id="el_produk_akunreturjual">
<span<?= $Page->akunreturjual->viewAttributes() ?>>
<?= $Page->akunreturjual->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hargapokok->Visible) { // hargapokok ?>
    <tr id="r_hargapokok"<?= $Page->hargapokok->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_hargapokok"><?= $Page->hargapokok->caption() ?></span></td>
        <td data-name="hargapokok"<?= $Page->hargapokok->cellAttributes() ?>>
<span id="el_produk_hargapokok">
<span<?= $Page->hargapokok->viewAttributes() ?>>
<?= $Page->hargapokok->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->p->Visible) { // p ?>
    <tr id="r_p"<?= $Page->p->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_p"><?= $Page->p->caption() ?></span></td>
        <td data-name="p"<?= $Page->p->cellAttributes() ?>>
<span id="el_produk_p">
<span<?= $Page->p->viewAttributes() ?>>
<?= $Page->p->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->l->Visible) { // l ?>
    <tr id="r_l"<?= $Page->l->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_l"><?= $Page->l->caption() ?></span></td>
        <td data-name="l"<?= $Page->l->cellAttributes() ?>>
<span id="el_produk_l">
<span<?= $Page->l->viewAttributes() ?>>
<?= $Page->l->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_t->Visible) { // t ?>
    <tr id="r__t"<?= $Page->_t->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk__t"><?= $Page->_t->caption() ?></span></td>
        <td data-name="_t"<?= $Page->_t->cellAttributes() ?>>
<span id="el_produk__t">
<span<?= $Page->_t->viewAttributes() ?>>
<?= $Page->_t->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->berat->Visible) { // berat ?>
    <tr id="r_berat"<?= $Page->berat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_berat"><?= $Page->berat->caption() ?></span></td>
        <td data-name="berat"<?= $Page->berat->cellAttributes() ?>>
<span id="el_produk_berat">
<span<?= $Page->berat->viewAttributes() ?>>
<?= $Page->berat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { // supplier_id ?>
    <tr id="r_supplier_id"<?= $Page->supplier_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_supplier_id"><?= $Page->supplier_id->caption() ?></span></td>
        <td data-name="supplier_id"<?= $Page->supplier_id->cellAttributes() ?>>
<span id="el_produk_supplier_id">
<span<?= $Page->supplier_id->viewAttributes() ?>>
<?= $Page->supplier_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->waktukirim->Visible) { // waktukirim ?>
    <tr id="r_waktukirim"<?= $Page->waktukirim->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_waktukirim"><?= $Page->waktukirim->caption() ?></span></td>
        <td data-name="waktukirim"<?= $Page->waktukirim->cellAttributes() ?>>
<span id="el_produk_waktukirim">
<span<?= $Page->waktukirim->viewAttributes() ?>>
<?= $Page->waktukirim->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif"<?= $Page->aktif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif"<?= $Page->aktif->cellAttributes() ?>>
<span id="el_produk_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
    <tr id="r_id_FK"<?= $Page->id_FK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_produk_id_FK"><?= $Page->id_FK->caption() ?></span></td>
        <td data-name="id_FK"<?= $Page->id_FK->cellAttributes() ?>>
<span id="el_produk_id_FK">
<span<?= $Page->id_FK->viewAttributes() ?>>
<?= $Page->id_FK->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
