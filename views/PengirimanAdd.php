<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$PengirimanAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengiriman: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fpengirimanadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpengirimanadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
            ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
            ["akunjual", [fields.akunjual.visible && fields.akunjual.required ? ew.Validators.required(fields.akunjual.caption) : null], fields.akunjual.isInvalid],
            ["akunbeli", [fields.akunbeli.visible && fields.akunbeli.required ? ew.Validators.required(fields.akunbeli.caption) : null], fields.akunbeli.isInvalid],
            ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
            ["tipe", [fields.tipe.visible && fields.tipe.required ? ew.Validators.required(fields.tipe.caption) : null, ew.Validators.integer], fields.tipe.isInvalid]
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
            "akunjual": <?= $Page->akunjual->toClientList($Page) ?>,
            "akunbeli": <?= $Page->akunbeli->toClientList($Page) ?>,
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
<form name="fpengirimanadd" id="fpengirimanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengiriman">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode"<?= $Page->kode->rowAttributes() ?>>
        <label id="elh_pengiriman_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kode->cellAttributes() ?>>
<span id="el_pengiriman_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" name="x_kode" id="x_kode" data-table="pengiriman" data-field="x_kode" value="<?= $Page->kode->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kode->formatPattern()) ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_pengiriman_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_pengiriman_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="pengiriman" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nama->formatPattern()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
    <div id="r_akunjual"<?= $Page->akunjual->rowAttributes() ?>>
        <label id="elh_pengiriman_akunjual" for="x_akunjual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunjual->caption() ?><?= $Page->akunjual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunjual->cellAttributes() ?>>
<span id="el_pengiriman_akunjual">
    <select
        id="x_akunjual"
        name="x_akunjual"
        class="form-select ew-select<?= $Page->akunjual->isInvalidClass() ?>"
        <?php if (!$Page->akunjual->IsNativeSelect) { ?>
        data-select2-id="fpengirimanadd_x_akunjual"
        <?php } ?>
        data-table="pengiriman"
        data-field="x_akunjual"
        data-value-separator="<?= $Page->akunjual->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->akunjual->getPlaceHolder()) ?>"
        <?= $Page->akunjual->editAttributes() ?>>
        <?= $Page->akunjual->selectOptionListHtml("x_akunjual") ?>
    </select>
    <?= $Page->akunjual->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->akunjual->getErrorMessage() ?></div>
<?= $Page->akunjual->Lookup->getParamTag($Page, "p_x_akunjual") ?>
<?php if (!$Page->akunjual->IsNativeSelect) { ?>
<script>
loadjs.ready("fpengirimanadd", function() {
    var options = { name: "x_akunjual", selectId: "fpengirimanadd_x_akunjual" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpengirimanadd.lists.akunjual?.lookupOptions.length) {
        options.data = { id: "x_akunjual", form: "fpengirimanadd" };
    } else {
        options.ajax = { id: "x_akunjual", form: "fpengirimanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengiriman.fields.akunjual.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunbeli->Visible) { // akunbeli ?>
    <div id="r_akunbeli"<?= $Page->akunbeli->rowAttributes() ?>>
        <label id="elh_pengiriman_akunbeli" for="x_akunbeli" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunbeli->caption() ?><?= $Page->akunbeli->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunbeli->cellAttributes() ?>>
<span id="el_pengiriman_akunbeli">
    <select
        id="x_akunbeli"
        name="x_akunbeli"
        class="form-select ew-select<?= $Page->akunbeli->isInvalidClass() ?>"
        <?php if (!$Page->akunbeli->IsNativeSelect) { ?>
        data-select2-id="fpengirimanadd_x_akunbeli"
        <?php } ?>
        data-table="pengiriman"
        data-field="x_akunbeli"
        data-value-separator="<?= $Page->akunbeli->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->akunbeli->getPlaceHolder()) ?>"
        <?= $Page->akunbeli->editAttributes() ?>>
        <?= $Page->akunbeli->selectOptionListHtml("x_akunbeli") ?>
    </select>
    <?= $Page->akunbeli->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->akunbeli->getErrorMessage() ?></div>
<?= $Page->akunbeli->Lookup->getParamTag($Page, "p_x_akunbeli") ?>
<?php if (!$Page->akunbeli->IsNativeSelect) { ?>
<script>
loadjs.ready("fpengirimanadd", function() {
    var options = { name: "x_akunbeli", selectId: "fpengirimanadd_x_akunbeli" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpengirimanadd.lists.akunbeli?.lookupOptions.length) {
        options.data = { id: "x_akunbeli", form: "fpengirimanadd" };
    } else {
        options.ajax = { id: "x_akunbeli", form: "fpengirimanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengiriman.fields.akunbeli.selectOptions);
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
        <label id="elh_pengiriman_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keterangan->cellAttributes() ?>>
<span id="el_pengiriman_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" name="x_keterangan" id="x_keterangan" data-table="pengiriman" data-field="x_keterangan" value="<?= $Page->keterangan->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->keterangan->formatPattern()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipe->Visible) { // tipe ?>
    <div id="r_tipe"<?= $Page->tipe->rowAttributes() ?>>
        <label id="elh_pengiriman_tipe" for="x_tipe" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipe->caption() ?><?= $Page->tipe->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipe->cellAttributes() ?>>
<span id="el_pengiriman_tipe">
<input type="<?= $Page->tipe->getInputTextType() ?>" name="x_tipe" id="x_tipe" data-table="pengiriman" data-field="x_tipe" value="<?= $Page->tipe->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tipe->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipe->formatPattern()) ?>"<?= $Page->tipe->editAttributes() ?> aria-describedby="x_tipe_help">
<?= $Page->tipe->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipe->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpengirimanadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fpengirimanadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("pengiriman");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
