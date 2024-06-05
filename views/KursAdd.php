<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$KursAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kurs: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fkursadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkursadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["matauang_id", [fields.matauang_id.visible && fields.matauang_id.required ? ew.Validators.required(fields.matauang_id.caption) : null], fields.matauang_id.isInvalid],
            ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.integer], fields.tanggal.isInvalid],
            ["nilai", [fields.nilai.visible && fields.nilai.required ? ew.Validators.required(fields.nilai.caption) : null, ew.Validators.integer], fields.nilai.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fkursadd" id="fkursadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kurs">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
    <div id="r_matauang_id"<?= $Page->matauang_id->rowAttributes() ?>>
        <label id="elh_kurs_matauang_id" for="x_matauang_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->matauang_id->caption() ?><?= $Page->matauang_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->matauang_id->cellAttributes() ?>>
<span id="el_kurs_matauang_id">
    <select
        id="x_matauang_id"
        name="x_matauang_id"
        class="form-select ew-select<?= $Page->matauang_id->isInvalidClass() ?>"
        <?php if (!$Page->matauang_id->IsNativeSelect) { ?>
        data-select2-id="fkursadd_x_matauang_id"
        <?php } ?>
        data-table="kurs"
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
loadjs.ready("fkursadd", function() {
    var options = { name: "x_matauang_id", selectId: "fkursadd_x_matauang_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fkursadd.lists.matauang_id?.lookupOptions.length) {
        options.data = { id: "x_matauang_id", form: "fkursadd" };
    } else {
        options.ajax = { id: "x_matauang_id", form: "fkursadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.kurs.fields.matauang_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <label id="elh_kurs_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_kurs_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" name="x_tanggal" id="x_tanggal" data-table="kurs" data-field="x_tanggal" value="<?= $Page->tanggal->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tanggal->formatPattern()) ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai->Visible) { // nilai ?>
    <div id="r_nilai"<?= $Page->nilai->rowAttributes() ?>>
        <label id="elh_kurs_nilai" for="x_nilai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai->caption() ?><?= $Page->nilai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nilai->cellAttributes() ?>>
<span id="el_kurs_nilai">
<input type="<?= $Page->nilai->getInputTextType() ?>" name="x_nilai" id="x_nilai" data-table="kurs" data-field="x_nilai" value="<?= $Page->nilai->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->nilai->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nilai->formatPattern()) ?>"<?= $Page->nilai->editAttributes() ?> aria-describedby="x_nilai_help">
<?= $Page->nilai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkursadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkursadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("kurs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
