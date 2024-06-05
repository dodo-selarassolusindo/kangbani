<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$SaldoawalEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsaldoawaledit" id="fsaldoawaledit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { saldoawal: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsaldoawaledit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsaldoawaledit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["periode_id", [fields.periode_id.visible && fields.periode_id.required ? ew.Validators.required(fields.periode_id.caption) : null, ew.Validators.integer], fields.periode_id.isInvalid],
            ["akun_id", [fields.akun_id.visible && fields.akun_id.required ? ew.Validators.required(fields.akun_id.caption) : null, ew.Validators.integer], fields.akun_id.isInvalid],
            ["debet", [fields.debet.visible && fields.debet.required ? ew.Validators.required(fields.debet.caption) : null, ew.Validators.float], fields.debet.isInvalid],
            ["kredit", [fields.kredit.visible && fields.kredit.required ? ew.Validators.required(fields.kredit.caption) : null], fields.kredit.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null, ew.Validators.integer], fields.user_id.isInvalid],
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
<input type="hidden" name="t" value="saldoawal">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_saldoawal_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_saldoawal_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="saldoawal" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->periode_id->Visible) { // periode_id ?>
    <div id="r_periode_id"<?= $Page->periode_id->rowAttributes() ?>>
        <label id="elh_saldoawal_periode_id" for="x_periode_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->periode_id->caption() ?><?= $Page->periode_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->periode_id->cellAttributes() ?>>
<span id="el_saldoawal_periode_id">
<input type="<?= $Page->periode_id->getInputTextType() ?>" name="x_periode_id" id="x_periode_id" data-table="saldoawal" data-field="x_periode_id" value="<?= $Page->periode_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->periode_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->periode_id->formatPattern()) ?>"<?= $Page->periode_id->editAttributes() ?> aria-describedby="x_periode_id_help">
<?= $Page->periode_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->periode_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akun_id->Visible) { // akun_id ?>
    <div id="r_akun_id"<?= $Page->akun_id->rowAttributes() ?>>
        <label id="elh_saldoawal_akun_id" for="x_akun_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akun_id->caption() ?><?= $Page->akun_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akun_id->cellAttributes() ?>>
<span id="el_saldoawal_akun_id">
<input type="<?= $Page->akun_id->getInputTextType() ?>" name="x_akun_id" id="x_akun_id" data-table="saldoawal" data-field="x_akun_id" value="<?= $Page->akun_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->akun_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->akun_id->formatPattern()) ?>"<?= $Page->akun_id->editAttributes() ?> aria-describedby="x_akun_id_help">
<?= $Page->akun_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akun_id->getErrorMessage() ?></div>
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
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <label id="elh_saldoawal_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_id->cellAttributes() ?>>
<span id="el_saldoawal_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" name="x_user_id" id="x_user_id" data-table="saldoawal" data-field="x_user_id" value="<?= $Page->user_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user_id->formatPattern()) ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsaldoawaledit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsaldoawaledit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("saldoawal");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
