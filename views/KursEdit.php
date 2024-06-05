<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$KursEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fkursedit" id="fkursedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kurs: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fkursedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fkursedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["matauang_id", [fields.matauang_id.visible && fields.matauang_id.required ? ew.Validators.required(fields.matauang_id.caption) : null, ew.Validators.integer], fields.matauang_id.isInvalid],
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
<input type="hidden" name="t" value="kurs">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_kurs_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_kurs_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="kurs" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
    <div id="r_matauang_id"<?= $Page->matauang_id->rowAttributes() ?>>
        <label id="elh_kurs_matauang_id" for="x_matauang_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->matauang_id->caption() ?><?= $Page->matauang_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->matauang_id->cellAttributes() ?>>
<span id="el_kurs_matauang_id">
<input type="<?= $Page->matauang_id->getInputTextType() ?>" name="x_matauang_id" id="x_matauang_id" data-table="kurs" data-field="x_matauang_id" value="<?= $Page->matauang_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->matauang_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->matauang_id->formatPattern()) ?>"<?= $Page->matauang_id->editAttributes() ?> aria-describedby="x_matauang_id_help">
<?= $Page->matauang_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->matauang_id->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fkursedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fkursedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("kurs");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
