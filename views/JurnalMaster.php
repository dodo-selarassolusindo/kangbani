<?php

namespace PHPMaker2024\prj_accounting;

// Table
$jurnal = Container("jurnal");
$jurnal->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($jurnal->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_jurnalmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($jurnal->id->Visible) { // id ?>
        <tr id="r_id"<?= $jurnal->id->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->id->caption() ?></td>
            <td<?= $jurnal->id->cellAttributes() ?>>
<span id="el_jurnal_id">
<span<?= $jurnal->id->viewAttributes() ?>>
<?= $jurnal->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->tipejurnal_id->Visible) { // tipejurnal_id ?>
        <tr id="r_tipejurnal_id"<?= $jurnal->tipejurnal_id->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->tipejurnal_id->caption() ?></td>
            <td<?= $jurnal->tipejurnal_id->cellAttributes() ?>>
<span id="el_jurnal_tipejurnal_id">
<span<?= $jurnal->tipejurnal_id->viewAttributes() ?>>
<?= $jurnal->tipejurnal_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->period_id->Visible) { // period_id ?>
        <tr id="r_period_id"<?= $jurnal->period_id->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->period_id->caption() ?></td>
            <td<?= $jurnal->period_id->cellAttributes() ?>>
<span id="el_jurnal_period_id">
<span<?= $jurnal->period_id->viewAttributes() ?>>
<?= $jurnal->period_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->createon->Visible) { // createon ?>
        <tr id="r_createon"<?= $jurnal->createon->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->createon->caption() ?></td>
            <td<?= $jurnal->createon->cellAttributes() ?>>
<span id="el_jurnal_createon">
<span<?= $jurnal->createon->viewAttributes() ?>>
<?= $jurnal->createon->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->keterangan->Visible) { // keterangan ?>
        <tr id="r_keterangan"<?= $jurnal->keterangan->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->keterangan->caption() ?></td>
            <td<?= $jurnal->keterangan->cellAttributes() ?>>
<span id="el_jurnal_keterangan">
<span<?= $jurnal->keterangan->viewAttributes() ?>>
<?= $jurnal->keterangan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->person_id->Visible) { // person_id ?>
        <tr id="r_person_id"<?= $jurnal->person_id->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->person_id->caption() ?></td>
            <td<?= $jurnal->person_id->cellAttributes() ?>>
<span id="el_jurnal_person_id">
<span<?= $jurnal->person_id->viewAttributes() ?>>
<?= $jurnal->person_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($jurnal->nomer->Visible) { // nomer ?>
        <tr id="r_nomer"<?= $jurnal->nomer->rowAttributes() ?>>
            <td class="<?= $jurnal->TableLeftColumnClass ?>"><?= $jurnal->nomer->caption() ?></td>
            <td<?= $jurnal->nomer->cellAttributes() ?>>
<span id="el_jurnal_nomer">
<span<?= $jurnal->nomer->viewAttributes() ?>>
<?= $jurnal->nomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
