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
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}audittrail","-2","0"],
    ["{6E044EB4-6227-43E6-89F6-E9F0A73B0333}beranda.php","-2","72"],
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
$USER_LEVEL_TABLES = [["akun","akun","Akun",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","akunlist"],
    ["audittrail","audittrail","Activity Log",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","audittraillist"],
    ["beranda.php","beranda","Beranda",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","beranda"],
    ["grup","grup","Grup",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","gruplist"],
    ["gudang","gudang","Gudang",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","gudanglist"],
    ["jurnal","jurnal","Jurnal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","jurnallist"],
    ["jurnald","jurnald","Detail",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","jurnaldlist"],
    ["kelompok","kelompok","Kelompok",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","kelompoklist"],
    ["klasifikasi","klasifikasi","Klasifikasi",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","klasifikasilist"],
    ["konversi","konversi","Konversi",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","konversilist"],
    ["kurs","kurs","Kurs",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","kurslist"],
    ["matauang","matauang","Mata Uang",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","matauanglist"],
    ["pajak","pajak","Pajak",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","pajaklist"],
    ["pengiriman","pengiriman","Pengiriman",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","pengirimanlist"],
    ["periode","periode","Periode",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","periodelist"],
    ["person","person","Person",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","personlist"],
    ["produk","produk","Produk",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","produklist"],
    ["saldoawal","saldoawal","Saldo Awal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","saldoawallist"],
    ["satuan","satuan","Satuan",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","satuanlist"],
    ["subgrup","subgrup","Sub Grup",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","subgruplist"],
    ["tipejurnal","tipejurnal","Tipe Jurnal",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","tipejurnallist"],
    ["top","top","Term of Payment",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","toplist"],
    ["tos","tos","Term of Sale",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","toslist"],
    ["type","type","Type",true,"{6E044EB4-6227-43E6-89F6-E9F0A73B0333}","typelist"]];
