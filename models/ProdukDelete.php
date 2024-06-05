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
 * Page class
 */
class ProdukDelete extends Produk
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProdukDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "produkdelete";

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->id->Visible = false;
        $this->kode->setVisibility();
        $this->nama->setVisibility();
        $this->kelompok_id->setVisibility();
        $this->satuan_id->setVisibility();
        $this->satuan_id2->setVisibility();
        $this->gudang_id->setVisibility();
        $this->minstok->setVisibility();
        $this->minorder->setVisibility();
        $this->akunhpp->setVisibility();
        $this->akunjual->setVisibility();
        $this->akunpersediaan->setVisibility();
        $this->akunreturjual->setVisibility();
        $this->hargapokok->setVisibility();
        $this->p->setVisibility();
        $this->l->setVisibility();
        $this->_t->setVisibility();
        $this->berat->setVisibility();
        $this->supplier_id->setVisibility();
        $this->waktukirim->setVisibility();
        $this->aktif->setVisibility();
        $this->id_FK->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer;
        $this->TableVar = 'produk';
        $this->TableName = 'produk';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (produk)
        if (!isset($GLOBALS["produk"]) || $GLOBALS["produk"]::class == PROJECT_NAMESPACE . "produk") {
            $GLOBALS["produk"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'produk');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->kelompok_id);
        $this->setupLookupOptions($this->satuan_id);
        $this->setupLookupOptions($this->satuan_id2);
        $this->setupLookupOptions($this->gudang_id);
        $this->setupLookupOptions($this->akunhpp);
        $this->setupLookupOptions($this->akunjual);
        $this->setupLookupOptions($this->akunpersediaan);
        $this->setupLookupOptions($this->akunreturjual);
        $this->setupLookupOptions($this->supplier_id);
        $this->setupLookupOptions($this->aktif);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("produklist"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Recordset = $this->loadRecordset();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Recordset?->free();
                $this->terminate("produklist"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['kode'] = $this->kode->DefaultValue;
        $row['nama'] = $this->nama->DefaultValue;
        $row['kelompok_id'] = $this->kelompok_id->DefaultValue;
        $row['satuan_id'] = $this->satuan_id->DefaultValue;
        $row['satuan_id2'] = $this->satuan_id2->DefaultValue;
        $row['gudang_id'] = $this->gudang_id->DefaultValue;
        $row['minstok'] = $this->minstok->DefaultValue;
        $row['minorder'] = $this->minorder->DefaultValue;
        $row['akunhpp'] = $this->akunhpp->DefaultValue;
        $row['akunjual'] = $this->akunjual->DefaultValue;
        $row['akunpersediaan'] = $this->akunpersediaan->DefaultValue;
        $row['akunreturjual'] = $this->akunreturjual->DefaultValue;
        $row['hargapokok'] = $this->hargapokok->DefaultValue;
        $row['p'] = $this->p->DefaultValue;
        $row['l'] = $this->l->DefaultValue;
        $row['t'] = $this->_t->DefaultValue;
        $row['berat'] = $this->berat->DefaultValue;
        $row['supplier_id'] = $this->supplier_id->DefaultValue;
        $row['waktukirim'] = $this->waktukirim->DefaultValue;
        $row['aktif'] = $this->aktif->DefaultValue;
        $row['id_FK'] = $this->id_FK->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == RowType::VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;

            // kelompok_id
            $curVal = strval($this->kelompok_id->CurrentValue);
            if ($curVal != "") {
                $this->kelompok_id->ViewValue = $this->kelompok_id->lookupCacheOption($curVal);
                if ($this->kelompok_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->kelompok_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->kelompok_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->kelompok_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kelompok_id->Lookup->renderViewRow($rswrk[0]);
                        $this->kelompok_id->ViewValue = $this->kelompok_id->displayValue($arwrk);
                    } else {
                        $this->kelompok_id->ViewValue = FormatNumber($this->kelompok_id->CurrentValue, $this->kelompok_id->formatPattern());
                    }
                }
            } else {
                $this->kelompok_id->ViewValue = null;
            }

            // satuan_id
            $curVal = strval($this->satuan_id->CurrentValue);
            if ($curVal != "") {
                $this->satuan_id->ViewValue = $this->satuan_id->lookupCacheOption($curVal);
                if ($this->satuan_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->satuan_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->satuan_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->satuan_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuan_id->Lookup->renderViewRow($rswrk[0]);
                        $this->satuan_id->ViewValue = $this->satuan_id->displayValue($arwrk);
                    } else {
                        $this->satuan_id->ViewValue = FormatNumber($this->satuan_id->CurrentValue, $this->satuan_id->formatPattern());
                    }
                }
            } else {
                $this->satuan_id->ViewValue = null;
            }

            // satuan_id2
            $curVal = strval($this->satuan_id2->CurrentValue);
            if ($curVal != "") {
                $this->satuan_id2->ViewValue = $this->satuan_id2->lookupCacheOption($curVal);
                if ($this->satuan_id2->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->satuan_id2->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->satuan_id2->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->satuan_id2->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->satuan_id2->Lookup->renderViewRow($rswrk[0]);
                        $this->satuan_id2->ViewValue = $this->satuan_id2->displayValue($arwrk);
                    } else {
                        $this->satuan_id2->ViewValue = FormatNumber($this->satuan_id2->CurrentValue, $this->satuan_id2->formatPattern());
                    }
                }
            } else {
                $this->satuan_id2->ViewValue = null;
            }

            // gudang_id
            $curVal = strval($this->gudang_id->CurrentValue);
            if ($curVal != "") {
                $this->gudang_id->ViewValue = $this->gudang_id->lookupCacheOption($curVal);
                if ($this->gudang_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->gudang_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->gudang_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->gudang_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->gudang_id->Lookup->renderViewRow($rswrk[0]);
                        $this->gudang_id->ViewValue = $this->gudang_id->displayValue($arwrk);
                    } else {
                        $this->gudang_id->ViewValue = FormatNumber($this->gudang_id->CurrentValue, $this->gudang_id->formatPattern());
                    }
                }
            } else {
                $this->gudang_id->ViewValue = null;
            }

            // minstok
            $this->minstok->ViewValue = $this->minstok->CurrentValue;
            $this->minstok->ViewValue = FormatNumber($this->minstok->ViewValue, $this->minstok->formatPattern());

            // minorder
            $this->minorder->ViewValue = $this->minorder->CurrentValue;
            $this->minorder->ViewValue = FormatNumber($this->minorder->ViewValue, $this->minorder->formatPattern());

            // akunhpp
            $curVal = strval($this->akunhpp->CurrentValue);
            if ($curVal != "") {
                $this->akunhpp->ViewValue = $this->akunhpp->lookupCacheOption($curVal);
                if ($this->akunhpp->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->akunhpp->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->akunhpp->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->akunhpp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->akunhpp->Lookup->renderViewRow($rswrk[0]);
                        $this->akunhpp->ViewValue = $this->akunhpp->displayValue($arwrk);
                    } else {
                        $this->akunhpp->ViewValue = FormatNumber($this->akunhpp->CurrentValue, $this->akunhpp->formatPattern());
                    }
                }
            } else {
                $this->akunhpp->ViewValue = null;
            }

            // akunjual
            $curVal = strval($this->akunjual->CurrentValue);
            if ($curVal != "") {
                $this->akunjual->ViewValue = $this->akunjual->lookupCacheOption($curVal);
                if ($this->akunjual->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->akunjual->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->akunjual->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->akunjual->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->akunjual->Lookup->renderViewRow($rswrk[0]);
                        $this->akunjual->ViewValue = $this->akunjual->displayValue($arwrk);
                    } else {
                        $this->akunjual->ViewValue = FormatNumber($this->akunjual->CurrentValue, $this->akunjual->formatPattern());
                    }
                }
            } else {
                $this->akunjual->ViewValue = null;
            }

            // akunpersediaan
            $curVal = strval($this->akunpersediaan->CurrentValue);
            if ($curVal != "") {
                $this->akunpersediaan->ViewValue = $this->akunpersediaan->lookupCacheOption($curVal);
                if ($this->akunpersediaan->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->akunpersediaan->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->akunpersediaan->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->akunpersediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->akunpersediaan->Lookup->renderViewRow($rswrk[0]);
                        $this->akunpersediaan->ViewValue = $this->akunpersediaan->displayValue($arwrk);
                    } else {
                        $this->akunpersediaan->ViewValue = FormatNumber($this->akunpersediaan->CurrentValue, $this->akunpersediaan->formatPattern());
                    }
                }
            } else {
                $this->akunpersediaan->ViewValue = null;
            }

            // akunreturjual
            $curVal = strval($this->akunreturjual->CurrentValue);
            if ($curVal != "") {
                $this->akunreturjual->ViewValue = $this->akunreturjual->lookupCacheOption($curVal);
                if ($this->akunreturjual->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->akunreturjual->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->akunreturjual->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $sqlWrk = $this->akunreturjual->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->akunreturjual->Lookup->renderViewRow($rswrk[0]);
                        $this->akunreturjual->ViewValue = $this->akunreturjual->displayValue($arwrk);
                    } else {
                        $this->akunreturjual->ViewValue = FormatNumber($this->akunreturjual->CurrentValue, $this->akunreturjual->formatPattern());
                    }
                }
            } else {
                $this->akunreturjual->ViewValue = null;
            }

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
            $curVal = strval($this->supplier_id->CurrentValue);
            if ($curVal != "") {
                $this->supplier_id->ViewValue = $this->supplier_id->lookupCacheOption($curVal);
                if ($this->supplier_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->supplier_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $curVal, $this->supplier_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                    $lookupFilter = $this->supplier_id->getSelectFilter($this); // PHP
                    $sqlWrk = $this->supplier_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->supplier_id->Lookup->renderViewRow($rswrk[0]);
                        $this->supplier_id->ViewValue = $this->supplier_id->displayValue($arwrk);
                    } else {
                        $this->supplier_id->ViewValue = FormatNumber($this->supplier_id->CurrentValue, $this->supplier_id->formatPattern());
                    }
                }
            } else {
                $this->supplier_id->ViewValue = null;
            }

            // waktukirim
            $this->waktukirim->ViewValue = $this->waktukirim->CurrentValue;
            $this->waktukirim->ViewValue = FormatNumber($this->waktukirim->ViewValue, $this->waktukirim->formatPattern());

            // aktif
            if (strval($this->aktif->CurrentValue) != "") {
                $this->aktif->ViewValue = $this->aktif->optionCaption($this->aktif->CurrentValue);
            } else {
                $this->aktif->ViewValue = null;
            }

            // id_FK
            $this->id_FK->ViewValue = $this->id_FK->CurrentValue;
            $this->id_FK->ViewValue = FormatNumber($this->id_FK->ViewValue, $this->id_FK->formatPattern());

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
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("produklist"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_kelompok_id":
                    break;
                case "x_satuan_id":
                    break;
                case "x_satuan_id2":
                    break;
                case "x_gudang_id":
                    break;
                case "x_akunhpp":
                    break;
                case "x_akunjual":
                    break;
                case "x_akunpersediaan":
                    break;
                case "x_akunreturjual":
                    break;
                case "x_supplier_id":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_aktif":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }
}
