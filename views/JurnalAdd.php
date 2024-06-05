<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$JurnalAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { jurnal: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fjurnaladd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fjurnaladd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipejurnal_id", [fields.tipejurnal_id.visible && fields.tipejurnal_id.required ? ew.Validators.required(fields.tipejurnal_id.caption) : null, ew.Validators.integer], fields.tipejurnal_id.isInvalid],
            ["period_id", [fields.period_id.visible && fields.period_id.required ? ew.Validators.required(fields.period_id.caption) : null, ew.Validators.integer], fields.period_id.isInvalid],
            ["createon", [fields.createon.visible && fields.createon.required ? ew.Validators.required(fields.createon.caption) : null, ew.Validators.datetime(fields.createon.clientFormatPattern)], fields.createon.isInvalid],
            ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
            ["person_id", [fields.person_id.visible && fields.person_id.required ? ew.Validators.required(fields.person_id.caption) : null, ew.Validators.integer], fields.person_id.isInvalid],
            ["nomer", [fields.nomer.visible && fields.nomer.required ? ew.Validators.required(fields.nomer.caption) : null], fields.nomer.isInvalid]
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fjurnaladd" id="fjurnaladd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="jurnal">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipejurnal_id->Visible) { // tipejurnal_id ?>
    <div id="r_tipejurnal_id"<?= $Page->tipejurnal_id->rowAttributes() ?>>
        <label id="elh_jurnal_tipejurnal_id" for="x_tipejurnal_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipejurnal_id->caption() ?><?= $Page->tipejurnal_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipejurnal_id->cellAttributes() ?>>
<span id="el_jurnal_tipejurnal_id">
<input type="<?= $Page->tipejurnal_id->getInputTextType() ?>" name="x_tipejurnal_id" id="x_tipejurnal_id" data-table="jurnal" data-field="x_tipejurnal_id" value="<?= $Page->tipejurnal_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipejurnal_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipejurnal_id->formatPattern()) ?>"<?= $Page->tipejurnal_id->editAttributes() ?> aria-describedby="x_tipejurnal_id_help">
<?= $Page->tipejurnal_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipejurnal_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->period_id->Visible) { // period_id ?>
    <div id="r_period_id"<?= $Page->period_id->rowAttributes() ?>>
        <label id="elh_jurnal_period_id" for="x_period_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->period_id->caption() ?><?= $Page->period_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->period_id->cellAttributes() ?>>
<span id="el_jurnal_period_id">
<input type="<?= $Page->period_id->getInputTextType() ?>" name="x_period_id" id="x_period_id" data-table="jurnal" data-field="x_period_id" value="<?= $Page->period_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->period_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->period_id->formatPattern()) ?>"<?= $Page->period_id->editAttributes() ?> aria-describedby="x_period_id_help">
<?= $Page->period_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->period_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->createon->Visible) { // createon ?>
    <div id="r_createon"<?= $Page->createon->rowAttributes() ?>>
        <label id="elh_jurnal_createon" for="x_createon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->createon->caption() ?><?= $Page->createon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createon->cellAttributes() ?>>
<span id="el_jurnal_createon">
<input type="<?= $Page->createon->getInputTextType() ?>" name="x_createon" id="x_createon" data-table="jurnal" data-field="x_createon" value="<?= $Page->createon->EditValue ?>" placeholder="<?= HtmlEncode($Page->createon->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->createon->formatPattern()) ?>"<?= $Page->createon->editAttributes() ?> aria-describedby="x_createon_help">
<?= $Page->createon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->createon->getErrorMessage() ?></div>
<?php if (!$Page->createon->ReadOnly && !$Page->createon->Disabled && !isset($Page->createon->EditAttrs["readonly"]) && !isset($Page->createon->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fjurnaladd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fjurnaladd", "x_createon", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan"<?= $Page->keterangan->rowAttributes() ?>>
        <label id="elh_jurnal_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keterangan->cellAttributes() ?>>
<span id="el_jurnal_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" name="x_keterangan" id="x_keterangan" data-table="jurnal" data-field="x_keterangan" value="<?= $Page->keterangan->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->keterangan->formatPattern()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->person_id->Visible) { // person_id ?>
    <div id="r_person_id"<?= $Page->person_id->rowAttributes() ?>>
        <label id="elh_jurnal_person_id" for="x_person_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->person_id->caption() ?><?= $Page->person_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->person_id->cellAttributes() ?>>
<span id="el_jurnal_person_id">
<input type="<?= $Page->person_id->getInputTextType() ?>" name="x_person_id" id="x_person_id" data-table="jurnal" data-field="x_person_id" value="<?= $Page->person_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->person_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->person_id->formatPattern()) ?>"<?= $Page->person_id->editAttributes() ?> aria-describedby="x_person_id_help">
<?= $Page->person_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->person_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomer->Visible) { // nomer ?>
    <div id="r_nomer"<?= $Page->nomer->rowAttributes() ?>>
        <label id="elh_jurnal_nomer" for="x_nomer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomer->caption() ?><?= $Page->nomer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nomer->cellAttributes() ?>>
<span id="el_jurnal_nomer">
<input type="<?= $Page->nomer->getInputTextType() ?>" name="x_nomer" id="x_nomer" data-table="jurnal" data-field="x_nomer" value="<?= $Page->nomer->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nomer->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nomer->formatPattern()) ?>"<?= $Page->nomer->editAttributes() ?> aria-describedby="x_nomer_help">
<?= $Page->nomer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("jurnald", explode(",", $Page->getCurrentDetailTable())) && $jurnald->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("jurnald", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "JurnaldGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fjurnaladd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fjurnaladd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("jurnal");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
