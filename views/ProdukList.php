<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$ProdukList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { produk: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
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
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fproduksrch" id="fproduksrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fproduksrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { produk: currentTable } });
var currentForm;
var fproduksrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fproduksrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fproduksrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fproduksrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fproduksrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fproduksrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="produk">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_produk" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_produklist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_produk_id" class="produk_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Page->kode->headerCellClass() ?>"><div id="elh_produk_kode" class="produk_kode"><?= $Page->renderFieldHeader($Page->kode) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_produk_nama" class="produk_nama"><?= $Page->renderFieldHeader($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
        <th data-name="kelompok_id" class="<?= $Page->kelompok_id->headerCellClass() ?>"><div id="elh_produk_kelompok_id" class="produk_kelompok_id"><?= $Page->renderFieldHeader($Page->kelompok_id) ?></div></th>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
        <th data-name="satuan_id" class="<?= $Page->satuan_id->headerCellClass() ?>"><div id="elh_produk_satuan_id" class="produk_satuan_id"><?= $Page->renderFieldHeader($Page->satuan_id) ?></div></th>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
        <th data-name="satuan_id2" class="<?= $Page->satuan_id2->headerCellClass() ?>"><div id="elh_produk_satuan_id2" class="produk_satuan_id2"><?= $Page->renderFieldHeader($Page->satuan_id2) ?></div></th>
<?php } ?>
<?php if ($Page->gudang_id->Visible) { // gudang_id ?>
        <th data-name="gudang_id" class="<?= $Page->gudang_id->headerCellClass() ?>"><div id="elh_produk_gudang_id" class="produk_gudang_id"><?= $Page->renderFieldHeader($Page->gudang_id) ?></div></th>
<?php } ?>
<?php if ($Page->minstok->Visible) { // minstok ?>
        <th data-name="minstok" class="<?= $Page->minstok->headerCellClass() ?>"><div id="elh_produk_minstok" class="produk_minstok"><?= $Page->renderFieldHeader($Page->minstok) ?></div></th>
<?php } ?>
<?php if ($Page->minorder->Visible) { // minorder ?>
        <th data-name="minorder" class="<?= $Page->minorder->headerCellClass() ?>"><div id="elh_produk_minorder" class="produk_minorder"><?= $Page->renderFieldHeader($Page->minorder) ?></div></th>
<?php } ?>
<?php if ($Page->akunhpp->Visible) { // akunhpp ?>
        <th data-name="akunhpp" class="<?= $Page->akunhpp->headerCellClass() ?>"><div id="elh_produk_akunhpp" class="produk_akunhpp"><?= $Page->renderFieldHeader($Page->akunhpp) ?></div></th>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
        <th data-name="akunjual" class="<?= $Page->akunjual->headerCellClass() ?>"><div id="elh_produk_akunjual" class="produk_akunjual"><?= $Page->renderFieldHeader($Page->akunjual) ?></div></th>
<?php } ?>
<?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
        <th data-name="akunpersediaan" class="<?= $Page->akunpersediaan->headerCellClass() ?>"><div id="elh_produk_akunpersediaan" class="produk_akunpersediaan"><?= $Page->renderFieldHeader($Page->akunpersediaan) ?></div></th>
<?php } ?>
<?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
        <th data-name="akunreturjual" class="<?= $Page->akunreturjual->headerCellClass() ?>"><div id="elh_produk_akunreturjual" class="produk_akunreturjual"><?= $Page->renderFieldHeader($Page->akunreturjual) ?></div></th>
<?php } ?>
<?php if ($Page->hargapokok->Visible) { // hargapokok ?>
        <th data-name="hargapokok" class="<?= $Page->hargapokok->headerCellClass() ?>"><div id="elh_produk_hargapokok" class="produk_hargapokok"><?= $Page->renderFieldHeader($Page->hargapokok) ?></div></th>
<?php } ?>
<?php if ($Page->p->Visible) { // p ?>
        <th data-name="p" class="<?= $Page->p->headerCellClass() ?>"><div id="elh_produk_p" class="produk_p"><?= $Page->renderFieldHeader($Page->p) ?></div></th>
<?php } ?>
<?php if ($Page->l->Visible) { // l ?>
        <th data-name="l" class="<?= $Page->l->headerCellClass() ?>"><div id="elh_produk_l" class="produk_l"><?= $Page->renderFieldHeader($Page->l) ?></div></th>
<?php } ?>
<?php if ($Page->_t->Visible) { // t ?>
        <th data-name="_t" class="<?= $Page->_t->headerCellClass() ?>"><div id="elh_produk__t" class="produk__t"><?= $Page->renderFieldHeader($Page->_t) ?></div></th>
<?php } ?>
<?php if ($Page->berat->Visible) { // berat ?>
        <th data-name="berat" class="<?= $Page->berat->headerCellClass() ?>"><div id="elh_produk_berat" class="produk_berat"><?= $Page->renderFieldHeader($Page->berat) ?></div></th>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { // supplier_id ?>
        <th data-name="supplier_id" class="<?= $Page->supplier_id->headerCellClass() ?>"><div id="elh_produk_supplier_id" class="produk_supplier_id"><?= $Page->renderFieldHeader($Page->supplier_id) ?></div></th>
<?php } ?>
<?php if ($Page->waktukirim->Visible) { // waktukirim ?>
        <th data-name="waktukirim" class="<?= $Page->waktukirim->headerCellClass() ?>"><div id="elh_produk_waktukirim" class="produk_waktukirim"><?= $Page->renderFieldHeader($Page->waktukirim) ?></div></th>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <th data-name="aktif" class="<?= $Page->aktif->headerCellClass() ?>"><div id="elh_produk_aktif" class="produk_aktif"><?= $Page->renderFieldHeader($Page->aktif) ?></div></th>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
        <th data-name="id_FK" class="<?= $Page->id_FK->headerCellClass() ?>"><div id="elh_produk_id_FK" class="produk_id_FK"><?= $Page->renderFieldHeader($Page->id_FK) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_id" class="el_produk_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kode->Visible) { // kode ?>
        <td data-name="kode"<?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_kode" class="el_produk_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama"<?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_nama" class="el_produk_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
        <td data-name="kelompok_id"<?= $Page->kelompok_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_kelompok_id" class="el_produk_kelompok_id">
<span<?= $Page->kelompok_id->viewAttributes() ?>>
<?= $Page->kelompok_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->satuan_id->Visible) { // satuan_id ?>
        <td data-name="satuan_id"<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_satuan_id" class="el_produk_satuan_id">
<span<?= $Page->satuan_id->viewAttributes() ?>>
<?= $Page->satuan_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
        <td data-name="satuan_id2"<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_satuan_id2" class="el_produk_satuan_id2">
<span<?= $Page->satuan_id2->viewAttributes() ?>>
<?= $Page->satuan_id2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gudang_id->Visible) { // gudang_id ?>
        <td data-name="gudang_id"<?= $Page->gudang_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_gudang_id" class="el_produk_gudang_id">
<span<?= $Page->gudang_id->viewAttributes() ?>>
<?= $Page->gudang_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->minstok->Visible) { // minstok ?>
        <td data-name="minstok"<?= $Page->minstok->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_minstok" class="el_produk_minstok">
<span<?= $Page->minstok->viewAttributes() ?>>
<?= $Page->minstok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->minorder->Visible) { // minorder ?>
        <td data-name="minorder"<?= $Page->minorder->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_minorder" class="el_produk_minorder">
<span<?= $Page->minorder->viewAttributes() ?>>
<?= $Page->minorder->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->akunhpp->Visible) { // akunhpp ?>
        <td data-name="akunhpp"<?= $Page->akunhpp->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_akunhpp" class="el_produk_akunhpp">
<span<?= $Page->akunhpp->viewAttributes() ?>>
<?= $Page->akunhpp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->akunjual->Visible) { // akunjual ?>
        <td data-name="akunjual"<?= $Page->akunjual->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_akunjual" class="el_produk_akunjual">
<span<?= $Page->akunjual->viewAttributes() ?>>
<?= $Page->akunjual->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
        <td data-name="akunpersediaan"<?= $Page->akunpersediaan->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_akunpersediaan" class="el_produk_akunpersediaan">
<span<?= $Page->akunpersediaan->viewAttributes() ?>>
<?= $Page->akunpersediaan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
        <td data-name="akunreturjual"<?= $Page->akunreturjual->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_akunreturjual" class="el_produk_akunreturjual">
<span<?= $Page->akunreturjual->viewAttributes() ?>>
<?= $Page->akunreturjual->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hargapokok->Visible) { // hargapokok ?>
        <td data-name="hargapokok"<?= $Page->hargapokok->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_hargapokok" class="el_produk_hargapokok">
<span<?= $Page->hargapokok->viewAttributes() ?>>
<?= $Page->hargapokok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->p->Visible) { // p ?>
        <td data-name="p"<?= $Page->p->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_p" class="el_produk_p">
<span<?= $Page->p->viewAttributes() ?>>
<?= $Page->p->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->l->Visible) { // l ?>
        <td data-name="l"<?= $Page->l->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_l" class="el_produk_l">
<span<?= $Page->l->viewAttributes() ?>>
<?= $Page->l->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_t->Visible) { // t ?>
        <td data-name="_t"<?= $Page->_t->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk__t" class="el_produk__t">
<span<?= $Page->_t->viewAttributes() ?>>
<?= $Page->_t->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->berat->Visible) { // berat ?>
        <td data-name="berat"<?= $Page->berat->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_berat" class="el_produk_berat">
<span<?= $Page->berat->viewAttributes() ?>>
<?= $Page->berat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->supplier_id->Visible) { // supplier_id ?>
        <td data-name="supplier_id"<?= $Page->supplier_id->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_supplier_id" class="el_produk_supplier_id">
<span<?= $Page->supplier_id->viewAttributes() ?>>
<?= $Page->supplier_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->waktukirim->Visible) { // waktukirim ?>
        <td data-name="waktukirim"<?= $Page->waktukirim->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_waktukirim" class="el_produk_waktukirim">
<span<?= $Page->waktukirim->viewAttributes() ?>>
<?= $Page->waktukirim->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->aktif->Visible) { // aktif ?>
        <td data-name="aktif"<?= $Page->aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_aktif" class="el_produk_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_FK->Visible) { // id_FK ?>
        <td data-name="id_FK"<?= $Page->id_FK->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_produk_id_FK" class="el_produk_id_FK">
<span<?= $Page->id_FK->viewAttributes() ?>>
<?= $Page->id_FK->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("produk");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
