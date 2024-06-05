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
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["satuan_id", [fields.satuan_id.visible && fields.satuan_id.required ? ew.Validators.required(fields.satuan_id.caption) : null, ew.Validators.integer], fields.satuan_id.isInvalid],
            ["nilai", [fields.nilai.visible && fields.nilai.required ? ew.Validators.required(fields.nilai.caption) : null, ew.Validators.float], fields.nilai.isInvalid],
            ["satuan_id2", [fields.satuan_id2.visible && fields.satuan_id2.required ? ew.Validators.required(fields.satuan_id2.caption) : null, ew.Validators.integer], fields.satuan_id2.isInvalid],
            ["operasi", [fields.operasi.visible && fields.operasi.required ? ew.Validators.required(fields.operasi.caption) : null, ew.Validators.integer], fields.operasi.isInvalid],
            ["id_FK", [fields.id_FK.visible && fields.id_FK.required ? ew.Validators.required(fields.id_FK.caption) : null, ew.Validators.integer], fields.id_FK.isInvalid]
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
<input type="hidden" name="t" value="konversi">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_konversi_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_konversi_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="konversi" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
    <div id="r_satuan_id"<?= $Page->satuan_id->rowAttributes() ?>>
        <label id="elh_konversi_satuan_id" for="x_satuan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_id->caption() ?><?= $Page->satuan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el_konversi_satuan_id">
<input type="<?= $Page->satuan_id->getInputTextType() ?>" name="x_satuan_id" id="x_satuan_id" data-table="konversi" data-field="x_satuan_id" value="<?= $Page->satuan_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->satuan_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->satuan_id->formatPattern()) ?>"<?= $Page->satuan_id->editAttributes() ?> aria-describedby="x_satuan_id_help">
<?= $Page->satuan_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satuan_id->getErrorMessage() ?></div>
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
<input type="<?= $Page->satuan_id2->getInputTextType() ?>" name="x_satuan_id2" id="x_satuan_id2" data-table="konversi" data-field="x_satuan_id2" value="<?= $Page->satuan_id2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->satuan_id2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->satuan_id2->formatPattern()) ?>"<?= $Page->satuan_id2->editAttributes() ?> aria-describedby="x_satuan_id2_help">
<?= $Page->satuan_id2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satuan_id2->getErrorMessage() ?></div>
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
<?php if ($Page->id_FK->Visible) { // id_FK ?>
    <div id="r_id_FK"<?= $Page->id_FK->rowAttributes() ?>>
        <label id="elh_konversi_id_FK" for="x_id_FK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_FK->caption() ?><?= $Page->id_FK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_FK->cellAttributes() ?>>
<span id="el_konversi_id_FK">
<input type="<?= $Page->id_FK->getInputTextType() ?>" name="x_id_FK" id="x_id_FK" data-table="konversi" data-field="x_id_FK" value="<?= $Page->id_FK->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id_FK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_FK->formatPattern()) ?>"<?= $Page->id_FK->editAttributes() ?> aria-describedby="x_id_FK_help">
<?= $Page->id_FK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_FK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
