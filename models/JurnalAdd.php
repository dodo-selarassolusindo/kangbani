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
class JurnalAdd extends Jurnal
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "JurnalAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "jurnaladd";

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
        $this->tipejurnal_id->setVisibility();
        $this->period_id->setVisibility();
        $this->createon->setVisibility();
        $this->keterangan->setVisibility();
        $this->person_id->setVisibility();
        $this->nomer->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer;
        $this->TableVar = 'jurnal';
        $this->TableName = 'jurnal';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (jurnal)
        if (!isset($GLOBALS["jurnal"]) || $GLOBALS["jurnal"]::class == PROJECT_NAMESPACE . "jurnal") {
            $GLOBALS["jurnal"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'jurnal');
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "jurnalview"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Create form object
        $CurrentForm = new HttpForm();
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
        $this->setupLookupOptions($this->tipejurnal_id);
        $this->setupLookupOptions($this->period_id);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("jurnallist"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "jurnallist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "jurnalview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "jurnallist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "jurnallist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'tipejurnal_id' first before field var 'x_tipejurnal_id'
        $val = $CurrentForm->hasValue("tipejurnal_id") ? $CurrentForm->getValue("tipejurnal_id") : $CurrentForm->getValue("x_tipejurnal_id");
        if (!$this->tipejurnal_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipejurnal_id->Visible = false; // Disable update for API request
            } else {
                $this->tipejurnal_id->setFormValue($val);
            }
        }

        // Check field name 'period_id' first before field var 'x_period_id'
        $val = $CurrentForm->hasValue("period_id") ? $CurrentForm->getValue("period_id") : $CurrentForm->getValue("x_period_id");
        if (!$this->period_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->period_id->Visible = false; // Disable update for API request
            } else {
                $this->period_id->setFormValue($val);
            }
        }

        // Check field name 'createon' first before field var 'x_createon'
        $val = $CurrentForm->hasValue("createon") ? $CurrentForm->getValue("createon") : $CurrentForm->getValue("x_createon");
        if (!$this->createon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->createon->Visible = false; // Disable update for API request
            } else {
                $this->createon->setFormValue($val);
            }
            $this->createon->CurrentValue = UnFormatDateTime($this->createon->CurrentValue, $this->createon->formatPattern());
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'person_id' first before field var 'x_person_id'
        $val = $CurrentForm->hasValue("person_id") ? $CurrentForm->getValue("person_id") : $CurrentForm->getValue("x_person_id");
        if (!$this->person_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->person_id->Visible = false; // Disable update for API request
            } else {
                $this->person_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nomer' first before field var 'x_nomer'
        $val = $CurrentForm->hasValue("nomer") ? $CurrentForm->getValue("nomer") : $CurrentForm->getValue("x_nomer");
        if (!$this->nomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomer->Visible = false; // Disable update for API request
            } else {
                $this->nomer->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tipejurnal_id->CurrentValue = $this->tipejurnal_id->FormValue;
        $this->period_id->CurrentValue = $this->period_id->FormValue;
        $this->createon->CurrentValue = $this->createon->FormValue;
        $this->createon->CurrentValue = UnFormatDateTime($this->createon->CurrentValue, $this->createon->formatPattern());
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->person_id->CurrentValue = $this->person_id->FormValue;
        $this->nomer->CurrentValue = $this->nomer->FormValue;
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
        $this->tipejurnal_id->setDbValue($row['tipejurnal_id']);
        $this->period_id->setDbValue($row['period_id']);
        $this->createon->setDbValue($row['createon']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->person_id->setDbValue($row['person_id']);
        $this->nomer->setDbValue($row['nomer']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['tipejurnal_id'] = $this->tipejurnal_id->DefaultValue;
        $row['period_id'] = $this->period_id->DefaultValue;
        $row['createon'] = $this->createon->DefaultValue;
        $row['keterangan'] = $this->keterangan->DefaultValue;
        $row['person_id'] = $this->person_id->DefaultValue;
        $row['nomer'] = $this->nomer->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
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
        $this->id->RowCssClass = "row";

        // tipejurnal_id
        $this->tipejurnal_id->RowCssClass = "row";

        // period_id
        $this->period_id->RowCssClass = "row";

        // createon
        $this->createon->RowCssClass = "row";

        // keterangan
        $this->keterangan->RowCssClass = "row";

        // person_id
        $this->person_id->RowCssClass = "row";

        // nomer
        $this->nomer->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
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

            // tipejurnal_id
            $this->tipejurnal_id->HrefValue = "";

            // period_id
            $this->period_id->HrefValue = "";

            // createon
            $this->createon->HrefValue = "";

            // keterangan
            $this->keterangan->HrefValue = "";

            // person_id
            $this->person_id->HrefValue = "";

            // nomer
            $this->nomer->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // tipejurnal_id
            $this->tipejurnal_id->setupEditAttributes();
            $curVal = trim(strval($this->tipejurnal_id->CurrentValue));
            if ($curVal != "") {
                $this->tipejurnal_id->ViewValue = $this->tipejurnal_id->lookupCacheOption($curVal);
            } else {
                $this->tipejurnal_id->ViewValue = $this->tipejurnal_id->Lookup !== null && is_array($this->tipejurnal_id->lookupOptions()) && count($this->tipejurnal_id->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipejurnal_id->ViewValue !== null) { // Load from cache
                $this->tipejurnal_id->EditValue = array_values($this->tipejurnal_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipejurnal_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $this->tipejurnal_id->CurrentValue, $this->tipejurnal_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipejurnal_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipejurnal_id->EditValue = $arwrk;
            }
            $this->tipejurnal_id->PlaceHolder = RemoveHtml($this->tipejurnal_id->caption());

            // period_id
            $this->period_id->setupEditAttributes();
            $curVal = trim(strval($this->period_id->CurrentValue));
            if ($curVal != "") {
                $this->period_id->ViewValue = $this->period_id->lookupCacheOption($curVal);
            } else {
                $this->period_id->ViewValue = $this->period_id->Lookup !== null && is_array($this->period_id->lookupOptions()) && count($this->period_id->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->period_id->ViewValue !== null) { // Load from cache
                $this->period_id->EditValue = array_values($this->period_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->period_id->Lookup->getTable()->Fields["id"]->searchExpression(), "=", $this->period_id->CurrentValue, $this->period_id->Lookup->getTable()->Fields["id"]->searchDataType(), "");
                }
                $sqlWrk = $this->period_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->period_id->Lookup->renderViewRow($row);
                }
                $this->period_id->EditValue = $arwrk;
            }
            $this->period_id->PlaceHolder = RemoveHtml($this->period_id->caption());

            // createon

            // keterangan
            $this->keterangan->setupEditAttributes();
            if (!$this->keterangan->Raw) {
                $this->keterangan->CurrentValue = HtmlDecode($this->keterangan->CurrentValue);
            }
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
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
            $this->nomer->EditValue = HtmlEncode($this->nomer->CurrentValue);
            $this->nomer->PlaceHolder = RemoveHtml($this->nomer->caption());

            // Add refer script

            // tipejurnal_id
            $this->tipejurnal_id->HrefValue = "";

            // period_id
            $this->period_id->HrefValue = "";

            // createon
            $this->createon->HrefValue = "";

            // keterangan
            $this->keterangan->HrefValue = "";

            // person_id
            $this->person_id->HrefValue = "";

            // nomer
            $this->nomer->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->tipejurnal_id->Visible && $this->tipejurnal_id->Required) {
                if (!$this->tipejurnal_id->IsDetailKey && EmptyValue($this->tipejurnal_id->FormValue)) {
                    $this->tipejurnal_id->addErrorMessage(str_replace("%s", $this->tipejurnal_id->caption(), $this->tipejurnal_id->RequiredErrorMessage));
                }
            }
            if ($this->period_id->Visible && $this->period_id->Required) {
                if (!$this->period_id->IsDetailKey && EmptyValue($this->period_id->FormValue)) {
                    $this->period_id->addErrorMessage(str_replace("%s", $this->period_id->caption(), $this->period_id->RequiredErrorMessage));
                }
            }
            if ($this->createon->Visible && $this->createon->Required) {
                if (!$this->createon->IsDetailKey && EmptyValue($this->createon->FormValue)) {
                    $this->createon->addErrorMessage(str_replace("%s", $this->createon->caption(), $this->createon->RequiredErrorMessage));
                }
            }
            if ($this->keterangan->Visible && $this->keterangan->Required) {
                if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                    $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
                }
            }
            if ($this->person_id->Visible && $this->person_id->Required) {
                if (!$this->person_id->IsDetailKey && EmptyValue($this->person_id->FormValue)) {
                    $this->person_id->addErrorMessage(str_replace("%s", $this->person_id->caption(), $this->person_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->person_id->FormValue)) {
                $this->person_id->addErrorMessage($this->person_id->getErrorMessage(false));
            }
            if ($this->nomer->Visible && $this->nomer->Required) {
                if (!$this->nomer->IsDetailKey && EmptyValue($this->nomer->FormValue)) {
                    $this->nomer->addErrorMessage(str_replace("%s", $this->nomer->caption(), $this->nomer->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("JurnaldGrid");
        if (in_array("jurnald", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("JurnaldGrid");
            if (in_array("jurnald", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->jurnal_id->setSessionValue($this->id->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->jurnal_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    if ($conn->isTransactionActive()) {
                        $conn->commit();
                    }
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    if ($conn->isTransactionActive()) {
                        $conn->rollback();
                    }
                }
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // tipejurnal_id
        $this->tipejurnal_id->setDbValueDef($rsnew, $this->tipejurnal_id->CurrentValue, false);

        // period_id
        $this->period_id->setDbValueDef($rsnew, $this->period_id->CurrentValue, false);

        // createon
        $this->createon->CurrentValue = $this->createon->getAutoUpdateValue(); // PHP
        $this->createon->setDbValueDef($rsnew, UnFormatDateTime($this->createon->CurrentValue, $this->createon->formatPattern()));

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, false);

        // person_id
        $this->person_id->setDbValueDef($rsnew, $this->person_id->CurrentValue, false);

        // nomer
        $this->nomer->setDbValueDef($rsnew, $this->nomer->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['tipejurnal_id'])) { // tipejurnal_id
            $this->tipejurnal_id->setFormValue($row['tipejurnal_id']);
        }
        if (isset($row['period_id'])) { // period_id
            $this->period_id->setFormValue($row['period_id']);
        }
        if (isset($row['createon'])) { // createon
            $this->createon->setFormValue($row['createon']);
        }
        if (isset($row['keterangan'])) { // keterangan
            $this->keterangan->setFormValue($row['keterangan']);
        }
        if (isset($row['person_id'])) { // person_id
            $this->person_id->setFormValue($row['person_id']);
        }
        if (isset($row['nomer'])) { // nomer
            $this->nomer->setFormValue($row['nomer']);
        }
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("jurnald", $detailTblVar)) {
                $detailPageObj = Container("JurnaldGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->jurnal_id->IsDetailKey = true;
                    $detailPageObj->jurnal_id->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->jurnal_id->setSessionValue($detailPageObj->jurnal_id->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("jurnallist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_tipejurnal_id":
                    break;
                case "x_period_id":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
