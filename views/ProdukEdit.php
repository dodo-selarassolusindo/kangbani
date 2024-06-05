<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$ProdukEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fprodukedit" id="fprodukedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { produk: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fprodukedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fprodukedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
            ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
            ["kelompok_id", [fields.kelompok_id.visible && fields.kelompok_id.required ? ew.Validators.required(fields.kelompok_id.caption) : null, ew.Validators.integer], fields.kelompok_id.isInvalid],
            ["satuan_id", [fields.satuan_id.visible && fields.satuan_id.required ? ew.Validators.required(fields.satuan_id.caption) : null, ew.Validators.integer], fields.satuan_id.isInvalid],
            ["satuan_id2", [fields.satuan_id2.visible && fields.satuan_id2.required ? ew.Validators.required(fields.satuan_id2.caption) : null, ew.Validators.integer], fields.satuan_id2.isInvalid],
            ["gudang_id", [fields.gudang_id.visible && fields.gudang_id.required ? ew.Validators.required(fields.gudang_id.caption) : null, ew.Validators.integer], fields.gudang_id.isInvalid],
            ["minstok", [fields.minstok.visible && fields.minstok.required ? ew.Validators.required(fields.minstok.caption) : null, ew.Validators.float], fields.minstok.isInvalid],
            ["minorder", [fields.minorder.visible && fields.minorder.required ? ew.Validators.required(fields.minorder.caption) : null, ew.Validators.float], fields.minorder.isInvalid],
            ["akunhpp", [fields.akunhpp.visible && fields.akunhpp.required ? ew.Validators.required(fields.akunhpp.caption) : null, ew.Validators.integer], fields.akunhpp.isInvalid],
            ["akunjual", [fields.akunjual.visible && fields.akunjual.required ? ew.Validators.required(fields.akunjual.caption) : null, ew.Validators.integer], fields.akunjual.isInvalid],
            ["akunpersediaan", [fields.akunpersediaan.visible && fields.akunpersediaan.required ? ew.Validators.required(fields.akunpersediaan.caption) : null, ew.Validators.integer], fields.akunpersediaan.isInvalid],
            ["akunreturjual", [fields.akunreturjual.visible && fields.akunreturjual.required ? ew.Validators.required(fields.akunreturjual.caption) : null, ew.Validators.integer], fields.akunreturjual.isInvalid],
            ["hargapokok", [fields.hargapokok.visible && fields.hargapokok.required ? ew.Validators.required(fields.hargapokok.caption) : null, ew.Validators.float], fields.hargapokok.isInvalid],
            ["p", [fields.p.visible && fields.p.required ? ew.Validators.required(fields.p.caption) : null, ew.Validators.float], fields.p.isInvalid],
            ["l", [fields.l.visible && fields.l.required ? ew.Validators.required(fields.l.caption) : null, ew.Validators.float], fields.l.isInvalid],
            ["_t", [fields._t.visible && fields._t.required ? ew.Validators.required(fields._t.caption) : null, ew.Validators.float], fields._t.isInvalid],
            ["berat", [fields.berat.visible && fields.berat.required ? ew.Validators.required(fields.berat.caption) : null, ew.Validators.float], fields.berat.isInvalid],
            ["supplier_id", [fields.supplier_id.visible && fields.supplier_id.required ? ew.Validators.required(fields.supplier_id.caption) : null, ew.Validators.integer], fields.supplier_id.isInvalid],
            ["waktukirim", [fields.waktukirim.visible && fields.waktukirim.required ? ew.Validators.required(fields.waktukirim.caption) : null, ew.Validators.integer], fields.waktukirim.isInvalid],
            ["aktif", [fields.aktif.visible && fields.aktif.required ? ew.Validators.required(fields.aktif.caption) : null, ew.Validators.integer], fields.aktif.isInvalid],
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
<input type="hidden" name="t" value="produk">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_produk_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_produk_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="produk" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode"<?= $Page->kode->rowAttributes() ?>>
        <label id="elh_produk_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kode->cellAttributes() ?>>
<span id="el_produk_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" name="x_kode" id="x_kode" data-table="produk" data-field="x_kode" value="<?= $Page->kode->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kode->formatPattern()) ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_produk_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_produk_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="produk" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nama->formatPattern()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kelompok_id->Visible) { // kelompok_id ?>
    <div id="r_kelompok_id"<?= $Page->kelompok_id->rowAttributes() ?>>
        <label id="elh_produk_kelompok_id" for="x_kelompok_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kelompok_id->caption() ?><?= $Page->kelompok_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kelompok_id->cellAttributes() ?>>
<span id="el_produk_kelompok_id">
<input type="<?= $Page->kelompok_id->getInputTextType() ?>" name="x_kelompok_id" id="x_kelompok_id" data-table="produk" data-field="x_kelompok_id" value="<?= $Page->kelompok_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->kelompok_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kelompok_id->formatPattern()) ?>"<?= $Page->kelompok_id->editAttributes() ?> aria-describedby="x_kelompok_id_help">
<?= $Page->kelompok_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kelompok_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan_id->Visible) { // satuan_id ?>
    <div id="r_satuan_id"<?= $Page->satuan_id->rowAttributes() ?>>
        <label id="elh_produk_satuan_id" for="x_satuan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_id->caption() ?><?= $Page->satuan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satuan_id->cellAttributes() ?>>
<span id="el_produk_satuan_id">
<input type="<?= $Page->satuan_id->getInputTextType() ?>" name="x_satuan_id" id="x_satuan_id" data-table="produk" data-field="x_satuan_id" value="<?= $Page->satuan_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->satuan_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->satuan_id->formatPattern()) ?>"<?= $Page->satuan_id->editAttributes() ?> aria-describedby="x_satuan_id_help">
<?= $Page->satuan_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satuan_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->satuan_id2->Visible) { // satuan_id2 ?>
    <div id="r_satuan_id2"<?= $Page->satuan_id2->rowAttributes() ?>>
        <label id="elh_produk_satuan_id2" for="x_satuan_id2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->satuan_id2->caption() ?><?= $Page->satuan_id2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->satuan_id2->cellAttributes() ?>>
<span id="el_produk_satuan_id2">
<input type="<?= $Page->satuan_id2->getInputTextType() ?>" name="x_satuan_id2" id="x_satuan_id2" data-table="produk" data-field="x_satuan_id2" value="<?= $Page->satuan_id2->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->satuan_id2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->satuan_id2->formatPattern()) ?>"<?= $Page->satuan_id2->editAttributes() ?> aria-describedby="x_satuan_id2_help">
<?= $Page->satuan_id2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->satuan_id2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gudang_id->Visible) { // gudang_id ?>
    <div id="r_gudang_id"<?= $Page->gudang_id->rowAttributes() ?>>
        <label id="elh_produk_gudang_id" for="x_gudang_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gudang_id->caption() ?><?= $Page->gudang_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->gudang_id->cellAttributes() ?>>
<span id="el_produk_gudang_id">
<input type="<?= $Page->gudang_id->getInputTextType() ?>" name="x_gudang_id" id="x_gudang_id" data-table="produk" data-field="x_gudang_id" value="<?= $Page->gudang_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->gudang_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->gudang_id->formatPattern()) ?>"<?= $Page->gudang_id->editAttributes() ?> aria-describedby="x_gudang_id_help">
<?= $Page->gudang_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gudang_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->minstok->Visible) { // minstok ?>
    <div id="r_minstok"<?= $Page->minstok->rowAttributes() ?>>
        <label id="elh_produk_minstok" for="x_minstok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->minstok->caption() ?><?= $Page->minstok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->minstok->cellAttributes() ?>>
<span id="el_produk_minstok">
<input type="<?= $Page->minstok->getInputTextType() ?>" name="x_minstok" id="x_minstok" data-table="produk" data-field="x_minstok" value="<?= $Page->minstok->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->minstok->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->minstok->formatPattern()) ?>"<?= $Page->minstok->editAttributes() ?> aria-describedby="x_minstok_help">
<?= $Page->minstok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->minstok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->minorder->Visible) { // minorder ?>
    <div id="r_minorder"<?= $Page->minorder->rowAttributes() ?>>
        <label id="elh_produk_minorder" for="x_minorder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->minorder->caption() ?><?= $Page->minorder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->minorder->cellAttributes() ?>>
<span id="el_produk_minorder">
<input type="<?= $Page->minorder->getInputTextType() ?>" name="x_minorder" id="x_minorder" data-table="produk" data-field="x_minorder" value="<?= $Page->minorder->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->minorder->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->minorder->formatPattern()) ?>"<?= $Page->minorder->editAttributes() ?> aria-describedby="x_minorder_help">
<?= $Page->minorder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->minorder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunhpp->Visible) { // akunhpp ?>
    <div id="r_akunhpp"<?= $Page->akunhpp->rowAttributes() ?>>
        <label id="elh_produk_akunhpp" for="x_akunhpp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunhpp->caption() ?><?= $Page->akunhpp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunhpp->cellAttributes() ?>>
<span id="el_produk_akunhpp">
<input type="<?= $Page->akunhpp->getInputTextType() ?>" name="x_akunhpp" id="x_akunhpp" data-table="produk" data-field="x_akunhpp" value="<?= $Page->akunhpp->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->akunhpp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->akunhpp->formatPattern()) ?>"<?= $Page->akunhpp->editAttributes() ?> aria-describedby="x_akunhpp_help">
<?= $Page->akunhpp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akunhpp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunjual->Visible) { // akunjual ?>
    <div id="r_akunjual"<?= $Page->akunjual->rowAttributes() ?>>
        <label id="elh_produk_akunjual" for="x_akunjual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunjual->caption() ?><?= $Page->akunjual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunjual->cellAttributes() ?>>
<span id="el_produk_akunjual">
<input type="<?= $Page->akunjual->getInputTextType() ?>" name="x_akunjual" id="x_akunjual" data-table="produk" data-field="x_akunjual" value="<?= $Page->akunjual->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->akunjual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->akunjual->formatPattern()) ?>"<?= $Page->akunjual->editAttributes() ?> aria-describedby="x_akunjual_help">
<?= $Page->akunjual->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akunjual->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunpersediaan->Visible) { // akunpersediaan ?>
    <div id="r_akunpersediaan"<?= $Page->akunpersediaan->rowAttributes() ?>>
        <label id="elh_produk_akunpersediaan" for="x_akunpersediaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunpersediaan->caption() ?><?= $Page->akunpersediaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunpersediaan->cellAttributes() ?>>
<span id="el_produk_akunpersediaan">
<input type="<?= $Page->akunpersediaan->getInputTextType() ?>" name="x_akunpersediaan" id="x_akunpersediaan" data-table="produk" data-field="x_akunpersediaan" value="<?= $Page->akunpersediaan->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->akunpersediaan->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->akunpersediaan->formatPattern()) ?>"<?= $Page->akunpersediaan->editAttributes() ?> aria-describedby="x_akunpersediaan_help">
<?= $Page->akunpersediaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akunpersediaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->akunreturjual->Visible) { // akunreturjual ?>
    <div id="r_akunreturjual"<?= $Page->akunreturjual->rowAttributes() ?>>
        <label id="elh_produk_akunreturjual" for="x_akunreturjual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->akunreturjual->caption() ?><?= $Page->akunreturjual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->akunreturjual->cellAttributes() ?>>
<span id="el_produk_akunreturjual">
<input type="<?= $Page->akunreturjual->getInputTextType() ?>" name="x_akunreturjual" id="x_akunreturjual" data-table="produk" data-field="x_akunreturjual" value="<?= $Page->akunreturjual->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->akunreturjual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->akunreturjual->formatPattern()) ?>"<?= $Page->akunreturjual->editAttributes() ?> aria-describedby="x_akunreturjual_help">
<?= $Page->akunreturjual->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->akunreturjual->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hargapokok->Visible) { // hargapokok ?>
    <div id="r_hargapokok"<?= $Page->hargapokok->rowAttributes() ?>>
        <label id="elh_produk_hargapokok" for="x_hargapokok" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hargapokok->caption() ?><?= $Page->hargapokok->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hargapokok->cellAttributes() ?>>
<span id="el_produk_hargapokok">
<input type="<?= $Page->hargapokok->getInputTextType() ?>" name="x_hargapokok" id="x_hargapokok" data-table="produk" data-field="x_hargapokok" value="<?= $Page->hargapokok->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hargapokok->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hargapokok->formatPattern()) ?>"<?= $Page->hargapokok->editAttributes() ?> aria-describedby="x_hargapokok_help">
<?= $Page->hargapokok->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hargapokok->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->p->Visible) { // p ?>
    <div id="r_p"<?= $Page->p->rowAttributes() ?>>
        <label id="elh_produk_p" for="x_p" class="<?= $Page->LeftColumnClass ?>"><?= $Page->p->caption() ?><?= $Page->p->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->p->cellAttributes() ?>>
<span id="el_produk_p">
<input type="<?= $Page->p->getInputTextType() ?>" name="x_p" id="x_p" data-table="produk" data-field="x_p" value="<?= $Page->p->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->p->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->p->formatPattern()) ?>"<?= $Page->p->editAttributes() ?> aria-describedby="x_p_help">
<?= $Page->p->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->p->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->l->Visible) { // l ?>
    <div id="r_l"<?= $Page->l->rowAttributes() ?>>
        <label id="elh_produk_l" for="x_l" class="<?= $Page->LeftColumnClass ?>"><?= $Page->l->caption() ?><?= $Page->l->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->l->cellAttributes() ?>>
<span id="el_produk_l">
<input type="<?= $Page->l->getInputTextType() ?>" name="x_l" id="x_l" data-table="produk" data-field="x_l" value="<?= $Page->l->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->l->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->l->formatPattern()) ?>"<?= $Page->l->editAttributes() ?> aria-describedby="x_l_help">
<?= $Page->l->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->l->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_t->Visible) { // t ?>
    <div id="r__t"<?= $Page->_t->rowAttributes() ?>>
        <label id="elh_produk__t" for="x__t" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_t->caption() ?><?= $Page->_t->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_t->cellAttributes() ?>>
<span id="el_produk__t">
<input type="<?= $Page->_t->getInputTextType() ?>" name="x__t" id="x__t" data-table="produk" data-field="x__t" value="<?= $Page->_t->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_t->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_t->formatPattern()) ?>"<?= $Page->_t->editAttributes() ?> aria-describedby="x__t_help">
<?= $Page->_t->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_t->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->berat->Visible) { // berat ?>
    <div id="r_berat"<?= $Page->berat->rowAttributes() ?>>
        <label id="elh_produk_berat" for="x_berat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->berat->caption() ?><?= $Page->berat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->berat->cellAttributes() ?>>
<span id="el_produk_berat">
<input type="<?= $Page->berat->getInputTextType() ?>" name="x_berat" id="x_berat" data-table="produk" data-field="x_berat" value="<?= $Page->berat->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->berat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->berat->formatPattern()) ?>"<?= $Page->berat->editAttributes() ?> aria-describedby="x_berat_help">
<?= $Page->berat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->berat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { // supplier_id ?>
    <div id="r_supplier_id"<?= $Page->supplier_id->rowAttributes() ?>>
        <label id="elh_produk_supplier_id" for="x_supplier_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->supplier_id->caption() ?><?= $Page->supplier_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->supplier_id->cellAttributes() ?>>
<span id="el_produk_supplier_id">
<input type="<?= $Page->supplier_id->getInputTextType() ?>" name="x_supplier_id" id="x_supplier_id" data-table="produk" data-field="x_supplier_id" value="<?= $Page->supplier_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->supplier_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->supplier_id->formatPattern()) ?>"<?= $Page->supplier_id->editAttributes() ?> aria-describedby="x_supplier_id_help">
<?= $Page->supplier_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->supplier_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->waktukirim->Visible) { // waktukirim ?>
    <div id="r_waktukirim"<?= $Page->waktukirim->rowAttributes() ?>>
        <label id="elh_produk_waktukirim" for="x_waktukirim" class="<?= $Page->LeftColumnClass ?>"><?= $Page->waktukirim->caption() ?><?= $Page->waktukirim->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->waktukirim->cellAttributes() ?>>
<span id="el_produk_waktukirim">
<input type="<?= $Page->waktukirim->getInputTextType() ?>" name="x_waktukirim" id="x_waktukirim" data-table="produk" data-field="x_waktukirim" value="<?= $Page->waktukirim->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->waktukirim->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->waktukirim->formatPattern()) ?>"<?= $Page->waktukirim->editAttributes() ?> aria-describedby="x_waktukirim_help">
<?= $Page->waktukirim->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->waktukirim->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <div id="r_aktif"<?= $Page->aktif->rowAttributes() ?>>
        <label id="elh_produk_aktif" for="x_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aktif->caption() ?><?= $Page->aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->aktif->cellAttributes() ?>>
<span id="el_produk_aktif">
<input type="<?= $Page->aktif->getInputTextType() ?>" name="x_aktif" id="x_aktif" data-table="produk" data-field="x_aktif" value="<?= $Page->aktif->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->aktif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->aktif->formatPattern()) ?>"<?= $Page->aktif->editAttributes() ?> aria-describedby="x_aktif_help">
<?= $Page->aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
    <div id="r_id_FK"<?= $Page->id_FK->rowAttributes() ?>>
        <label id="elh_produk_id_FK" for="x_id_FK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_FK->caption() ?><?= $Page->id_FK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_FK->cellAttributes() ?>>
<span id="el_produk_id_FK">
<input type="<?= $Page->id_FK->getInputTextType() ?>" name="x_id_FK" id="x_id_FK" data-table="produk" data-field="x_id_FK" value="<?= $Page->id_FK->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id_FK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_FK->formatPattern()) ?>"<?= $Page->id_FK->editAttributes() ?> aria-describedby="x_id_FK_help">
<?= $Page->id_FK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_FK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fprodukedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fprodukedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("produk");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
