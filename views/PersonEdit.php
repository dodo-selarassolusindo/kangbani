<?php

namespace PHPMaker2024\prj_accounting;

// Page object
$PersonEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fpersonedit" id="fpersonedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { person: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fpersonedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fpersonedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
            ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
            ["kontak", [fields.kontak.visible && fields.kontak.required ? ew.Validators.required(fields.kontak.caption) : null], fields.kontak.isInvalid],
            ["type_id", [fields.type_id.visible && fields.type_id.required ? ew.Validators.required(fields.type_id.caption) : null, ew.Validators.integer], fields.type_id.isInvalid],
            ["telp1", [fields.telp1.visible && fields.telp1.required ? ew.Validators.required(fields.telp1.caption) : null], fields.telp1.isInvalid],
            ["matauang_id", [fields.matauang_id.visible && fields.matauang_id.required ? ew.Validators.required(fields.matauang_id.caption) : null, ew.Validators.integer], fields.matauang_id.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
            ["telp2", [fields.telp2.visible && fields.telp2.required ? ew.Validators.required(fields.telp2.caption) : null], fields.telp2.isInvalid],
            ["fax", [fields.fax.visible && fields.fax.required ? ew.Validators.required(fields.fax.caption) : null], fields.fax.isInvalid],
            ["hp", [fields.hp.visible && fields.hp.required ? ew.Validators.required(fields.hp.caption) : null], fields.hp.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["website", [fields.website.visible && fields.website.required ? ew.Validators.required(fields.website.caption) : null], fields.website.isInvalid],
            ["npwp", [fields.npwp.visible && fields.npwp.required ? ew.Validators.required(fields.npwp.caption) : null], fields.npwp.isInvalid],
            ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
            ["kota", [fields.kota.visible && fields.kota.required ? ew.Validators.required(fields.kota.caption) : null], fields.kota.isInvalid],
            ["zip", [fields.zip.visible && fields.zip.required ? ew.Validators.required(fields.zip.caption) : null], fields.zip.isInvalid],
            ["klasifikasi_id", [fields.klasifikasi_id.visible && fields.klasifikasi_id.required ? ew.Validators.required(fields.klasifikasi_id.caption) : null, ew.Validators.integer], fields.klasifikasi_id.isInvalid],
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
<input type="hidden" name="t" value="person">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_person_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_person_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="person" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode"<?= $Page->kode->rowAttributes() ?>>
        <label id="elh_person_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kode->cellAttributes() ?>>
<span id="el_person_kode">
<input type="<?= $Page->kode->getInputTextType() ?>" name="x_kode" id="x_kode" data-table="person" data-field="x_kode" value="<?= $Page->kode->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kode->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kode->formatPattern()) ?>"<?= $Page->kode->editAttributes() ?> aria-describedby="x_kode_help">
<?= $Page->kode->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_person_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_person_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="person" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nama->formatPattern()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kontak->Visible) { // kontak ?>
    <div id="r_kontak"<?= $Page->kontak->rowAttributes() ?>>
        <label id="elh_person_kontak" for="x_kontak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kontak->caption() ?><?= $Page->kontak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kontak->cellAttributes() ?>>
<span id="el_person_kontak">
<input type="<?= $Page->kontak->getInputTextType() ?>" name="x_kontak" id="x_kontak" data-table="person" data-field="x_kontak" value="<?= $Page->kontak->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kontak->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kontak->formatPattern()) ?>"<?= $Page->kontak->editAttributes() ?> aria-describedby="x_kontak_help">
<?= $Page->kontak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kontak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->type_id->Visible) { // type_id ?>
    <div id="r_type_id"<?= $Page->type_id->rowAttributes() ?>>
        <label id="elh_person_type_id" for="x_type_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->type_id->caption() ?><?= $Page->type_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type_id->cellAttributes() ?>>
<span id="el_person_type_id">
<input type="<?= $Page->type_id->getInputTextType() ?>" name="x_type_id" id="x_type_id" data-table="person" data-field="x_type_id" value="<?= $Page->type_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->type_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->type_id->formatPattern()) ?>"<?= $Page->type_id->editAttributes() ?> aria-describedby="x_type_id_help">
<?= $Page->type_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->type_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telp1->Visible) { // telp1 ?>
    <div id="r_telp1"<?= $Page->telp1->rowAttributes() ?>>
        <label id="elh_person_telp1" for="x_telp1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telp1->caption() ?><?= $Page->telp1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telp1->cellAttributes() ?>>
<span id="el_person_telp1">
<input type="<?= $Page->telp1->getInputTextType() ?>" name="x_telp1" id="x_telp1" data-table="person" data-field="x_telp1" value="<?= $Page->telp1->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telp1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telp1->formatPattern()) ?>"<?= $Page->telp1->editAttributes() ?> aria-describedby="x_telp1_help">
<?= $Page->telp1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telp1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->matauang_id->Visible) { // matauang_id ?>
    <div id="r_matauang_id"<?= $Page->matauang_id->rowAttributes() ?>>
        <label id="elh_person_matauang_id" for="x_matauang_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->matauang_id->caption() ?><?= $Page->matauang_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->matauang_id->cellAttributes() ?>>
<span id="el_person_matauang_id">
<input type="<?= $Page->matauang_id->getInputTextType() ?>" name="x_matauang_id" id="x_matauang_id" data-table="person" data-field="x_matauang_id" value="<?= $Page->matauang_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->matauang_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->matauang_id->formatPattern()) ?>"<?= $Page->matauang_id->editAttributes() ?> aria-describedby="x_matauang_id_help">
<?= $Page->matauang_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->matauang_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_person__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<span id="el_person__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="person" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_username->formatPattern()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_person__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_person__password">
<input type="<?= $Page->_password->getInputTextType() ?>" name="x__password" id="x__password" data-table="person" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_password->formatPattern()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telp2->Visible) { // telp2 ?>
    <div id="r_telp2"<?= $Page->telp2->rowAttributes() ?>>
        <label id="elh_person_telp2" for="x_telp2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telp2->caption() ?><?= $Page->telp2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telp2->cellAttributes() ?>>
<span id="el_person_telp2">
<input type="<?= $Page->telp2->getInputTextType() ?>" name="x_telp2" id="x_telp2" data-table="person" data-field="x_telp2" value="<?= $Page->telp2->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telp2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telp2->formatPattern()) ?>"<?= $Page->telp2->editAttributes() ?> aria-describedby="x_telp2_help">
<?= $Page->telp2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telp2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
    <div id="r_fax"<?= $Page->fax->rowAttributes() ?>>
        <label id="elh_person_fax" for="x_fax" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fax->caption() ?><?= $Page->fax->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fax->cellAttributes() ?>>
<span id="el_person_fax">
<input type="<?= $Page->fax->getInputTextType() ?>" name="x_fax" id="x_fax" data-table="person" data-field="x_fax" value="<?= $Page->fax->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->fax->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fax->formatPattern()) ?>"<?= $Page->fax->editAttributes() ?> aria-describedby="x_fax_help">
<?= $Page->fax->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fax->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <div id="r_hp"<?= $Page->hp->rowAttributes() ?>>
        <label id="elh_person_hp" for="x_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hp->caption() ?><?= $Page->hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hp->cellAttributes() ?>>
<span id="el_person_hp">
<input type="<?= $Page->hp->getInputTextType() ?>" name="x_hp" id="x_hp" data-table="person" data-field="x_hp" value="<?= $Page->hp->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->hp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hp->formatPattern()) ?>"<?= $Page->hp->editAttributes() ?> aria-describedby="x_hp_help">
<?= $Page->hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_person__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_person__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="person" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <div id="r_website"<?= $Page->website->rowAttributes() ?>>
        <label id="elh_person_website" for="x_website" class="<?= $Page->LeftColumnClass ?>"><?= $Page->website->caption() ?><?= $Page->website->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->website->cellAttributes() ?>>
<span id="el_person_website">
<input type="<?= $Page->website->getInputTextType() ?>" name="x_website" id="x_website" data-table="person" data-field="x_website" value="<?= $Page->website->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->website->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->website->formatPattern()) ?>"<?= $Page->website->editAttributes() ?> aria-describedby="x_website_help">
<?= $Page->website->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->website->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <div id="r_npwp"<?= $Page->npwp->rowAttributes() ?>>
        <label id="elh_person_npwp" for="x_npwp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->npwp->caption() ?><?= $Page->npwp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->npwp->cellAttributes() ?>>
<span id="el_person_npwp">
<input type="<?= $Page->npwp->getInputTextType() ?>" name="x_npwp" id="x_npwp" data-table="person" data-field="x_npwp" value="<?= $Page->npwp->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->npwp->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->npwp->formatPattern()) ?>"<?= $Page->npwp->editAttributes() ?> aria-describedby="x_npwp_help">
<?= $Page->npwp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->npwp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat"<?= $Page->alamat->rowAttributes() ?>>
        <label id="elh_person_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->alamat->cellAttributes() ?>>
<span id="el_person_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" name="x_alamat" id="x_alamat" data-table="person" data-field="x_alamat" value="<?= $Page->alamat->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->alamat->formatPattern()) ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kota->Visible) { // kota ?>
    <div id="r_kota"<?= $Page->kota->rowAttributes() ?>>
        <label id="elh_person_kota" for="x_kota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kota->caption() ?><?= $Page->kota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kota->cellAttributes() ?>>
<span id="el_person_kota">
<input type="<?= $Page->kota->getInputTextType() ?>" name="x_kota" id="x_kota" data-table="person" data-field="x_kota" value="<?= $Page->kota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->kota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kota->formatPattern()) ?>"<?= $Page->kota->editAttributes() ?> aria-describedby="x_kota_help">
<?= $Page->kota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->zip->Visible) { // zip ?>
    <div id="r_zip"<?= $Page->zip->rowAttributes() ?>>
        <label id="elh_person_zip" for="x_zip" class="<?= $Page->LeftColumnClass ?>"><?= $Page->zip->caption() ?><?= $Page->zip->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->zip->cellAttributes() ?>>
<span id="el_person_zip">
<input type="<?= $Page->zip->getInputTextType() ?>" name="x_zip" id="x_zip" data-table="person" data-field="x_zip" value="<?= $Page->zip->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->zip->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->zip->formatPattern()) ?>"<?= $Page->zip->editAttributes() ?> aria-describedby="x_zip_help">
<?= $Page->zip->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->zip->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->klasifikasi_id->Visible) { // klasifikasi_id ?>
    <div id="r_klasifikasi_id"<?= $Page->klasifikasi_id->rowAttributes() ?>>
        <label id="elh_person_klasifikasi_id" for="x_klasifikasi_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->klasifikasi_id->caption() ?><?= $Page->klasifikasi_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->klasifikasi_id->cellAttributes() ?>>
<span id="el_person_klasifikasi_id">
<input type="<?= $Page->klasifikasi_id->getInputTextType() ?>" name="x_klasifikasi_id" id="x_klasifikasi_id" data-table="person" data-field="x_klasifikasi_id" value="<?= $Page->klasifikasi_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->klasifikasi_id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->klasifikasi_id->formatPattern()) ?>"<?= $Page->klasifikasi_id->editAttributes() ?> aria-describedby="x_klasifikasi_id_help">
<?= $Page->klasifikasi_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->klasifikasi_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_FK->Visible) { // id_FK ?>
    <div id="r_id_FK"<?= $Page->id_FK->rowAttributes() ?>>
        <label id="elh_person_id_FK" for="x_id_FK" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_FK->caption() ?><?= $Page->id_FK->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_FK->cellAttributes() ?>>
<span id="el_person_id_FK">
<input type="<?= $Page->id_FK->getInputTextType() ?>" name="x_id_FK" id="x_id_FK" data-table="person" data-field="x_id_FK" value="<?= $Page->id_FK->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id_FK->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_FK->formatPattern()) ?>"<?= $Page->id_FK->editAttributes() ?> aria-describedby="x_id_FK_help">
<?= $Page->id_FK->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_FK->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fpersonedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fpersonedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("person");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
