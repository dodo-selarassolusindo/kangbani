<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$KonversiView = &$Page;
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
<form name="fkonversiview" id="fkonversiview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { konversi: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fkonversiview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkonversiview")
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
<input type="hidden" name="t" value="konversi">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_konversi_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
    <tr id="r_satuan_id"<?= $Page->satuan_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_satuan_id"><?= $Page->satuan_id->caption() ?></span></td>
        <td data-name="satuan_id"<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el_konversi_satuan_id">
<span<?= $Page->satuan_id->viewAttributes() ?>>
<?= $Page->satuan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai->Visible) { // nilai ?>
    <tr id="r_nilai"<?= $Page->nilai->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_nilai"><?= $Page->nilai->caption() ?></span></td>
        <td data-name="nilai"<?= $Page->nilai->cellAttributes() ?>>
<span id="el_konversi_nilai">
<span<?= $Page->nilai->viewAttributes() ?>>
<?= $Page->nilai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
    <tr id="r_satuan_id2"<?= $Page->satuan_id2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_satuan_id2"><?= $Page->satuan_id2->caption() ?></span></td>
        <td data-name="satuan_id2"<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="el_konversi_satuan_id2">
<span<?= $Page->satuan_id2->viewAttributes() ?>>
<?= $Page->satuan_id2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->operasi->Visible) { // operasi ?>
    <tr id="r_operasi"<?= $Page->operasi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_operasi"><?= $Page->operasi->caption() ?></span></td>
        <td data-name="operasi"<?= $Page->operasi->cellAttributes() ?>>
<span id="el_konversi_operasi">
<span<?= $Page->operasi->viewAttributes() ?>>
<?= $Page->operasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
    <tr id="r_id_FK"<?= $Page->id_FK->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_konversi_id_FK"><?= $Page->id_FK->caption() ?></span></td>
        <td data-name="id_FK"<?= $Page->id_FK->cellAttributes() ?>>
<span id="el_konversi_id_FK">
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
