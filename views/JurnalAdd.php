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
            ["tipejurnal_id", [fields.tipejurnal_id.visible && fields.tipejurnal_id.required ? ew.Validators.required(fields.tipejurnal_id.caption) : null], fields.tipejurnal_id.isInvalid],
            ["period_id", [fields.period_id.visible && fields.period_id.required ? ew.Validators.required(fields.period_id.caption) : null], fields.period_id.isInvalid],
            ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
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
            "tipejurnal_id": <?= $Page->tipejurnal_id->toClientList($Page) ?>,
            "period_id": <?= $Page->period_id->toClientList($Page) ?>,
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
    <select
        id="x_tipejurnal_id"
        name="x_tipejurnal_id"
        class="form-select ew-select<?= $Page->tipejurnal_id->isInvalidClass() ?>"
        <?php if (!$Page->tipejurnal_id->IsNativeSelect) { ?>
        data-select2-id="fjurnaladd_x_tipejurnal_id"
        <?php } ?>
        data-table="jurnal"
        data-field="x_tipejurnal_id"
        data-value-separator="<?= $Page->tipejurnal_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipejurnal_id->getPlaceHolder()) ?>"
        <?= $Page->tipejurnal_id->editAttributes() ?>>
        <?= $Page->tipejurnal_id->selectOptionListHtml("x_tipejurnal_id") ?>
    </select>
    <?= $Page->tipejurnal_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipejurnal_id->getErrorMessage() ?></div>
<?= $Page->tipejurnal_id->Lookup->getParamTag($Page, "p_x_tipejurnal_id") ?>
<?php if (!$Page->tipejurnal_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fjurnaladd", function() {
    var options = { name: "x_tipejurnal_id", selectId: "fjurnaladd_x_tipejurnal_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fjurnaladd.lists.tipejurnal_id?.lookupOptions.length) {
        options.data = { id: "x_tipejurnal_id", form: "fjurnaladd" };
    } else {
        options.ajax = { id: "x_tipejurnal_id", form: "fjurnaladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.jurnal.fields.tipejurnal_id.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->period_id->Visible) { // period_id ?>
    <div id="r_period_id"<?= $Page->period_id->rowAttributes() ?>>
        <label id="elh_jurnal_period_id" for="x_period_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->period_id->caption() ?><?= $Page->period_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->period_id->cellAttributes() ?>>
<span id="el_jurnal_period_id">
    <select
        id="x_period_id"
        name="x_period_id"
        class="form-select ew-select<?= $Page->period_id->isInvalidClass() ?>"
        <?php if (!$Page->period_id->IsNativeSelect) { ?>
        data-select2-id="fjurnaladd_x_period_id"
        <?php } ?>
        data-table="jurnal"
        data-field="x_period_id"
        data-value-separator="<?= $Page->period_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->period_id->getPlaceHolder()) ?>"
        <?= $Page->period_id->editAttributes() ?>>
        <?= $Page->period_id->selectOptionListHtml("x_period_id") ?>
    </select>
    <?= $Page->period_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->period_id->getErrorMessage() ?></div>
<?= $Page->period_id->Lookup->getParamTag($Page, "p_x_period_id") ?>
<?php if (!$Page->period_id->IsNativeSelect) { ?>
<script>
loadjs.ready("fjurnaladd", function() {
    var options = { name: "x_period_id", selectId: "fjurnaladd_x_period_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fjurnaladd.lists.period_id?.lookupOptions.length) {
        options.data = { id: "x_period_id", form: "fjurnaladd" };
    } else {
        options.ajax = { id: "x_period_id", form: "fjurnaladd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.jurnal.fields.period_id.selectOptions);
    ew.createSelect(options);
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
