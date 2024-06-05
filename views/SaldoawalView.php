<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$SaldoawalView = &$Page;
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
<form name="fsaldoawalview" id="fsaldoawalview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { saldoawal: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsaldoawalview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsaldoawalview")
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
<input type="hidden" name="t" value="saldoawal">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_saldoawal_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->periode_id->Visible) { // periode_id ?>
    <tr id="r_periode_id"<?= $Page->periode_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_periode_id"><?= $Page->periode_id->caption() ?></span></td>
        <td data-name="periode_id"<?= $Page->periode_id->cellAttributes() ?>>
<span id="el_saldoawal_periode_id">
<span<?= $Page->periode_id->viewAttributes() ?>>
<?= $Page->periode_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->akun_id->Visible) { // akun_id ?>
    <tr id="r_akun_id"<?= $Page->akun_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_akun_id"><?= $Page->akun_id->caption() ?></span></td>
        <td data-name="akun_id"<?= $Page->akun_id->cellAttributes() ?>>
<span id="el_saldoawal_akun_id">
<span<?= $Page->akun_id->viewAttributes() ?>>
<?= $Page->akun_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->debet->Visible) { // debet ?>
    <tr id="r_debet"<?= $Page->debet->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_debet"><?= $Page->debet->caption() ?></span></td>
        <td data-name="debet"<?= $Page->debet->cellAttributes() ?>>
<span id="el_saldoawal_debet">
<span<?= $Page->debet->viewAttributes() ?>>
<?= $Page->debet->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kredit->Visible) { // kredit ?>
    <tr id="r_kredit"<?= $Page->kredit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_kredit"><?= $Page->kredit->caption() ?></span></td>
        <td data-name="kredit"<?= $Page->kredit->cellAttributes() ?>>
<span id="el_saldoawal_kredit">
<span<?= $Page->kredit->viewAttributes() ?>>
<?= $Page->kredit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <tr id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_user_id"><?= $Page->user_id->caption() ?></span></td>
        <td data-name="user_id"<?= $Page->user_id->cellAttributes() ?>>
<span id="el_saldoawal_user_id">
<span<?= $Page->user_id->viewAttributes() ?>>
<?= $Page->user_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
    <tr id="r_saldo"<?= $Page->saldo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_saldoawal_saldo"><?= $Page->saldo->caption() ?></span></td>
        <td data-name="saldo"<?= $Page->saldo->cellAttributes() ?>>
<span id="el_saldoawal_saldo">
<span<?= $Page->saldo->viewAttributes() ?>>
<?= $Page->saldo->getViewValue() ?></span>
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
