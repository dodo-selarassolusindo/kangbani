<?php

namespace PHPMaker2024\prj_accounting;

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(23, "mci_Master", $Language->menuPhrase("23", "MenuText"), "", -1, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(50, "mci_Akuntansi", $Language->menuPhrase("50", "MenuText"), "", 23, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(13, "mi_periode", $Language->menuPhrase("13", "MenuText"), "periodelist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(10, "mi_matauang", $Language->menuPhrase("10", "MenuText"), "matauanglist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(2, "mi_grup", $Language->menuPhrase("2", "MenuText"), "gruplist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(18, "mi_subgrup", $Language->menuPhrase("18", "MenuText"), "subgruplist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(1, "mi_akun", $Language->menuPhrase("1", "MenuText"), "akunlist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(16, "mi_saldoawal", $Language->menuPhrase("16", "MenuText"), "saldoawallist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(19, "mi_tipejurnal", $Language->menuPhrase("19", "MenuText"), "tipejurnallist", 50, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(83, "mci_Barang", $Language->menuPhrase("83", "MenuText"), "", 23, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(6, "mi_kelompok", $Language->menuPhrase("6", "MenuText"), "kelompoklist", 83, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(17, "mi_satuan", $Language->menuPhrase("17", "MenuText"), "satuanlist", 83, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(3, "mi_gudang", $Language->menuPhrase("3", "MenuText"), "gudanglist", 83, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(15, "mi_produk", $Language->menuPhrase("15", "MenuText"), "produklist", 83, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(101, "mci_User", $Language->menuPhrase("101", "MenuText"), "", 23, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(22, "mi_type", $Language->menuPhrase("22", "MenuText"), "typelist", 101, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(14, "mi_person", $Language->menuPhrase("14", "MenuText"), "personlist", 101, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(7, "mi_klasifikasi", $Language->menuPhrase("7", "MenuText"), "klasifikasilist", 23, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(12, "mi_pengiriman", $Language->menuPhrase("12", "MenuText"), "pengirimanlist", 23, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(74, "mci_Setting", $Language->menuPhrase("74", "MenuText"), "", -1, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(21, "mi_tos", $Language->menuPhrase("21", "MenuText"), "toslist", 74, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(20, "mi_top", $Language->menuPhrase("20", "MenuText"), "toplist", 74, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(8, "mi_konversi", $Language->menuPhrase("8", "MenuText"), "konversilist", 74, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(9, "mi_kurs", $Language->menuPhrase("9", "MenuText"), "kurslist", 74, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(11, "mi_pajak", $Language->menuPhrase("11", "MenuText"), "pajaklist", 74, "", true, false, false, "", "", true, false);
$topMenu->addMenuItem(24, "mci_Transaksi", $Language->menuPhrase("24", "MenuText"), "", -1, "", true, false, true, "", "", true, false);
$topMenu->addMenuItem(4, "mi_jurnal", $Language->menuPhrase("4", "MenuText"), "jurnallist", 24, "", true, false, false, "", "", true, false);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(23, "mci_Master", $Language->menuPhrase("23", "MenuText"), "", -1, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(50, "mci_Akuntansi", $Language->menuPhrase("50", "MenuText"), "", 23, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(13, "mi_periode", $Language->menuPhrase("13", "MenuText"), "periodelist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(10, "mi_matauang", $Language->menuPhrase("10", "MenuText"), "matauanglist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(2, "mi_grup", $Language->menuPhrase("2", "MenuText"), "gruplist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(18, "mi_subgrup", $Language->menuPhrase("18", "MenuText"), "subgruplist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(1, "mi_akun", $Language->menuPhrase("1", "MenuText"), "akunlist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(16, "mi_saldoawal", $Language->menuPhrase("16", "MenuText"), "saldoawallist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(19, "mi_tipejurnal", $Language->menuPhrase("19", "MenuText"), "tipejurnallist", 50, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(83, "mci_Barang", $Language->menuPhrase("83", "MenuText"), "", 23, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(6, "mi_kelompok", $Language->menuPhrase("6", "MenuText"), "kelompoklist", 83, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(17, "mi_satuan", $Language->menuPhrase("17", "MenuText"), "satuanlist", 83, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(3, "mi_gudang", $Language->menuPhrase("3", "MenuText"), "gudanglist", 83, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(15, "mi_produk", $Language->menuPhrase("15", "MenuText"), "produklist", 83, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(101, "mci_User", $Language->menuPhrase("101", "MenuText"), "", 23, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(22, "mi_type", $Language->menuPhrase("22", "MenuText"), "typelist", 101, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(14, "mi_person", $Language->menuPhrase("14", "MenuText"), "personlist", 101, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(7, "mi_klasifikasi", $Language->menuPhrase("7", "MenuText"), "klasifikasilist", 23, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(12, "mi_pengiriman", $Language->menuPhrase("12", "MenuText"), "pengirimanlist", 23, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(74, "mci_Setting", $Language->menuPhrase("74", "MenuText"), "", -1, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(21, "mi_tos", $Language->menuPhrase("21", "MenuText"), "toslist", 74, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(20, "mi_top", $Language->menuPhrase("20", "MenuText"), "toplist", 74, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(8, "mi_konversi", $Language->menuPhrase("8", "MenuText"), "konversilist", 74, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(9, "mi_kurs", $Language->menuPhrase("9", "MenuText"), "kurslist", 74, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(11, "mi_pajak", $Language->menuPhrase("11", "MenuText"), "pajaklist", 74, "", true, false, false, "", "", true, true);
$sideMenu->addMenuItem(24, "mci_Transaksi", $Language->menuPhrase("24", "MenuText"), "", -1, "", true, false, true, "", "", true, true);
$sideMenu->addMenuItem(4, "mi_jurnal", $Language->menuPhrase("4", "MenuText"), "jurnallist", 24, "", true, false, false, "", "", true, true);
echo $sideMenu->toScript();
