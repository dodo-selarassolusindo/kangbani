<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$AkunEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fakunedit" id="fakunedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { akun: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fakunedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fakunedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["subgrup_id", [fields.subgrup_id.visible && fields.subgrup_id.required ? ew.Validators.required(fields.subgrup_id.caption) : null], fields.subgrup_id.isInvalid],
            ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
            ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
            ["matauang_id", [fields.matauang_id.visible && fields.matauang_id.required ? ew.Validators.required(fields.matauang_id.caption) : null], fields.matauang_id.isInvalid]
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
            "subgrup_id": <?= $Page->subgrup_id->toClientList($Page) ?>,
            "matauang_id": <?= $Page->matauang_id->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="akun">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->subgrup_id->Visible) { // subgrup_id ?>
    <div id="r_subgrup_id"<?= $Page->subgrup_id->rowAttributes() ?>>
        <label id="elh_akun_subgrup_id" for="x_subgrup_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subgrup_id->caption() ?><?= $Page->subgrup_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subgrup_id->cellAttributes() ?>>
<span id="el_akun_subgrup_id">
    <select
        id="x_subgrup_id"
        name="x_subgrup_id"
        class="form-select ew-select<?= $Page->subgrup_id->isInvalidClass() ?>"
        <?php if (!$Page->subgrup_id->IsNativeSelect) { ?>
        data-select2-id="fakunedit_x_subgrup_id"
        <?php } ?>
        data-table="akun"
        data-field="x_subgrup_id"
        data-value-separator="<?= $Page->subgrup_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subgrup_id->getPlaceHolder()) ?>"
        <?= $Page->subgrup_id->editAttributes() ?>>
        <?= $Page->subgrup_id->selectOptionListHtml("x_subgrup_id") ?>
    </select>
    <?= $Page->subgrup_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->subgrup_id->getErrorMessage() ?></div>
<?= $Page->subgrup_id->Lookup->getParamTag($Page, "p_x_subgrup_id") ?>
<?php if (!$Page->subgrup_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fakunedit", function() {
    var options = { name: "x_subgrup_id", selectId: "fakunedit_x_subgrup_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fakunedit.lists.subgrup_id?.lookupOptions.length) {
        options.data = { id: "x_subgrup_id", form: "fakunedit" };
    } else {
        options.ajax = { id: "x_subgrup_id", form: "fakunedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.akun.fields.subgrup_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode"<?= $Page->kode->rowAttributes() ?>>
        <label id="elh_akun_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kode->cellAttributes() ?>>
<span id="el_akun_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" name="x_kode" id="x_kode" data-table="akun" data-field="x_kode" value="<?= $Page->kode->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kode->formatPattern()) ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_akun_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_akun_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="akun" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nama->formatPattern()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
    <div id="r_matauang_id"<?= $Page->matauang_id->rowAttributes() ?>>
        <label id="elh_akun_matauang_id" for="x_matauang_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->matauang_id->caption() ?><?= $Page->matauang_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->matauang_id->cellAttributes() ?>>
<span id="el_akun_matauang_id">
    <select
        id="x_matauang_id"
        name="x_matauang_id"
        class="form-select ew-select<?= $Page->matauang_id->isInvalidClass() ?>"
        <?php if (!$Page->matauang_id->IsNativeSelect) { ?>
        data-select2-id="fakunedit_x_matauang_id"
        <?php } ?>
        data-table="akun"
        data-field="x_matauang_id"
        data-value-separator="<?= $Page->matauang_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->matauang_id->getPlaceHolder()) ?>"
        <?= $Page->matauang_id->editAttributes() ?>>
        <?= $Page->matauang_id->selectOptionListHtml("x_matauang_id") ?>
    </select>
    <?= $Page->matauang_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->matauang_id->getErrorMessage() ?></div>
<?= $Page->matauang_id->Lookup->getParamTag($Page, "p_x_matauang_id") ?>
<?php if (!$Page->matauang_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fakunedit", function() {
    var options = { name: "x_matauang_id", selectId: "fakunedit_x_matauang_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fakunedit.lists.matauang_id?.lookupOptions.length) {
        options.data = { id: "x_matauang_id", form: "fakunedit" };
    } else {
        options.ajax = { id: "x_matauang_id", form: "fakunedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.akun.fields.matauang_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="akun" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fakunedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fakunedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("akun");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
