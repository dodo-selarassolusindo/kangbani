<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$PeriodeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { periode: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fperiodeadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fperiodeadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["start", [fields.start.visible && fields.start.required ? ew.Validators.required(fields.start.caption) : null, ew.Validators.datetime(fields.start.clientFormatPattern)], fields.start.isInvalid],
            ["end", [fields.end.visible && fields.end.required ? ew.Validators.required(fields.end.caption) : null, ew.Validators.datetime(fields.end.clientFormatPattern)], fields.end.isInvalid],
            ["isaktif", [fields.isaktif.visible && fields.isaktif.required ? ew.Validators.required(fields.isaktif.caption) : null], fields.isaktif.isInvalid],
            ["user_id", [fields.user_id.visible && fields.user_id.required ? ew.Validators.required(fields.user_id.caption) : null, ew.Validators.integer], fields.user_id.isInvalid]
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
            "isaktif": <?= $Page->isaktif->toClientList($Page) ?>,
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
<form name="fperiodeadd" id="fperiodeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="periode">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->start->Visible) { // start ?>
    <div id="r_start"<?= $Page->start->rowAttributes() ?>>
        <label id="elh_periode_start" for="x_start" class="<?= $Page->LeftColumnClass ?>"><?= $Page->start->caption() ?><?= $Page->start->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->start->cellAttributes() ?>>
<span id="el_periode_start">
<input type="<?= $Page->start->getInputTextType() ?>" name="x_start" id="x_start" data-table="periode" data-field="x_start" value="<?= $Page->start->EditValue ?>" placeholder="<?= HtmlEncode($Page->start->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->start->formatPattern()) ?>"<?= $Page->start->editAttributes() ?> aria-describedby="x_start_help">
<?= $Page->start->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->start->getErrorMessage() ?></div>
<?php if (!$Page->start->ReadOnly && !$Page->start->Disabled && !isset($Page->start->EditAttrs["readonly"]) && !isset($Page->start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fperiodeadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fperiodeadd", "x_start", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->end->Visible) { // end ?>
    <div id="r_end"<?= $Page->end->rowAttributes() ?>>
        <label id="elh_periode_end" for="x_end" class="<?= $Page->LeftColumnClass ?>"><?= $Page->end->caption() ?><?= $Page->end->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->end->cellAttributes() ?>>
<span id="el_periode_end">
<input type="<?= $Page->end->getInputTextType() ?>" name="x_end" id="x_end" data-table="periode" data-field="x_end" value="<?= $Page->end->EditValue ?>" placeholder="<?= HtmlEncode($Page->end->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->end->formatPattern()) ?>"<?= $Page->end->editAttributes() ?> aria-describedby="x_end_help">
<?= $Page->end->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->end->getErrorMessage() ?></div>
<?php if (!$Page->end->ReadOnly && !$Page->end->Disabled && !isset($Page->end->EditAttrs["readonly"]) && !isset($Page->end->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fperiodeadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fperiodeadd", "x_end", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isaktif->Visible) { // isaktif ?>
    <div id="r_isaktif"<?= $Page->isaktif->rowAttributes() ?>>
        <label id="elh_periode_isaktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isaktif->caption() ?><?= $Page->isaktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->isaktif->cellAttributes() ?>>
<span id="el_periode_isaktif">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->isaktif->isInvalidClass() ?>" data-table="periode" data-field="x_isaktif" data-boolean name="x_isaktif" id="x_isaktif" value="1"<?= ConvertToBool($Page->isaktif->CurrentValue) ? " checked" : "" ?><?= $Page->isaktif->editAttributes() ?> aria-describedby="x_isaktif_help">
    <div class="invalid-feedback"><?= $Page->isaktif->getErrorMessage() ?></div>
</div>
<?= $Page->isaktif->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_id->Visible) { // user_id ?>
    <div id="r_user_id"<?= $Page->user_id->rowAttributes() ?>>
        <label id="elh_periode_user_id" for="x_user_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_id->caption() ?><?= $Page->user_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_id->cellAttributes() ?>>
<span id="el_periode_user_id">
<input type="<?= $Page->user_id->getInputTextType() ?>" name="x_user_id" id="x_user_id" data-table="periode" data-field="x_user_id" value="<?= $Page->user_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->user_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user_id->formatPattern()) ?>"<?= $Page->user_id->editAttributes() ?> aria-describedby="x_user_id_help">
<?= $Page->user_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fperiodeadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fperiodeadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("periode");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
