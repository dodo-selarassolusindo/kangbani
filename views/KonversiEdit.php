<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$KonversiEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fkonversiedit" id="fkonversiedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { konversi: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fkonversiedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkonversiedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["satuan_id", [fields.satuan_id.visible && fields.satuan_id.required ? ew.Validators.required(fields.satuan_id.caption) : null], fields.satuan_id.isInvalid],
            ["nilai", [fields.nilai.visible && fields.nilai.required ? ew.Validators.required(fields.nilai.caption) : null, ew.Validators.float], fields.nilai.isInvalid],
            ["satuan_id2", [fields.satuan_id2.visible && fields.satuan_id2.required ? ew.Validators.required(fields.satuan_id2.caption) : null], fields.satuan_id2.isInvalid],
            ["operasi", [fields.operasi.visible && fields.operasi.required ? ew.Validators.required(fields.operasi.caption) : null, ew.Validators.integer], fields.operasi.isInvalid]
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
            "satuan_id": <?= $Page->satuan_id->toClientList($Page) ?>,
            "satuan_id2": <?= $Page->satuan_id2->toClientList($Page) ?>,
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="konversi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
    <div id="r_satuan_id"<?= $Page->satuan_id->rowAttributes() ?>>
        <label id="elh_konversi_satuan_id" for="x_satuan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_id->caption() ?><?= $Page->satuan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el_konversi_satuan_id">
    <select
        id="x_satuan_id"
        name="x_satuan_id"
        class="form-select ew-select<?= $Page->satuan_id->isInvalidClass() ?>"
        <?php if (!$Page->satuan_id->IsNativeSelect) { ?>
        data-select2-id="fkonversiedit_x_satuan_id"
        <?php } ?>
        data-table="konversi"
        data-field="x_satuan_id"
        data-value-separator="<?= $Page->satuan_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->satuan_id->getPlaceHolder()) ?>"
        <?= $Page->satuan_id->editAttributes() ?>>
        <?= $Page->satuan_id->selectOptionListHtml("x_satuan_id") ?>
    </select>
    <?= $Page->satuan_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->satuan_id->getErrorMessage() ?></div>
<?= $Page->satuan_id->Lookup->getParamTag($Page, "p_x_satuan_id") ?>
<?php if (!$Page->satuan_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fkonversiedit", function() {
    var options = { name: "x_satuan_id", selectId: "fkonversiedit_x_satuan_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkonversiedit.lists.satuan_id?.lookupOptions.length) {
        options.data = { id: "x_satuan_id", form: "fkonversiedit" };
    } else {
        options.ajax = { id: "x_satuan_id", form: "fkonversiedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.konversi.fields.satuan_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai->Visible) { // nilai ?>
    <div id="r_nilai"<?= $Page->nilai->rowAttributes() ?>>
        <label id="elh_konversi_nilai" for="x_nilai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai->caption() ?><?= $Page->nilai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nilai->cellAttributes() ?>>
<span id="el_konversi_nilai">
<input type="<?= $Page->nilai->getInputTextType() ?>" name="x_nilai" id="x_nilai" data-table="konversi" data-field="x_nilai" value="<?= $Page->nilai->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nilai->formatPattern()) ?>"<?= $Page->nilai->editAttributes() ?> aria-describedby="x_nilai_help">
<?= $Page->nilai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
    <div id="r_satuan_id2"<?= $Page->satuan_id2->rowAttributes() ?>>
        <label id="elh_konversi_satuan_id2" for="x_satuan_id2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_id2->caption() ?><?= $Page->satuan_id2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="el_konversi_satuan_id2">
    <select
        id="x_satuan_id2"
        name="x_satuan_id2"
        class="form-select ew-select<?= $Page->satuan_id2->isInvalidClass() ?>"
        <?php if (!$Page->satuan_id2->IsNativeSelect) { ?>
        data-select2-id="fkonversiedit_x_satuan_id2"
        <?php } ?>
        data-table="konversi"
        data-field="x_satuan_id2"
        data-value-separator="<?= $Page->satuan_id2->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->satuan_id2->getPlaceHolder()) ?>"
        <?= $Page->satuan_id2->editAttributes() ?>>
        <?= $Page->satuan_id2->selectOptionListHtml("x_satuan_id2") ?>
    </select>
    <?= $Page->satuan_id2->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->satuan_id2->getErrorMessage() ?></div>
<?= $Page->satuan_id2->Lookup->getParamTag($Page, "p_x_satuan_id2") ?>
<?php if (!$Page->satuan_id2->IsNativeSelect) { ?>
<script>
loadjs.ready("fkonversiedit", function() {
    var options = { name: "x_satuan_id2", selectId: "fkonversiedit_x_satuan_id2" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkonversiedit.lists.satuan_id2?.lookupOptions.length) {
        options.data = { id: "x_satuan_id2", form: "fkonversiedit" };
    } else {
        options.ajax = { id: "x_satuan_id2", form: "fkonversiedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.konversi.fields.satuan_id2.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->operasi->Visible) { // operasi ?>
    <div id="r_operasi"<?= $Page->operasi->rowAttributes() ?>>
        <label id="elh_konversi_operasi" for="x_operasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->operasi->caption() ?><?= $Page->operasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->operasi->cellAttributes() ?>>
<span id="el_konversi_operasi">
<input type="<?= $Page->operasi->getInputTextType() ?>" name="x_operasi" id="x_operasi" data-table="konversi" data-field="x_operasi" value="<?= $Page->operasi->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->operasi->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->operasi->formatPattern()) ?>"<?= $Page->operasi->editAttributes() ?> aria-describedby="x_operasi_help">
<?= $Page->operasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->operasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="konversi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkonversiedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkonversiedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("konversi");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
