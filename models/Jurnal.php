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
 * Table class for jurnal
 */
class Jurnal extends DbTable
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
    public $tipejurnal_id;
    public $period_id;
    public $createon;
    public $keterangan;
    public $person_id;
    public $nomer;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "jurnal";
        $this->TableName = 'jurnal';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "jurnal";
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
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Nullable = false; // NOT NULL field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['id'] = &$this->id;

        // tipejurnal_id
        $this->tipejurnal_id = new DbField(
            $this, // Table
            'x_tipejurnal_id', // Variable name
            'tipejurnal_id', // Name
            '`tipejurnal_id`', // Expression
            '`tipejurnal_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipejurnal_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipejurnal_id->InputTextType = "text";
        $this->tipejurnal_id->Raw = true;
        $this->tipejurnal_id->setSelectMultiple(false); // Select one
        $this->tipejurnal_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipejurnal_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipejurnal_id->Lookup = new Lookup($this->tipejurnal_id, 'tipejurnal', false, 'id', ["nama","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nama`");
        $this->tipejurnal_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipejurnal_id->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipejurnal_id'] = &$this->tipejurnal_id;

        // period_id
        $this->period_id = new DbField(
            $this, // Table
            'x_period_id', // Variable name
            'period_id', // Name
            '`period_id`', // Expression
            '`period_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`period_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->period_id->InputTextType = "text";
        $this->period_id->Raw = true;
        $this->period_id->setSelectMultiple(false); // Select one
        $this->period_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->period_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->period_id->Lookup = new Lookup($this->period_id, 'periode', false, 'id', ["start","end","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(" . CastDateFieldForLike("`start`", 7, "DB") . ", ''),'" . ValueSeparator(1, $this->period_id) . "',COALESCE(" . CastDateFieldForLike("`end`", 7, "DB") . ",''))");
        $this->period_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->period_id->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['period_id'] = &$this->period_id;

        // createon
        $this->createon = new DbField(
            $this, // Table
            'x_createon', // Variable name
            'createon', // Name
            '`createon`', // Expression
            CastDateFieldForLike("`createon`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`createon`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->createon->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->createon->InputTextType = "text";
        $this->createon->Raw = true;
        $this->createon->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->createon->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['createon'] = &$this->createon;

        // keterangan
        $this->keterangan = new DbField(
            $this, // Table
            'x_keterangan', // Variable name
            'keterangan', // Name
            '`keterangan`', // Expression
            '`keterangan`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`keterangan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->keterangan->InputTextType = "text";
        $this->keterangan->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['keterangan'] = &$this->keterangan;

        // person_id
        $this->person_id = new DbField(
            $this, // Table
            'x_person_id', // Variable name
            'person_id', // Name
            '`person_id`', // Expression
            '`person_id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`person_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->person_id->InputTextType = "text";
        $this->person_id->Raw = true;
        $this->person_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->person_id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['person_id'] = &$this->person_id;

        // nomer
        $this->nomer = new DbField(
            $this, // Table
            'x_nomer', // Variable name
            'nomer', // Name
            '`nomer`', // Expression
            '`nomer`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nomer`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nomer->InputTextType = "text";
        $this->nomer->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nomer'] = &$this->nomer;

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

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "jurnald") {
            $detailUrl = Container("jurnald")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "jurnallist";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "jurnal";
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
        // Cascade Update detail table 'jurnald'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'jurnal_id'
            $cascadeUpdate = true;
            $rscascade['jurnal_id'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("jurnald")->loadRs("`jurnal_id` = " . QuotedValue($rsold['id'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("jurnald")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("jurnald")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("jurnald")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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

        // Cascade delete detail table 'jurnald'
        $dtlrows = Container("jurnald")->loadRs("`jurnal_id` = " . QuotedValue($rs['id'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("jurnald")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("jurnald")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("jurnald")->rowDeleted($dtlrow);
            }
        }
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
        $this->tipejurnal_id->DbValue = $row['tipejurnal_id'];
        $this->period_id->DbValue = $row['period_id'];
        $this->createon->DbValue = $row['createon'];
        $this->keterangan->DbValue = $row['keterangan'];
        $this->person_id->DbValue = $row['person_id'];
        $this->nomer->DbValue = $row['nomer'];
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
        return $_SESSION[$name] ?? GetUrl("jurnallist");
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
            "jurnalview" => $Language->phrase("View"),
            "jurnaledit" => $Language->phrase("Edit"),
            "jurnaladd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "jurnallist";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "JurnalView",
            Config("API_ADD_ACTION") => "JurnalAdd",
            Config("API_EDIT_ACTION") => "JurnalEdit",
            Config("API_DELETE_ACTION") => "JurnalDelete",
            Config("API_LIST_ACTION") => "JurnalList",
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
        return "jurnallist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("jurnalview", $parm);
        } else {
            $url = $this->keyUrl("jurnalview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "jurnaladd?" . $parm;
        } else {
            $url = "jurnaladd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("jurnaledit", $parm);
        } else {
            $url = $this->keyUrl("jurnaledit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("jurnallist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("jurnaladd", $parm);
        } else {
            $url = $this->keyUrl("jurnaladd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("jurnallist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("jurnaldelete", $parm);
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
        $this->tipejurnal_id->setDbValue($row['tipejurnal_id']);
        $this->period_id->setDbValue($row['period_id']);
        $this->createon->setDbValue($row['createon']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->person_id->setDbValue($row['person_id']);
        $this->nomer->setDbValue($row['nomer']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "JurnalList";
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

        // tipejurnal_id

        // period_id

        // createon

        // keterangan

        // person_id

        // nomer

        // id
        $this->id->ViewValue = $this->id->CurrentValue;

        // tipejurnal_id
        $curVal = strval($this->tipejurnal_id->CurrentValue);
        if ($curVal != "") {
            $this->tipejurnal_id->ViewValue = $this->tipejurnal_id->lookupCacheOption($curVal);
            if ($this->tipejurnal_id->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipejurnal_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->tipejurnal_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                $sqlWrk = $this->tipejurnal_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipejurnal_id->Lookup->renderViewRow($rswrk[0]);
                    $this->tipejurnal_id->ViewValue = $this->tipejurnal_id->displayValue($arwrk);
                } else {
                    $this->tipejurnal_id->ViewValue = FormatNumber($this->tipejurnal_id->CurrentValue, $this->tipejurnal_id->formatPattern());
                }
            }
        } else {
            $this->tipejurnal_id->ViewValue = null;
        }

        // period_id
        $curVal = strval($this->period_id->CurrentValue);
        if ($curVal != "") {
            $this->period_id->ViewValue = $this->period_id->lookupCacheOption($curVal);
            if ($this->period_id->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->period_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->period_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                $sqlWrk = $this->period_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->period_id->Lookup->renderViewRow($rswrk[0]);
                    $this->period_id->ViewValue = $this->period_id->displayValue($arwrk);
                } else {
                    $this->period_id->ViewValue = FormatNumber($this->period_id->CurrentValue, $this->period_id->formatPattern());
                }
            }
        } else {
            $this->period_id->ViewValue = null;
        }

        // createon
        $this->createon->ViewValue = $this->createon->CurrentValue;
        $this->createon->ViewValue = FormatDateTime($this->createon->ViewValue, $this->createon->formatPattern());

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;

        // person_id
        $this->person_id->ViewValue = $this->person_id->CurrentValue;
        $this->person_id->ViewValue = FormatNumber($this->person_id->ViewValue, $this->person_id->formatPattern());

        // nomer
        $this->nomer->ViewValue = $this->nomer->CurrentValue;

        // id
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // tipejurnal_id
        $this->tipejurnal_id->HrefValue = "";
        $this->tipejurnal_id->TooltipValue = "";

        // period_id
        $this->period_id->HrefValue = "";
        $this->period_id->TooltipValue = "";

        // createon
        $this->createon->HrefValue = "";
        $this->createon->TooltipValue = "";

        // keterangan
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

        // person_id
        $this->person_id->HrefValue = "";
        $this->person_id->TooltipValue = "";

        // nomer
        $this->nomer->HrefValue = "";
        $this->nomer->TooltipValue = "";

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

        // tipejurnal_id
        $this->tipejurnal_id->setupEditAttributes();
        $this->tipejurnal_id->PlaceHolder = RemoveHtml($this->tipejurnal_id->caption());

        // period_id
        $this->period_id->setupEditAttributes();
        $this->period_id->PlaceHolder = RemoveHtml($this->period_id->caption());

        // createon

        // keterangan
        $this->keterangan->setupEditAttributes();
        if (!$this->keterangan->Raw) {
            $this->keterangan->CurrentValue = HtmlDecode($this->keterangan->CurrentValue);
        }
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

        // person_id
        $this->person_id->setupEditAttributes();
        $this->person_id->EditValue = $this->person_id->CurrentValue;
        $this->person_id->PlaceHolder = RemoveHtml($this->person_id->caption());
        if (strval($this->person_id->EditValue) != "" && is_numeric($this->person_id->EditValue)) {
            $this->person_id->EditValue = FormatNumber($this->person_id->EditValue, null);
        }

        // nomer
        $this->nomer->setupEditAttributes();
        if (!$this->nomer->Raw) {
            $this->nomer->CurrentValue = HtmlDecode($this->nomer->CurrentValue);
        }
        $this->nomer->EditValue = $this->nomer->CurrentValue;
        $this->nomer->PlaceHolder = RemoveHtml($this->nomer->caption());

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
                    $doc->exportCaption($this->tipejurnal_id);
                    $doc->exportCaption($this->period_id);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->nomer);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->tipejurnal_id);
                    $doc->exportCaption($this->period_id);
                    $doc->exportCaption($this->createon);
                    $doc->exportCaption($this->keterangan);
                    $doc->exportCaption($this->person_id);
                    $doc->exportCaption($this->nomer);
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
                        $doc->exportField($this->tipejurnal_id);
                        $doc->exportField($this->period_id);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->nomer);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->tipejurnal_id);
                        $doc->exportField($this->period_id);
                        $doc->exportField($this->createon);
                        $doc->exportField($this->keterangan);
                        $doc->exportField($this->person_id);
                        $doc->exportField($this->nomer);
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
