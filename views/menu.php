<?php

namespace PHPMaker2024\prj_accounting;

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(1, "mi_akun", $Language->menuPhrase("1", "MenuText"), "akunlist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(2, "mi_grup", $Language->menuPhrase("2", "MenuText"), "gruplist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_gudang", $Language->menuPhrase("3", "MenuText"), "gudanglist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(4, "mi_jurnal", $Language->menuPhrase("4", "MenuText"), "jurnallist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(5, "mi_jurnald", $Language->menuPhrase("5", "MenuText"), "jurnaldlist?cmd=resetall", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_kelompok", $Language->menuPhrase("6", "MenuText"), "kelompoklist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_klasifikasi", $Language->menuPhrase("7", "MenuText"), "klasifikasilist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_konversi", $Language->menuPhrase("8", "MenuText"), "konversilist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(9, "mi_kurs", $Language->menuPhrase("9", "MenuText"), "kurslist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(10, "mi_matauang", $Language->menuPhrase("10", "MenuText"), "matauanglist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(11, "mi_pajak", $Language->menuPhrase("11", "MenuText"), "pajaklist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(12, "mi_pengiriman", $Language->menuPhrase("12", "MenuText"), "pengirimanlist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(13, "mi_periode", $Language->menuPhrase("13", "MenuText"), "periodelist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(14, "mi_person", $Language->menuPhrase("14", "MenuText"), "personlist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(15, "mi_produk", $Language->menuPhrase("15", "MenuText"), "produklist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(16, "mi_saldoawal", $Language->menuPhrase("16", "MenuText"), "saldoawallist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(17, "mi_satuan", $Language->menuPhrase("17", "MenuText"), "satuanlist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(18, "mi_subgrup", $Language->menuPhrase("18", "MenuText"), "subgruplist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(19, "mi_tipejurnal", $Language->menuPhrase("19", "MenuText"), "tipejurnallist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(20, "mi_top", $Language->menuPhrase("20", "MenuText"), "toplist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(21, "mi_tos", $Language->menuPhrase("21", "MenuText"), "toslist", -1, "", true, false, false, "", "", false, true);
$sideMenu->addMenuItem(22, "mi_type", $Language->menuPhrase("22", "MenuText"), "typelist", -1, "", true, false, false, "", "", false, true);
echo $sideMenu->toScript();
