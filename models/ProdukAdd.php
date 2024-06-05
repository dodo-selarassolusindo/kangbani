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
class ProdukAdd extends Produk
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProdukAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "produkadd";

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
        $this->id_FK->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer;
        $this->TableVar = 'produk';
        $this->TableName = 'produk';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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
                        $result["view"] = SameString($pageName, "produkview"); // If View page, no primary button
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
                    $this->terminate("produklist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "produklist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "produkview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "produklist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "produklist"; // Return list page content
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
        $this->id_FK->DefaultValue = $this->id_FK->getDefault(); // PHP
        $this->id_FK->OldValue = $this->id_FK->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'kelompok_id' first before field var 'x_kelompok_id'
        $val = $CurrentForm->hasValue("kelompok_id") ? $CurrentForm->getValue("kelompok_id") : $CurrentForm->getValue("x_kelompok_id");
        if (!$this->kelompok_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kelompok_id->Visible = false; // Disable update for API request
            } else {
                $this->kelompok_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'satuan_id' first before field var 'x_satuan_id'
        $val = $CurrentForm->hasValue("satuan_id") ? $CurrentForm->getValue("satuan_id") : $CurrentForm->getValue("x_satuan_id");
        if (!$this->satuan_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satuan_id->Visible = false; // Disable update for API request
            } else {
                $this->satuan_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'satuan_id2' first before field var 'x_satuan_id2'
        $val = $CurrentForm->hasValue("satuan_id2") ? $CurrentForm->getValue("satuan_id2") : $CurrentForm->getValue("x_satuan_id2");
        if (!$this->satuan_id2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->satuan_id2->Visible = false; // Disable update for API request
            } else {
                $this->satuan_id2->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'gudang_id' first before field var 'x_gudang_id'
        $val = $CurrentForm->hasValue("gudang_id") ? $CurrentForm->getValue("gudang_id") : $CurrentForm->getValue("x_gudang_id");
        if (!$this->gudang_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gudang_id->Visible = false; // Disable update for API request
            } else {
                $this->gudang_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minstok' first before field var 'x_minstok'
        $val = $CurrentForm->hasValue("minstok") ? $CurrentForm->getValue("minstok") : $CurrentForm->getValue("x_minstok");
        if (!$this->minstok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minstok->Visible = false; // Disable update for API request
            } else {
                $this->minstok->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'minorder' first before field var 'x_minorder'
        $val = $CurrentForm->hasValue("minorder") ? $CurrentForm->getValue("minorder") : $CurrentForm->getValue("x_minorder");
        if (!$this->minorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->minorder->Visible = false; // Disable update for API request
            } else {
                $this->minorder->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'akunhpp' first before field var 'x_akunhpp'
        $val = $CurrentForm->hasValue("akunhpp") ? $CurrentForm->getValue("akunhpp") : $CurrentForm->getValue("x_akunhpp");
        if (!$this->akunhpp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->akunhpp->Visible = false; // Disable update for API request
            } else {
                $this->akunhpp->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'akunjual' first before field var 'x_akunjual'
        $val = $CurrentForm->hasValue("akunjual") ? $CurrentForm->getValue("akunjual") : $CurrentForm->getValue("x_akunjual");
        if (!$this->akunjual->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->akunjual->Visible = false; // Disable update for API request
            } else {
                $this->akunjual->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'akunpersediaan' first before field var 'x_akunpersediaan'
        $val = $CurrentForm->hasValue("akunpersediaan") ? $CurrentForm->getValue("akunpersediaan") : $CurrentForm->getValue("x_akunpersediaan");
        if (!$this->akunpersediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->akunpersediaan->Visible = false; // Disable update for API request
            } else {
                $this->akunpersediaan->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'akunreturjual' first before field var 'x_akunreturjual'
        $val = $CurrentForm->hasValue("akunreturjual") ? $CurrentForm->getValue("akunreturjual") : $CurrentForm->getValue("x_akunreturjual");
        if (!$this->akunreturjual->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->akunreturjual->Visible = false; // Disable update for API request
            } else {
                $this->akunreturjual->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'hargapokok' first before field var 'x_hargapokok'
        $val = $CurrentForm->hasValue("hargapokok") ? $CurrentForm->getValue("hargapokok") : $CurrentForm->getValue("x_hargapokok");
        if (!$this->hargapokok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hargapokok->Visible = false; // Disable update for API request
            } else {
                $this->hargapokok->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'p' first before field var 'x_p'
        $val = $CurrentForm->hasValue("p") ? $CurrentForm->getValue("p") : $CurrentForm->getValue("x_p");
        if (!$this->p->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->p->Visible = false; // Disable update for API request
            } else {
                $this->p->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'l' first before field var 'x_l'
        $val = $CurrentForm->hasValue("l") ? $CurrentForm->getValue("l") : $CurrentForm->getValue("x_l");
        if (!$this->l->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->l->Visible = false; // Disable update for API request
            } else {
                $this->l->setFormValue($val, true, $validate);
            }
        }

        // Check field name '_t' first before field var 'x__t'
        $val = $CurrentForm->hasValue("_t") ? $CurrentForm->getValue("_t") : $CurrentForm->getValue("x__t");
        if (!$this->_t->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_t->Visible = false; // Disable update for API request
            } else {
                $this->_t->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'berat' first before field var 'x_berat'
        $val = $CurrentForm->hasValue("berat") ? $CurrentForm->getValue("berat") : $CurrentForm->getValue("x_berat");
        if (!$this->berat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->berat->Visible = false; // Disable update for API request
            } else {
                $this->berat->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'supplier_id' first before field var 'x_supplier_id'
        $val = $CurrentForm->hasValue("supplier_id") ? $CurrentForm->getValue("supplier_id") : $CurrentForm->getValue("x_supplier_id");
        if (!$this->supplier_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->supplier_id->Visible = false; // Disable update for API request
            } else {
                $this->supplier_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'waktukirim' first before field var 'x_waktukirim'
        $val = $CurrentForm->hasValue("waktukirim") ? $CurrentForm->getValue("waktukirim") : $CurrentForm->getValue("x_waktukirim");
        if (!$this->waktukirim->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->waktukirim->Visible = false; // Disable update for API request
            } else {
                $this->waktukirim->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'aktif' first before field var 'x_aktif'
        $val = $CurrentForm->hasValue("aktif") ? $CurrentForm->getValue("aktif") : $CurrentForm->getValue("x_aktif");
        if (!$this->aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aktif->Visible = false; // Disable update for API request
            } else {
                $this->aktif->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id_FK' first before field var 'x_id_FK'
        $val = $CurrentForm->hasValue("id_FK") ? $CurrentForm->getValue("id_FK") : $CurrentForm->getValue("x_id_FK");
        if (!$this->id_FK->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_FK->Visible = false; // Disable update for API request
            } else {
                $this->id_FK->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->kelompok_id->CurrentValue = $this->kelompok_id->FormValue;
        $this->satuan_id->CurrentValue = $this->satuan_id->FormValue;
        $this->satuan_id2->CurrentValue = $this->satuan_id2->FormValue;
        $this->gudang_id->CurrentValue = $this->gudang_id->FormValue;
        $this->minstok->CurrentValue = $this->minstok->FormValue;
        $this->minorder->CurrentValue = $this->minorder->FormValue;
        $this->akunhpp->CurrentValue = $this->akunhpp->FormValue;
        $this->akunjual->CurrentValue = $this->akunjual->FormValue;
        $this->akunpersediaan->CurrentValue = $this->akunpersediaan->FormValue;
        $this->akunreturjual->CurrentValue = $this->akunreturjual->FormValue;
        $this->hargapokok->CurrentValue = $this->hargapokok->FormValue;
        $this->p->CurrentValue = $this->p->FormValue;
        $this->l->CurrentValue = $this->l->FormValue;
        $this->_t->CurrentValue = $this->_t->FormValue;
        $this->berat->CurrentValue = $this->berat->FormValue;
        $this->supplier_id->CurrentValue = $this->supplier_id->FormValue;
        $this->waktukirim->CurrentValue = $this->waktukirim->FormValue;
        $this->aktif->CurrentValue = $this->aktif->FormValue;
        $this->id_FK->CurrentValue = $this->id_FK->FormValue;
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

        // kode
        $this->kode->RowCssClass = "row";

        // nama
        $this->nama->RowCssClass = "row";

        // kelompok_id
        $this->kelompok_id->RowCssClass = "row";

        // satuan_id
        $this->satuan_id->RowCssClass = "row";

        // satuan_id2
        $this->satuan_id2->RowCssClass = "row";

        // gudang_id
        $this->gudang_id->RowCssClass = "row";

        // minstok
        $this->minstok->RowCssClass = "row";

        // minorder
        $this->minorder->RowCssClass = "row";

        // akunhpp
        $this->akunhpp->RowCssClass = "row";

        // akunjual
        $this->akunjual->RowCssClass = "row";

        // akunpersediaan
        $this->akunpersediaan->RowCssClass = "row";

        // akunreturjual
        $this->akunreturjual->RowCssClass = "row";

        // hargapokok
        $this->hargapokok->RowCssClass = "row";

        // p
        $this->p->RowCssClass = "row";

        // l
        $this->l->RowCssClass = "row";

        // t
        $this->_t->RowCssClass = "row";

        // berat
        $this->berat->RowCssClass = "row";

        // supplier_id
        $this->supplier_id->RowCssClass = "row";

        // waktukirim
        $this->waktukirim->RowCssClass = "row";

        // aktif
        $this->aktif->RowCssClass = "row";

        // id_FK
        $this->id_FK->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
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

            // kode
            $this->kode->HrefValue = "";

            // nama
            $this->nama->HrefValue = "";

            // kelompok_id
            $this->kelompok_id->HrefValue = "";

            // satuan_id
            $this->satuan_id->HrefValue = "";

            // satuan_id2
            $this->satuan_id2->HrefValue = "";

            // gudang_id
            $this->gudang_id->HrefValue = "";

            // minstok
            $this->minstok->HrefValue = "";

            // minorder
            $this->minorder->HrefValue = "";

            // akunhpp
            $this->akunhpp->HrefValue = "";

            // akunjual
            $this->akunjual->HrefValue = "";

            // akunpersediaan
            $this->akunpersediaan->HrefValue = "";

            // akunreturjual
            $this->akunreturjual->HrefValue = "";

            // hargapokok
            $this->hargapokok->HrefValue = "";

            // p
            $this->p->HrefValue = "";

            // l
            $this->l->HrefValue = "";

            // t
            $this->_t->HrefValue = "";

            // berat
            $this->berat->HrefValue = "";

            // supplier_id
            $this->supplier_id->HrefValue = "";

            // waktukirim
            $this->waktukirim->HrefValue = "";

            // aktif
            $this->aktif->HrefValue = "";

            // id_FK
            $this->id_FK->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // kode
            $this->kode->setupEditAttributes();
            if (!$this->kode->Raw) {
                $this->kode->CurrentValue = HtmlDecode($this->kode->CurrentValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->CurrentValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // nama
            $this->nama->setupEditAttributes();
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
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

            // Add refer script

            // kode
            $this->kode->HrefValue = "";

            // nama
            $this->nama->HrefValue = "";

            // kelompok_id
            $this->kelompok_id->HrefValue = "";

            // satuan_id
            $this->satuan_id->HrefValue = "";

            // satuan_id2
            $this->satuan_id2->HrefValue = "";

            // gudang_id
            $this->gudang_id->HrefValue = "";

            // minstok
            $this->minstok->HrefValue = "";

            // minorder
            $this->minorder->HrefValue = "";

            // akunhpp
            $this->akunhpp->HrefValue = "";

            // akunjual
            $this->akunjual->HrefValue = "";

            // akunpersediaan
            $this->akunpersediaan->HrefValue = "";

            // akunreturjual
            $this->akunreturjual->HrefValue = "";

            // hargapokok
            $this->hargapokok->HrefValue = "";

            // p
            $this->p->HrefValue = "";

            // l
            $this->l->HrefValue = "";

            // t
            $this->_t->HrefValue = "";

            // berat
            $this->berat->HrefValue = "";

            // supplier_id
            $this->supplier_id->HrefValue = "";

            // waktukirim
            $this->waktukirim->HrefValue = "";

            // aktif
            $this->aktif->HrefValue = "";

            // id_FK
            $this->id_FK->HrefValue = "";
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
            if ($this->kode->Visible && $this->kode->Required) {
                if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                    $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
                }
            }
            if ($this->nama->Visible && $this->nama->Required) {
                if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                    $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
                }
            }
            if ($this->kelompok_id->Visible && $this->kelompok_id->Required) {
                if (!$this->kelompok_id->IsDetailKey && EmptyValue($this->kelompok_id->FormValue)) {
                    $this->kelompok_id->addErrorMessage(str_replace("%s", $this->kelompok_id->caption(), $this->kelompok_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->kelompok_id->FormValue)) {
                $this->kelompok_id->addErrorMessage($this->kelompok_id->getErrorMessage(false));
            }
            if ($this->satuan_id->Visible && $this->satuan_id->Required) {
                if (!$this->satuan_id->IsDetailKey && EmptyValue($this->satuan_id->FormValue)) {
                    $this->satuan_id->addErrorMessage(str_replace("%s", $this->satuan_id->caption(), $this->satuan_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->satuan_id->FormValue)) {
                $this->satuan_id->addErrorMessage($this->satuan_id->getErrorMessage(false));
            }
            if ($this->satuan_id2->Visible && $this->satuan_id2->Required) {
                if (!$this->satuan_id2->IsDetailKey && EmptyValue($this->satuan_id2->FormValue)) {
                    $this->satuan_id2->addErrorMessage(str_replace("%s", $this->satuan_id2->caption(), $this->satuan_id2->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->satuan_id2->FormValue)) {
                $this->satuan_id2->addErrorMessage($this->satuan_id2->getErrorMessage(false));
            }
            if ($this->gudang_id->Visible && $this->gudang_id->Required) {
                if (!$this->gudang_id->IsDetailKey && EmptyValue($this->gudang_id->FormValue)) {
                    $this->gudang_id->addErrorMessage(str_replace("%s", $this->gudang_id->caption(), $this->gudang_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->gudang_id->FormValue)) {
                $this->gudang_id->addErrorMessage($this->gudang_id->getErrorMessage(false));
            }
            if ($this->minstok->Visible && $this->minstok->Required) {
                if (!$this->minstok->IsDetailKey && EmptyValue($this->minstok->FormValue)) {
                    $this->minstok->addErrorMessage(str_replace("%s", $this->minstok->caption(), $this->minstok->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->minstok->FormValue)) {
                $this->minstok->addErrorMessage($this->minstok->getErrorMessage(false));
            }
            if ($this->minorder->Visible && $this->minorder->Required) {
                if (!$this->minorder->IsDetailKey && EmptyValue($this->minorder->FormValue)) {
                    $this->minorder->addErrorMessage(str_replace("%s", $this->minorder->caption(), $this->minorder->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->minorder->FormValue)) {
                $this->minorder->addErrorMessage($this->minorder->getErrorMessage(false));
            }
            if ($this->akunhpp->Visible && $this->akunhpp->Required) {
                if (!$this->akunhpp->IsDetailKey && EmptyValue($this->akunhpp->FormValue)) {
                    $this->akunhpp->addErrorMessage(str_replace("%s", $this->akunhpp->caption(), $this->akunhpp->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->akunhpp->FormValue)) {
                $this->akunhpp->addErrorMessage($this->akunhpp->getErrorMessage(false));
            }
            if ($this->akunjual->Visible && $this->akunjual->Required) {
                if (!$this->akunjual->IsDetailKey && EmptyValue($this->akunjual->FormValue)) {
                    $this->akunjual->addErrorMessage(str_replace("%s", $this->akunjual->caption(), $this->akunjual->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->akunjual->FormValue)) {
                $this->akunjual->addErrorMessage($this->akunjual->getErrorMessage(false));
            }
            if ($this->akunpersediaan->Visible && $this->akunpersediaan->Required) {
                if (!$this->akunpersediaan->IsDetailKey && EmptyValue($this->akunpersediaan->FormValue)) {
                    $this->akunpersediaan->addErrorMessage(str_replace("%s", $this->akunpersediaan->caption(), $this->akunpersediaan->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->akunpersediaan->FormValue)) {
                $this->akunpersediaan->addErrorMessage($this->akunpersediaan->getErrorMessage(false));
            }
            if ($this->akunreturjual->Visible && $this->akunreturjual->Required) {
                if (!$this->akunreturjual->IsDetailKey && EmptyValue($this->akunreturjual->FormValue)) {
                    $this->akunreturjual->addErrorMessage(str_replace("%s", $this->akunreturjual->caption(), $this->akunreturjual->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->akunreturjual->FormValue)) {
                $this->akunreturjual->addErrorMessage($this->akunreturjual->getErrorMessage(false));
            }
            if ($this->hargapokok->Visible && $this->hargapokok->Required) {
                if (!$this->hargapokok->IsDetailKey && EmptyValue($this->hargapokok->FormValue)) {
                    $this->hargapokok->addErrorMessage(str_replace("%s", $this->hargapokok->caption(), $this->hargapokok->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->hargapokok->FormValue)) {
                $this->hargapokok->addErrorMessage($this->hargapokok->getErrorMessage(false));
            }
            if ($this->p->Visible && $this->p->Required) {
                if (!$this->p->IsDetailKey && EmptyValue($this->p->FormValue)) {
                    $this->p->addErrorMessage(str_replace("%s", $this->p->caption(), $this->p->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->p->FormValue)) {
                $this->p->addErrorMessage($this->p->getErrorMessage(false));
            }
            if ($this->l->Visible && $this->l->Required) {
                if (!$this->l->IsDetailKey && EmptyValue($this->l->FormValue)) {
                    $this->l->addErrorMessage(str_replace("%s", $this->l->caption(), $this->l->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->l->FormValue)) {
                $this->l->addErrorMessage($this->l->getErrorMessage(false));
            }
            if ($this->_t->Visible && $this->_t->Required) {
                if (!$this->_t->IsDetailKey && EmptyValue($this->_t->FormValue)) {
                    $this->_t->addErrorMessage(str_replace("%s", $this->_t->caption(), $this->_t->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->_t->FormValue)) {
                $this->_t->addErrorMessage($this->_t->getErrorMessage(false));
            }
            if ($this->berat->Visible && $this->berat->Required) {
                if (!$this->berat->IsDetailKey && EmptyValue($this->berat->FormValue)) {
                    $this->berat->addErrorMessage(str_replace("%s", $this->berat->caption(), $this->berat->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->berat->FormValue)) {
                $this->berat->addErrorMessage($this->berat->getErrorMessage(false));
            }
            if ($this->supplier_id->Visible && $this->supplier_id->Required) {
                if (!$this->supplier_id->IsDetailKey && EmptyValue($this->supplier_id->FormValue)) {
                    $this->supplier_id->addErrorMessage(str_replace("%s", $this->supplier_id->caption(), $this->supplier_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->supplier_id->FormValue)) {
                $this->supplier_id->addErrorMessage($this->supplier_id->getErrorMessage(false));
            }
            if ($this->waktukirim->Visible && $this->waktukirim->Required) {
                if (!$this->waktukirim->IsDetailKey && EmptyValue($this->waktukirim->FormValue)) {
                    $this->waktukirim->addErrorMessage(str_replace("%s", $this->waktukirim->caption(), $this->waktukirim->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->waktukirim->FormValue)) {
                $this->waktukirim->addErrorMessage($this->waktukirim->getErrorMessage(false));
            }
            if ($this->aktif->Visible && $this->aktif->Required) {
                if (!$this->aktif->IsDetailKey && EmptyValue($this->aktif->FormValue)) {
                    $this->aktif->addErrorMessage(str_replace("%s", $this->aktif->caption(), $this->aktif->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->aktif->FormValue)) {
                $this->aktif->addErrorMessage($this->aktif->getErrorMessage(false));
            }
            if ($this->id_FK->Visible && $this->id_FK->Required) {
                if (!$this->id_FK->IsDetailKey && EmptyValue($this->id_FK->FormValue)) {
                    $this->id_FK->addErrorMessage(str_replace("%s", $this->id_FK->caption(), $this->id_FK->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->id_FK->FormValue)) {
                $this->id_FK->addErrorMessage($this->id_FK->getErrorMessage(false));
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

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, false);

        // kelompok_id
        $this->kelompok_id->setDbValueDef($rsnew, $this->kelompok_id->CurrentValue, false);

        // satuan_id
        $this->satuan_id->setDbValueDef($rsnew, $this->satuan_id->CurrentValue, false);

        // satuan_id2
        $this->satuan_id2->setDbValueDef($rsnew, $this->satuan_id2->CurrentValue, false);

        // gudang_id
        $this->gudang_id->setDbValueDef($rsnew, $this->gudang_id->CurrentValue, false);

        // minstok
        $this->minstok->setDbValueDef($rsnew, $this->minstok->CurrentValue, false);

        // minorder
        $this->minorder->setDbValueDef($rsnew, $this->minorder->CurrentValue, false);

        // akunhpp
        $this->akunhpp->setDbValueDef($rsnew, $this->akunhpp->CurrentValue, false);

        // akunjual
        $this->akunjual->setDbValueDef($rsnew, $this->akunjual->CurrentValue, false);

        // akunpersediaan
        $this->akunpersediaan->setDbValueDef($rsnew, $this->akunpersediaan->CurrentValue, false);

        // akunreturjual
        $this->akunreturjual->setDbValueDef($rsnew, $this->akunreturjual->CurrentValue, false);

        // hargapokok
        $this->hargapokok->setDbValueDef($rsnew, $this->hargapokok->CurrentValue, false);

        // p
        $this->p->setDbValueDef($rsnew, $this->p->CurrentValue, false);

        // l
        $this->l->setDbValueDef($rsnew, $this->l->CurrentValue, false);

        // t
        $this->_t->setDbValueDef($rsnew, $this->_t->CurrentValue, false);

        // berat
        $this->berat->setDbValueDef($rsnew, $this->berat->CurrentValue, false);

        // supplier_id
        $this->supplier_id->setDbValueDef($rsnew, $this->supplier_id->CurrentValue, false);

        // waktukirim
        $this->waktukirim->setDbValueDef($rsnew, $this->waktukirim->CurrentValue, false);

        // aktif
        $this->aktif->setDbValueDef($rsnew, $this->aktif->CurrentValue, false);

        // id_FK
        $this->id_FK->setDbValueDef($rsnew, $this->id_FK->CurrentValue, strval($this->id_FK->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['kode'])) { // kode
            $this->kode->setFormValue($row['kode']);
        }
        if (isset($row['nama'])) { // nama
            $this->nama->setFormValue($row['nama']);
        }
        if (isset($row['kelompok_id'])) { // kelompok_id
            $this->kelompok_id->setFormValue($row['kelompok_id']);
        }
        if (isset($row['satuan_id'])) { // satuan_id
            $this->satuan_id->setFormValue($row['satuan_id']);
        }
        if (isset($row['satuan_id2'])) { // satuan_id2
            $this->satuan_id2->setFormValue($row['satuan_id2']);
        }
        if (isset($row['gudang_id'])) { // gudang_id
            $this->gudang_id->setFormValue($row['gudang_id']);
        }
        if (isset($row['minstok'])) { // minstok
            $this->minstok->setFormValue($row['minstok']);
        }
        if (isset($row['minorder'])) { // minorder
            $this->minorder->setFormValue($row['minorder']);
        }
        if (isset($row['akunhpp'])) { // akunhpp
            $this->akunhpp->setFormValue($row['akunhpp']);
        }
        if (isset($row['akunjual'])) { // akunjual
            $this->akunjual->setFormValue($row['akunjual']);
        }
        if (isset($row['akunpersediaan'])) { // akunpersediaan
            $this->akunpersediaan->setFormValue($row['akunpersediaan']);
        }
        if (isset($row['akunreturjual'])) { // akunreturjual
            $this->akunreturjual->setFormValue($row['akunreturjual']);
        }
        if (isset($row['hargapokok'])) { // hargapokok
            $this->hargapokok->setFormValue($row['hargapokok']);
        }
        if (isset($row['p'])) { // p
            $this->p->setFormValue($row['p']);
        }
        if (isset($row['l'])) { // l
            $this->l->setFormValue($row['l']);
        }
        if (isset($row['t'])) { // t
            $this->_t->setFormValue($row['t']);
        }
        if (isset($row['berat'])) { // berat
            $this->berat->setFormValue($row['berat']);
        }
        if (isset($row['supplier_id'])) { // supplier_id
            $this->supplier_id->setFormValue($row['supplier_id']);
        }
        if (isset($row['waktukirim'])) { // waktukirim
            $this->waktukirim->setFormValue($row['waktukirim']);
        }
        if (isset($row['aktif'])) { // aktif
            $this->aktif->setFormValue($row['aktif']);
        }
        if (isset($row['id_FK'])) { // id_FK
            $this->id_FK->setFormValue($row['id_FK']);
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("produklist"), "", $this->TableVar, true);
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
