<?php

namespace PHPMaker2024\prj_accounting;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Table class for produk
 */
class Produk extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $id;
    public $kode;
    public $nama;
    public $kelompok_id;
    public $satuan_id;
    public $satuan_id2;
    public $gudang_id;
    public $minstok;
    public $minorder;
    public $akunhpp;
    public $akunjual;
    public $akunpersediaan;
    public $akunreturjual;
    public $hargapokok;
    public $p;
    public $l;
    public $_t;
    public $berat;
    public $supplier_id;
    public $waktukirim;
    public $aktif;
    public $id_FK;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "produk";
        $this->TableName = 'produk';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "produk";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // id
        $this->id = new DbField(
            $this, // Table
            'x_id', // Variable name
            'id', // Name
            '`id`', // Expression
            '`id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->id->InputTextType = "text";
        $this->id->Raw = true;
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['id'] = &$this->id;

        // kode
        $this->kode = new DbField(
            $this, // Table
            'x_kode', // Variable name
            'kode', // Name
            '`kode`', // Expression
            '`kode`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`kode`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->kode->InputTextType = "text";
        $this->kode->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['kode'] = &$this->kode;

        // nama
        $this->nama = new DbField(
            $this, // Table
            'x_nama', // Variable name
            'nama', // Name
            '`nama`', // Expression
            '`nama`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nama`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nama->InputTextType = "text";
        $this->nama->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nama'] = &$this->nama;

        // kelompok_id
        $this->kelompok_id = new DbField(
            $this, // Table
            'x_kelompok_id', // Variable name
            'kelompok_id', // Name
            '`kelompok_id`', // Expression
            '`kelompok_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`kelompok_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->kelompok_id->InputTextType = "text";
        $this->kelompok_id->Raw = true;
        $this->kelompok_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kelompok_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['kelompok_id'] = &$this->kelompok_id;

        // satuan_id
        $this->satuan_id = new DbField(
            $this, // Table
            'x_satuan_id', // Variable name
            'satuan_id', // Name
            '`satuan_id`', // Expression
            '`satuan_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`satuan_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->satuan_id->InputTextType = "text";
        $this->satuan_id->Raw = true;
        $this->satuan_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->satuan_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['satuan_id'] = &$this->satuan_id;

        // satuan_id2
        $this->satuan_id2 = new DbField(
            $this, // Table
            'x_satuan_id2', // Variable name
            'satuan_id2', // Name
            '`satuan_id2`', // Expression
            '`satuan_id2`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`satuan_id2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->satuan_id2->InputTextType = "text";
        $this->satuan_id2->Raw = true;
        $this->satuan_id2->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->satuan_id2->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['satuan_id2'] = &$this->satuan_id2;

        // gudang_id
        $this->gudang_id = new DbField(
            $this, // Table
            'x_gudang_id', // Variable name
            'gudang_id', // Name
            '`gudang_id`', // Expression
            '`gudang_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`gudang_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->gudang_id->InputTextType = "text";
        $this->gudang_id->Raw = true;
        $this->gudang_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->gudang_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['gudang_id'] = &$this->gudang_id;

        // minstok
        $this->minstok = new DbField(
            $this, // Table
            'x_minstok', // Variable name
            'minstok', // Name
            '`minstok`', // Expression
            '`minstok`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`minstok`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->minstok->InputTextType = "text";
        $this->minstok->Raw = true;
        $this->minstok->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->minstok->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['minstok'] = &$this->minstok;

        // minorder
        $this->minorder = new DbField(
            $this, // Table
            'x_minorder', // Variable name
            'minorder', // Name
            '`minorder`', // Expression
            '`minorder`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`minorder`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->minorder->InputTextType = "text";
        $this->minorder->Raw = true;
        $this->minorder->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->minorder->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['minorder'] = &$this->minorder;

        // akunhpp
        $this->akunhpp = new DbField(
            $this, // Table
            'x_akunhpp', // Variable name
            'akunhpp', // Name
            '`akunhpp`', // Expression
            '`akunhpp`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`akunhpp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->akunhpp->InputTextType = "text";
        $this->akunhpp->Raw = true;
        $this->akunhpp->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->akunhpp->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['akunhpp'] = &$this->akunhpp;

        // akunjual
        $this->akunjual = new DbField(
            $this, // Table
            'x_akunjual', // Variable name
            'akunjual', // Name
            '`akunjual`', // Expression
            '`akunjual`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`akunjual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->akunjual->InputTextType = "text";
        $this->akunjual->Raw = true;
        $this->akunjual->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->akunjual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['akunjual'] = &$this->akunjual;

        // akunpersediaan
        $this->akunpersediaan = new DbField(
            $this, // Table
            'x_akunpersediaan', // Variable name
            'akunpersediaan', // Name
            '`akunpersediaan`', // Expression
            '`akunpersediaan`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`akunpersediaan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->akunpersediaan->InputTextType = "text";
        $this->akunpersediaan->Raw = true;
        $this->akunpersediaan->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->akunpersediaan->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['akunpersediaan'] = &$this->akunpersediaan;

        // akunreturjual
        $this->akunreturjual = new DbField(
            $this, // Table
            'x_akunreturjual', // Variable name
            'akunreturjual', // Name
            '`akunreturjual`', // Expression
            '`akunreturjual`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`akunreturjual`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->akunreturjual->InputTextType = "text";
        $this->akunreturjual->Raw = true;
        $this->akunreturjual->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->akunreturjual->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['akunreturjual'] = &$this->akunreturjual;

        // hargapokok
        $this->hargapokok = new DbField(
            $this, // Table
            'x_hargapokok', // Variable name
            'hargapokok', // Name
            '`hargapokok`', // Expression
            '`hargapokok`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hargapokok`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hargapokok->InputTextType = "text";
        $this->hargapokok->Raw = true;
        $this->hargapokok->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->hargapokok->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hargapokok'] = &$this->hargapokok;

        // p
        $this->p = new DbField(
            $this, // Table
            'x_p', // Variable name
            'p', // Name
            '`p`', // Expression
            '`p`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`p`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->p->InputTextType = "text";
        $this->p->Raw = true;
        $this->p->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->p->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['p'] = &$this->p;

        // l
        $this->l = new DbField(
            $this, // Table
            'x_l', // Variable name
            'l', // Name
            '`l`', // Expression
            '`l`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`l`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->l->InputTextType = "text";
        $this->l->Raw = true;
        $this->l->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->l->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['l'] = &$this->l;

        // t
        $this->_t = new DbField(
            $this, // Table
            'x__t', // Variable name
            't', // Name
            '`t`', // Expression
            '`t`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`t`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_t->InputTextType = "text";
        $this->_t->Raw = true;
        $this->_t->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->_t->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['t'] = &$this->_t;

        // berat
        $this->berat = new DbField(
            $this, // Table
            'x_berat', // Variable name
            'berat', // Name
            '`berat`', // Expression
            '`berat`', // Basic search expression
            5, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`berat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->berat->InputTextType = "text";
        $this->berat->Raw = true;
        $this->berat->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->berat->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['berat'] = &$this->berat;

        // supplier_id
        $this->supplier_id = new DbField(
            $this, // Table
            'x_supplier_id', // Variable name
            'supplier_id', // Name
            '`supplier_id`', // Expression
            '`supplier_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`supplier_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->supplier_id->InputTextType = "text";
        $this->supplier_id->Raw = true;
        $this->supplier_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->supplier_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['supplier_id'] = &$this->supplier_id;

        // waktukirim
        $this->waktukirim = new DbField(
            $this, // Table
            'x_waktukirim', // Variable name
            'waktukirim', // Name
            '`waktukirim`', // Expression
            '`waktukirim`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`waktukirim`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->waktukirim->InputTextType = "text";
        $this->waktukirim->Raw = true;
        $this->waktukirim->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->waktukirim->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['waktukirim'] = &$this->waktukirim;

        // aktif
        $this->aktif = new DbField(
            $this, // Table
            'x_aktif', // Variable name
            'aktif', // Name
            '`aktif`', // Expression
            '`aktif`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`aktif`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->aktif->InputTextType = "text";
        $this->aktif->Raw = true;
        $this->aktif->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->aktif->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['aktif'] = &$this->aktif;

        // id_FK
        $this->id_FK = new DbField(
            $this, // Table
            'x_id_FK', // Variable name
            'id_FK', // Name
            '`id_FK`', // Expression
            '`id_FK`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id_FK`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->id_FK->addMethod("getDefault", fn() => 0);
        $this->id_FK->InputTextType = "text";
        $this->id_FK->Raw = true;
        $this->id_FK->Nullable = false; // NOT NULL field
        $this->id_FK->Required = true; // Required field
        $this->id_FK->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_FK->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['id_FK'] = &$this->id_FK;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "produk";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['id']) && !EmptyValue($this->id->CurrentValue)) {
                $rs['id'] = $this->id->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->kode->DbValue = $row['kode'];
        $this->nama->DbValue = $row['nama'];
        $this->kelompok_id->DbValue = $row['kelompok_id'];
        $this->satuan_id->DbValue = $row['satuan_id'];
        $this->satuan_id2->DbValue = $row['satuan_id2'];
        $this->gudang_id->DbValue = $row['gudang_id'];
        $this->minstok->DbValue = $row['minstok'];
        $this->minorder->DbValue = $row['minorder'];
        $this->akunhpp->DbValue = $row['akunhpp'];
        $this->akunjual->DbValue = $row['akunjual'];
        $this->akunpersediaan->DbValue = $row['akunpersediaan'];
        $this->akunreturjual->DbValue = $row['akunreturjual'];
        $this->hargapokok->DbValue = $row['hargapokok'];
        $this->p->DbValue = $row['p'];
        $this->l->DbValue = $row['l'];
        $this->_t->DbValue = $row['t'];
        $this->berat->DbValue = $row['berat'];
        $this->supplier_id->DbValue = $row['supplier_id'];
        $this->waktukirim->DbValue = $row['waktukirim'];
        $this->aktif->DbValue = $row['aktif'];
        $this->id_FK->DbValue = $row['id_FK'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = !EmptyValue($this->id->OldValue) && !$current ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("produklist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "produkview" => $Language->phrase("View"),
            "produkedit" => $Language->phrase("Edit"),
            "produkadd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "produklist";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ProdukView",
            Config("API_ADD_ACTION") => "ProdukAdd",
            Config("API_EDIT_ACTION") => "ProdukEdit",
            Config("API_DELETE_ACTION") => "ProdukDelete",
            Config("API_LIST_ACTION") => "ProdukList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "produklist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("produkview", $parm);
        } else {
            $url = $this->keyUrl("produkview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "produkadd?" . $parm;
        } else {
            $url = "produkadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("produkedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("produklist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("produkadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("produklist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("produkdelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . VarToJson($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        $keyFilter = "";
        foreach ($rows as $row) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            $keyFilter .= "(" . $this->getRecordFilter($row) . ")";
        }
        return $keyFilter;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->kode->setDbValue($row['kode']);
        $this->nama->setDbValue($row['nama']);
        $this->kelompok_id->setDbValue($row['kelompok_id']);
        $this->satuan_id->setDbValue($row['satuan_id']);
        $this->satuan_id2->setDbValue($row['satuan_id2']);
        $this->gudang_id->setDbValue($row['gudang_id']);
        $this->minstok->setDbValue($row['minstok']);
        $this->minorder->setDbValue($row['minorder']);
        $this->akunhpp->setDbValue($row['akunhpp']);
        $this->akunjual->setDbValue($row['akunjual']);
        $this->akunpersediaan->setDbValue($row['akunpersediaan']);
        $this->akunreturjual->setDbValue($row['akunreturjual']);
        $this->hargapokok->setDbValue($row['hargapokok']);
        $this->p->setDbValue($row['p']);
        $this->l->setDbValue($row['l']);
        $this->_t->setDbValue($row['t']);
        $this->berat->setDbValue($row['berat']);
        $this->supplier_id->setDbValue($row['supplier_id']);
        $this->waktukirim->setDbValue($row['waktukirim']);
        $this->aktif->setDbValue($row['aktif']);
        $this->id_FK->setDbValue($row['id_FK']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ProdukList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // kode

        // nama

        // kelompok_id

        // satuan_id

        // satuan_id2

        // gudang_id

        // minstok

        // minorder

        // akunhpp

        // akunjual

        // akunpersediaan

        // akunreturjual

        // hargapokok

        // p

        // l

        // t

        // berat

        // supplier_id

        // waktukirim

        // aktif

        // id_FK

        // id
        $this->id->ViewValue = $this->id->CurrentValue;

        // kode
        $this->kode->ViewValue = $this->kode->CurrentValue;

        // nama
        $this->nama->ViewValue = $this->nama->CurrentValue;

        // kelompok_id
        $this->kelompok_id->ViewValue = $this->kelompok_id->CurrentValue;
        $this->kelompok_id->ViewValue = FormatNumber($this->kelompok_id->ViewValue, $this->kelompok_id->formatPattern());

        // satuan_id
        $this->satuan_id->ViewValue = $this->satuan_id->CurrentValue;
        $this->satuan_id->ViewValue = FormatNumber($this->satuan_id->ViewValue, $this->satuan_id->formatPattern());

        // satuan_id2
        $this->satuan_id2->ViewValue = $this->satuan_id2->CurrentValue;
        $this->satuan_id2->ViewValue = FormatNumber($this->satuan_id2->ViewValue, $this->satuan_id2->formatPattern());

        // gudang_id
        $this->gudang_id->ViewValue = $this->gudang_id->CurrentValue;
        $this->gudang_id->ViewValue = FormatNumber($this->gudang_id->ViewValue, $this->gudang_id->formatPattern());

        // minstok
        $this->minstok->ViewValue = $this->minstok->CurrentValue;
        $this->minstok->ViewValue = FormatNumber($this->minstok->ViewValue, $this->minstok->formatPattern());

        // minorder
        $this->minorder->ViewValue = $this->minorder->CurrentValue;
        $this->minorder->ViewValue = FormatNumber($this->minorder->ViewValue, $this->minorder->formatPattern());

        // akunhpp
        $this->akunhpp->ViewValue = $this->akunhpp->CurrentValue;
        $this->akunhpp->ViewValue = FormatNumber($this->akunhpp->ViewValue, $this->akunhpp->formatPattern());

        // akunjual
        $this->akunjual->ViewValue = $this->akunjual->CurrentValue;
        $this->akunjual->ViewValue = FormatNumber($this->akunjual->ViewValue, $this->akunjual->formatPattern());

        // akunpersediaan
        $this->akunpersediaan->ViewValue = $this->akunpersediaan->CurrentValue;
        $this->akunpersediaan->ViewValue = FormatNumber($this->akunpersediaan->ViewValue, $this->akunpersediaan->formatPattern());

        // akunreturjual
        $this->akunreturjual->ViewValue = $this->akunreturjual->CurrentValue;
        $this->akunreturjual->ViewValue = FormatNumber($this->akunreturjual->ViewValue, $this->akunreturjual->formatPattern());

        // hargapokok
        $this->hargapokok->ViewValue = $this->hargapokok->CurrentValue;
        $this->hargapokok->ViewValue = FormatNumber($this->hargapokok->ViewValue, $this->hargapokok->formatPattern());

        // p
        $this->p->ViewValue = $this->p->CurrentValue;
        $this->p->ViewValue = FormatNumber($this->p->ViewValue, $this->p->formatPattern());

        // l
        $this->l->ViewValue = $this->l->CurrentValue;
        $this->l->ViewValue = FormatNumber($this->l->ViewValue, $this->l->formatPattern());

        // t
        $this->_t->ViewValue = $this->_t->CurrentValue;
        $this->_t->ViewValue = FormatNumber($this->_t->ViewValue, $this->_t->formatPattern());

        // berat
        $this->berat->ViewValue = $this->berat->CurrentValue;
        $this->berat->ViewValue = FormatNumber($this->berat->ViewValue, $this->berat->formatPattern());

        // supplier_id
        $this->supplier_id->ViewValue = $this->supplier_id->CurrentValue;
        $this->supplier_id->ViewValue = FormatNumber($this->supplier_id->ViewValue, $this->supplier_id->formatPattern());

        // waktukirim
        $this->waktukirim->ViewValue = $this->waktukirim->CurrentValue;
        $this->waktukirim->ViewValue = FormatNumber($this->waktukirim->ViewValue, $this->waktukirim->formatPattern());

        // aktif
        $this->aktif->ViewValue = $this->aktif->CurrentValue;
        $this->aktif->ViewValue = FormatNumber($this->aktif->ViewValue, $this->aktif->formatPattern());

        // id_FK
        $this->id_FK->ViewValue = $this->id_FK->CurrentValue;
        $this->id_FK->ViewValue = FormatNumber($this->id_FK->ViewValue, $this->id_FK->formatPattern());

        // id
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // kode
        $this->kode->HrefValue = "";
        $this->kode->TooltipValue = "";

        // nama
        $this->nama->HrefValue = "";
        $this->nama->TooltipValue = "";

        // kelompok_id
        $this->kelompok_id->HrefValue = "";
        $this->kelompok_id->TooltipValue = "";

        // satuan_id
        $this->satuan_id->HrefValue = "";
        $this->satuan_id->TooltipValue = "";

        // satuan_id2
        $this->satuan_id2->HrefValue = "";
        $this->satuan_id2->TooltipValue = "";

        // gudang_id
        $this->gudang_id->HrefValue = "";
        $this->gudang_id->TooltipValue = "";

        // minstok
        $this->minstok->HrefValue = "";
        $this->minstok->TooltipValue = "";

        // minorder
        $this->minorder->HrefValue = "";
        $this->minorder->TooltipValue = "";

        // akunhpp
        $this->akunhpp->HrefValue = "";
        $this->akunhpp->TooltipValue = "";

        // akunjual
        $this->akunjual->HrefValue = "";
        $this->akunjual->TooltipValue = "";

        // akunpersediaan
        $this->akunpersediaan->HrefValue = "";
        $this->akunpersediaan->TooltipValue = "";

        // akunreturjual
        $this->akunreturjual->HrefValue = "";
        $this->akunreturjual->TooltipValue = "";

        // hargapokok
        $this->hargapokok->HrefValue = "";
        $this->hargapokok->TooltipValue = "";

        // p
        $this->p->HrefValue = "";
        $this->p->TooltipValue = "";

        // l
        $this->l->HrefValue = "";
        $this->l->TooltipValue = "";

        // t
        $this->_t->HrefValue = "";
        $this->_t->TooltipValue = "";

        // berat
        $this->berat->HrefValue = "";
        $this->berat->TooltipValue = "";

        // supplier_id
        $this->supplier_id->HrefValue = "";
        $this->supplier_id->TooltipValue = "";

        // waktukirim
        $this->waktukirim->HrefValue = "";
        $this->waktukirim->TooltipValue = "";

        // aktif
        $this->aktif->HrefValue = "";
        $this->aktif->TooltipValue = "";

        // id_FK
        $this->id_FK->HrefValue = "";
        $this->id_FK->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->setupEditAttributes();
        $this->id->EditValue = $this->id->CurrentValue;

        // kode
        $this->kode->setupEditAttributes();
        if (!$this->kode->Raw) {
            $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
        }
        $this->kode->EditValue = $this->kode->CurrentValue;
        $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

        // nama
        $this->nama->setupEditAttributes();
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // kelompok_id
        $this->kelompok_id->setupEditAttributes();
        $this->kelompok_id->EditValue = $this->kelompok_id->CurrentValue;
        $this->kelompok_id->PlaceHolder = RemoveHtml($this->kelompok_id->caption());
        if (strval($this->kelompok_id->EditValue) != "" && is_numeric($this->kelompok_id->EditValue)) {
            $this->kelompok_id->EditValue = FormatNumber($this->kelompok_id->EditValue, null);
        }

        // satuan_id
        $this->satuan_id->setupEditAttributes();
        $this->satuan_id->EditValue = $this->satuan_id->CurrentValue;
        $this->satuan_id->PlaceHolder = RemoveHtml($this->satuan_id->caption());
        if (strval($this->satuan_id->EditValue) != "" && is_numeric($this->satuan_id->EditValue)) {
            $this->satuan_id->EditValue = FormatNumber($this->satuan_id->EditValue, null);
        }

        // satuan_id2
        $this->satuan_id2->setupEditAttributes();
        $this->satuan_id2->EditValue = $this->satuan_id2->CurrentValue;
        $this->satuan_id2->PlaceHolder = RemoveHtml($this->satuan_id2->caption());
        if (strval($this->satuan_id2->EditValue) != "" && is_numeric($this->satuan_id2->EditValue)) {
            $this->satuan_id2->EditValue = FormatNumber($this->satuan_id2->EditValue, null);
        }

        // gudang_id
        $this->gudang_id->setupEditAttributes();
        $this->gudang_id->EditValue = $this->gudang_id->CurrentValue;
        $this->gudang_id->PlaceHolder = RemoveHtml($this->gudang_id->caption());
        if (strval($this->gudang_id->EditValue) != "" && is_numeric($this->gudang_id->EditValue)) {
            $this->gudang_id->EditValue = FormatNumber($this->gudang_id->EditValue, null);
        }

        // minstok
        $this->minstok->setupEditAttributes();
        $this->minstok->EditValue = $this->minstok->CurrentValue;
        $this->minstok->PlaceHolder = RemoveHtml($this->minstok->caption());
        if (strval($this->minstok->EditValue) != "" && is_numeric($this->minstok->EditValue)) {
            $this->minstok->EditValue = FormatNumber($this->minstok->EditValue, null);
        }

        // minorder
        $this->minorder->setupEditAttributes();
        $this->minorder->EditValue = $this->minorder->CurrentValue;
        $this->minorder->PlaceHolder = RemoveHtml($this->minorder->caption());
        if (strval($this->minorder->EditValue) != "" && is_numeric($this->minorder->EditValue)) {
            $this->minorder->EditValue = FormatNumber($this->minorder->EditValue, null);
        }

        // akunhpp
        $this->akunhpp->setupEditAttributes();
        $this->akunhpp->EditValue = $this->akunhpp->CurrentValue;
        $this->akunhpp->PlaceHolder = RemoveHtml($this->akunhpp->caption());
        if (strval($this->akunhpp->EditValue) != "" && is_numeric($this->akunhpp->EditValue)) {
            $this->akunhpp->EditValue = FormatNumber($this->akunhpp->EditValue, null);
        }

        // akunjual
        $this->akunjual->setupEditAttributes();
        $this->akunjual->EditValue = $this->akunjual->CurrentValue;
        $this->akunjual->PlaceHolder = RemoveHtml($this->akunjual->caption());
        if (strval($this->akunjual->EditValue) != "" && is_numeric($this->akunjual->EditValue)) {
            $this->akunjual->EditValue = FormatNumber($this->akunjual->EditValue, null);
        }

        // akunpersediaan
        $this->akunpersediaan->setupEditAttributes();
        $this->akunpersediaan->EditValue = $this->akunpersediaan->CurrentValue;
        $this->akunpersediaan->PlaceHolder = RemoveHtml($this->akunpersediaan->caption());
        if (strval($this->akunpersediaan->EditValue) != "" && is_numeric($this->akunpersediaan->EditValue)) {
            $this->akunpersediaan->EditValue = FormatNumber($this->akunpersediaan->EditValue, null);
        }

        // akunreturjual
        $this->akunreturjual->setupEditAttributes();
        $this->akunreturjual->EditValue = $this->akunreturjual->CurrentValue;
        $this->akunreturjual->PlaceHolder = RemoveHtml($this->akunreturjual->caption());
        if (strval($this->akunreturjual->EditValue) != "" && is_numeric($this->akunreturjual->EditValue)) {
            $this->akunreturjual->EditValue = FormatNumber($this->akunreturjual->EditValue, null);
        }

        // hargapokok
        $this->hargapokok->setupEditAttributes();
        $this->hargapokok->EditValue = $this->hargapokok->CurrentValue;
        $this->hargapokok->PlaceHolder = RemoveHtml($this->hargapokok->caption());
        if (strval($this->hargapokok->EditValue) != "" && is_numeric($this->hargapokok->EditValue)) {
            $this->hargapokok->EditValue = FormatNumber($this->hargapokok->EditValue, null);
        }

        // p
        $this->p->setupEditAttributes();
        $this->p->EditValue = $this->p->CurrentValue;
        $this->p->PlaceHolder = RemoveHtml($this->p->caption());
        if (strval($this->p->EditValue) != "" && is_numeric($this->p->EditValue)) {
            $this->p->EditValue = FormatNumber($this->p->EditValue, null);
        }

        // l
        $this->l->setupEditAttributes();
        $this->l->EditValue = $this->l->CurrentValue;
        $this->l->PlaceHolder = RemoveHtml($this->l->caption());
        if (strval($this->l->EditValue) != "" && is_numeric($this->l->EditValue)) {
            $this->l->EditValue = FormatNumber($this->l->EditValue, null);
        }

        // t
        $this->_t->setupEditAttributes();
        $this->_t->EditValue = $this->_t->CurrentValue;
        $this->_t->PlaceHolder = RemoveHtml($this->_t->caption());
        if (strval($this->_t->EditValue) != "" && is_numeric($this->_t->EditValue)) {
            $this->_t->EditValue = FormatNumber($this->_t->EditValue, null);
        }

        // berat
        $this->berat->setupEditAttributes();
        $this->berat->EditValue = $this->berat->CurrentValue;
        $this->berat->PlaceHolder = RemoveHtml($this->berat->caption());
        if (strval($this->berat->EditValue) != "" && is_numeric($this->berat->EditValue)) {
            $this->berat->EditValue = FormatNumber($this->berat->EditValue, null);
        }

        // supplier_id
        $this->supplier_id->setupEditAttributes();
        $this->supplier_id->EditValue = $this->supplier_id->CurrentValue;
        $this->supplier_id->PlaceHolder = RemoveHtml($this->supplier_id->caption());
        if (strval($this->supplier_id->EditValue) != "" && is_numeric($this->supplier_id->EditValue)) {
            $this->supplier_id->EditValue = FormatNumber($this->supplier_id->EditValue, null);
        }

        // waktukirim
        $this->waktukirim->setupEditAttributes();
        $this->waktukirim->EditValue = $this->waktukirim->CurrentValue;
        $this->waktukirim->PlaceHolder = RemoveHtml($this->waktukirim->caption());
        if (strval($this->waktukirim->EditValue) != "" && is_numeric($this->waktukirim->EditValue)) {
            $this->waktukirim->EditValue = FormatNumber($this->waktukirim->EditValue, null);
        }

        // aktif
        $this->aktif->setupEditAttributes();
        $this->aktif->EditValue = $this->aktif->CurrentValue;
        $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());
        if (strval($this->aktif->EditValue) != "" && is_numeric($this->aktif->EditValue)) {
            $this->aktif->EditValue = FormatNumber($this->aktif->EditValue, null);
        }

        // id_FK
        $this->id_FK->setupEditAttributes();
        $this->id_FK->EditValue = $this->id_FK->CurrentValue;
        $this->id_FK->PlaceHolder = RemoveHtml($this->id_FK->caption());
        if (strval($this->id_FK->EditValue) != "" && is_numeric($this->id_FK->EditValue)) {
            $this->id_FK->EditValue = FormatNumber($this->id_FK->EditValue, null);
        }

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->kelompok_id);
                    $doc->exportCaption($this->satuan_id);
                    $doc->exportCaption($this->satuan_id2);
                    $doc->exportCaption($this->gudang_id);
                    $doc->exportCaption($this->minstok);
                    $doc->exportCaption($this->minorder);
                    $doc->exportCaption($this->akunhpp);
                    $doc->exportCaption($this->akunjual);
                    $doc->exportCaption($this->akunpersediaan);
                    $doc->exportCaption($this->akunreturjual);
                    $doc->exportCaption($this->hargapokok);
                    $doc->exportCaption($this->p);
                    $doc->exportCaption($this->l);
                    $doc->exportCaption($this->_t);
                    $doc->exportCaption($this->berat);
                    $doc->exportCaption($this->supplier_id);
                    $doc->exportCaption($this->waktukirim);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->id_FK);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->kelompok_id);
                    $doc->exportCaption($this->satuan_id);
                    $doc->exportCaption($this->satuan_id2);
                    $doc->exportCaption($this->gudang_id);
                    $doc->exportCaption($this->minstok);
                    $doc->exportCaption($this->minorder);
                    $doc->exportCaption($this->akunhpp);
                    $doc->exportCaption($this->akunjual);
                    $doc->exportCaption($this->akunpersediaan);
                    $doc->exportCaption($this->akunreturjual);
                    $doc->exportCaption($this->hargapokok);
                    $doc->exportCaption($this->p);
                    $doc->exportCaption($this->l);
                    $doc->exportCaption($this->_t);
                    $doc->exportCaption($this->berat);
                    $doc->exportCaption($this->supplier_id);
                    $doc->exportCaption($this->waktukirim);
                    $doc->exportCaption($this->aktif);
                    $doc->exportCaption($this->id_FK);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->kelompok_id);
                        $doc->exportField($this->satuan_id);
                        $doc->exportField($this->satuan_id2);
                        $doc->exportField($this->gudang_id);
                        $doc->exportField($this->minstok);
                        $doc->exportField($this->minorder);
                        $doc->exportField($this->akunhpp);
                        $doc->exportField($this->akunjual);
                        $doc->exportField($this->akunpersediaan);
                        $doc->exportField($this->akunreturjual);
                        $doc->exportField($this->hargapokok);
                        $doc->exportField($this->p);
                        $doc->exportField($this->l);
                        $doc->exportField($this->_t);
                        $doc->exportField($this->berat);
                        $doc->exportField($this->supplier_id);
                        $doc->exportField($this->waktukirim);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->id_FK);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->kelompok_id);
                        $doc->exportField($this->satuan_id);
                        $doc->exportField($this->satuan_id2);
                        $doc->exportField($this->gudang_id);
                        $doc->exportField($this->minstok);
                        $doc->exportField($this->minorder);
                        $doc->exportField($this->akunhpp);
                        $doc->exportField($this->akunjual);
                        $doc->exportField($this->akunpersediaan);
                        $doc->exportField($this->akunreturjual);
                        $doc->exportField($this->hargapokok);
                        $doc->exportField($this->p);
                        $doc->exportField($this->l);
                        $doc->exportField($this->_t);
                        $doc->exportField($this->berat);
                        $doc->exportField($this->supplier_id);
                        $doc->exportField($this->waktukirim);
                        $doc->exportField($this->aktif);
                        $doc->exportField($this->id_FK);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
