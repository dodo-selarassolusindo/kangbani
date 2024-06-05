<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$SaldoawalAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { saldoawal: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsaldoawaladd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsaldoawaladd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["periode_id", [fields.periode_id.visible && fields.periode_id.required ? ew.Validators.required(fields.periode_id.caption) : null], fields.periode_id.isInvalid],
            ["akun_id", [fields.akun_id.visible && fields.akun_id.required ? ew.Validators.required(fields.akun_id.caption) : null], fields.akun_id.isInvalid],
            ["debet", [fields.debet.visible && fields.debet.required ? ew.Validators.required(fields.debet.caption) : null, ew.Validators.float], fields.debet.isInvalid],
            ["kredit", [fields.kredit.visible && fields.kredit.required ? ew.Validators.required(fields.kredit.caption) : null], fields.kredit.isInvalid],
            ["saldo", [fields.saldo.visible && fields.saldo.required ? ew.Validators.required(fields.saldo.caption) : null, ew.Validators.float], fields.saldo.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "periode_id": <?= $Page->periode_id->toClientList($Page) ?>,
            "akun_id": <?= $Page->akun_id->toClientList($Page) ?>,
        })
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
<form name="fsaldoawaladd" id="fsaldoawaladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="saldoawal">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->periode_id->Visible) { // periode_id ?>
    <div id="r_periode_id"<?= $Page->periode_id->rowAttributes() ?>>
        <label id="elh_saldoawal_periode_id" for="x_periode_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periode_id->caption() ?><?= $Page->periode_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periode_id->cellAttributes() ?>>
<span id="el_saldoawal_periode_id">
    <select
        id="x_periode_id"
        name="x_periode_id"
        class="form-select ew-select<?= $Page->periode_id->isInvalidClass() ?>"
        <?php if (!$Page->periode_id->IsNativeSelect) { ?>
        data-select2-id="fsaldoawaladd_x_periode_id"
        <?php } ?>
        data-table="saldoawal"
        data-field="x_periode_id"
        data-value-separator="<?= $Page->periode_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->periode_id->getPlaceHolder()) ?>"
        <?= $Page->periode_id->editAttributes() ?>>
        <?= $Page->periode_id->selectOptionListHtml("x_periode_id") ?>
    </select>
    <?= $Page->periode_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->periode_id->getErrorMessage() ?></div>
<?= $Page->periode_id->Lookup->getParamTag($Page, "p_x_periode_id") ?>
<?php if (!$Page->periode_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fsaldoawaladd", function() {
    var options = { name: "x_periode_id", selectId: "fsaldoawaladd_x_periode_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsaldoawaladd.lists.periode_id?.lookupOptions.length) {
        options.data = { id: "x_periode_id", form: "fsaldoawaladd" };
    } else {
        options.ajax = { id: "x_periode_id", form: "fsaldoawaladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.saldoawal.fields.periode_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akun_id->Visible) { // akun_id ?>
    <div id="r_akun_id"<?= $Page->akun_id->rowAttributes() ?>>
        <label id="elh_saldoawal_akun_id" for="x_akun_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akun_id->caption() ?><?= $Page->akun_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akun_id->cellAttributes() ?>>
<span id="el_saldoawal_akun_id">
    <select
        id="x_akun_id"
        name="x_akun_id"
        class="form-select ew-select<?= $Page->akun_id->isInvalidClass() ?>"
        <?php if (!$Page->akun_id->IsNativeSelect) { ?>
        data-select2-id="fsaldoawaladd_x_akun_id"
        <?php } ?>
        data-table="saldoawal"
        data-field="x_akun_id"
        data-value-separator="<?= $Page->akun_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->akun_id->getPlaceHolder()) ?>"
        <?= $Page->akun_id->editAttributes() ?>>
        <?= $Page->akun_id->selectOptionListHtml("x_akun_id") ?>
    </select>
    <?= $Page->akun_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->akun_id->getErrorMessage() ?></div>
<?= $Page->akun_id->Lookup->getParamTag($Page, "p_x_akun_id") ?>
<?php if (!$Page->akun_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fsaldoawaladd", function() {
    var options = { name: "x_akun_id", selectId: "fsaldoawaladd_x_akun_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsaldoawaladd.lists.akun_id?.lookupOptions.length) {
        options.data = { id: "x_akun_id", form: "fsaldoawaladd" };
    } else {
        options.ajax = { id: "x_akun_id", form: "fsaldoawaladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.saldoawal.fields.akun_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->debet->Visible) { // debet ?>
    <div id="r_debet"<?= $Page->debet->rowAttributes() ?>>
        <label id="elh_saldoawal_debet" for="x_debet" class="<?= $Page->LeftColumnClass ?>"><?= $Page->debet->caption() ?><?= $Page->debet->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->debet->cellAttributes() ?>>
<span id="el_saldoawal_debet">
<input type="<?= $Page->debet->getInputTextType() ?>" name="x_debet" id="x_debet" data-table="saldoawal" data-field="x_debet" value="<?= $Page->debet->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->debet->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->debet->formatPattern()) ?>"<?= $Page->debet->editAttributes() ?> aria-describedby="x_debet_help">
<?= $Page->debet->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->debet->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kredit->Visible) { // kredit ?>
    <div id="r_kredit"<?= $Page->kredit->rowAttributes() ?>>
        <label id="elh_saldoawal_kredit" for="x_kredit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kredit->caption() ?><?= $Page->kredit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kredit->cellAttributes() ?>>
<span id="el_saldoawal_kredit">
<input type="<?= $Page->kredit->getInputTextType() ?>" name="x_kredit" id="x_kredit" data-table="saldoawal" data-field="x_kredit" value="<?= $Page->kredit->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kredit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kredit->formatPattern()) ?>"<?= $Page->kredit->editAttributes() ?> aria-describedby="x_kredit_help">
<?= $Page->kredit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kredit->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
    <div id="r_saldo"<?= $Page->saldo->rowAttributes() ?>>
        <label id="elh_saldoawal_saldo" for="x_saldo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->saldo->caption() ?><?= $Page->saldo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->saldo->cellAttributes() ?>>
<span id="el_saldoawal_saldo">
<input type="<?= $Page->saldo->getInputTextType() ?>" name="x_saldo" id="x_saldo" data-table="saldoawal" data-field="x_saldo" value="<?= $Page->saldo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->saldo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->saldo->formatPattern()) ?>"<?= $Page->saldo->editAttributes() ?> aria-describedby="x_saldo_help">
<?= $Page->saldo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->saldo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsaldoawaladd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsaldoawaladd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("saldoawal");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
