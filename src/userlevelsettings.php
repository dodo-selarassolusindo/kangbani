<?php
/**
 * PHPMaker 2024 User Level Settings
 */
namespace PHPMaker2024\prj_accounting;

/**
 * User levels
 *
 * @var array<int, string>
 * [0] int User level ID
 * [1] string User level name
 */
$USER_LEVELS = [["-2","Anonymous"]];

/**
 * User level permissions
 *
 * @var array<string, int, int>
 * [0] string Project ID + Table name
 * [1] int User level ID
 * [2] int Permissions
 */
$USER_LEVEL_PRIVS = [["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}akun","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}grup","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}gudang","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}jurnal","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}jurnald","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}kelompok","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}klasifikasi","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}konversi","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}kurs","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}matauang","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}pajak","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}pengiriman","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}periode","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}person","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}produk","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}saldoawal","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}satuan","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}subgrup","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}tipejurnal","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}top","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}tos","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}type","-2","0"]];

/**
 * Tables
 *
 * @var array<string, string, string, bool, string>
 * [0] string Table name
 * [1] string Table variable name
 * [2] string Table caption
 * [3] bool Allowed for update (for userpriv.php)
 * [4] string Project ID
 * [5] string URL (for OthersController::index)
 */
$USER_LEVEL_TABLES = [["akun","akun","akun",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","akunlist"],
    ["grup","grup","grup",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","gruplist"],
    ["gudang","gudang","gudang",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","gudanglist"],
    ["jurnal","jurnal","jurnal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","jurnallist"],
    ["jurnald","jurnald","jurnald",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","jurnaldlist"],
    ["kelompok","kelompok","kelompok",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","kelompoklist"],
    ["klasifikasi","klasifikasi","klasifikasi",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","klasifikasilist"],
    ["konversi","konversi","konversi",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","konversilist"],
    ["kurs","kurs","kurs",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","kurslist"],
    ["matauang","matauang","matauang",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","matauanglist"],
    ["pajak","pajak","pajak",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","pajaklist"],
    ["pengiriman","pengiriman","pengiriman",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","pengirimanlist"],
    ["periode","periode","periode",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","periodelist"],
    ["person","person","person",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","personlist"],
    ["produk","produk","produk",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","produklist"],
    ["saldoawal","saldoawal","saldoawal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","saldoawallist"],
    ["satuan","satuan","satuan",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","satuanlist"],
    ["subgrup","subgrup","subgrup",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","subgruplist"],
    ["tipejurnal","tipejurnal","tipejurnal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","tipejurnallist"],
    ["top","top","top",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","toplist"],
    ["tos","tos","tos",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","toslist"],
    ["type","type","type",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","typelist"]];
