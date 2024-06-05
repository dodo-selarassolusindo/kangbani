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
class PersonEdit extends Person
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "PersonEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "personedit";

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
        $this->id->setVisibility();
        $this->kode->setVisibility();
        $this->nama->setVisibility();
        $this->kontak->setVisibility();
        $this->type_id->setVisibility();
        $this->telp1->setVisibility();
        $this->matauang_id->setVisibility();
        $this->_username->setVisibility();
        $this->_password->setVisibility();
        $this->telp2->setVisibility();
        $this->fax->setVisibility();
        $this->hp->setVisibility();
        $this->_email->setVisibility();
        $this->website->setVisibility();
        $this->npwp->setVisibility();
        $this->alamat->setVisibility();
        $this->kota->setVisibility();
        $this->zip->setVisibility();
        $this->klasifikasi_id->setVisibility();
        $this->id_FK->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer;
        $this->TableVar = 'person';
        $this->TableName = 'person';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (person)
        if (!isset($GLOBALS["person"]) || $GLOBALS["person"]::class == PROJECT_NAMESPACE . "person") {
            $GLOBALS["person"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'person');
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
                        $result["view"] = SameString($pageName, "personview"); // If View page, no primary button
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Load result set
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("personlist"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl();
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        if ($this->id->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->id->CurrentValue, $this->CurrentRow['id'])) {
                                    $this->setStartRecordNumber($this->StartRecord); // Save record position
                                    $loaded = true;
                                    break;
                                } else {
                                    $this->StartRecord++;
                                }
                            }
                        }
                    }

                    // Load current row values
                    if ($loaded) {
                        $this->loadRowValues($this->CurrentRow);
                    }
                } else {
                    // Load current record
                    $loaded = $this->loadRow();
                } // End modal checking
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal edit page
                    if (!$loaded) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("personlist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("personlist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "personlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "personlist") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "personlist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

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

        // Check field name 'kontak' first before field var 'x_kontak'
        $val = $CurrentForm->hasValue("kontak") ? $CurrentForm->getValue("kontak") : $CurrentForm->getValue("x_kontak");
        if (!$this->kontak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kontak->Visible = false; // Disable update for API request
            } else {
                $this->kontak->setFormValue($val);
            }
        }

        // Check field name 'type_id' first before field var 'x_type_id'
        $val = $CurrentForm->hasValue("type_id") ? $CurrentForm->getValue("type_id") : $CurrentForm->getValue("x_type_id");
        if (!$this->type_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type_id->Visible = false; // Disable update for API request
            } else {
                $this->type_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'telp1' first before field var 'x_telp1'
        $val = $CurrentForm->hasValue("telp1") ? $CurrentForm->getValue("telp1") : $CurrentForm->getValue("x_telp1");
        if (!$this->telp1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telp1->Visible = false; // Disable update for API request
            } else {
                $this->telp1->setFormValue($val);
            }
        }

        // Check field name 'matauang_id' first before field var 'x_matauang_id'
        $val = $CurrentForm->hasValue("matauang_id") ? $CurrentForm->getValue("matauang_id") : $CurrentForm->getValue("x_matauang_id");
        if (!$this->matauang_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->matauang_id->Visible = false; // Disable update for API request
            } else {
                $this->matauang_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'username' first before field var 'x__username'
        $val = $CurrentForm->hasValue("username") ? $CurrentForm->getValue("username") : $CurrentForm->getValue("x__username");
        if (!$this->_username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_username->Visible = false; // Disable update for API request
            } else {
                $this->_username->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'telp2' first before field var 'x_telp2'
        $val = $CurrentForm->hasValue("telp2") ? $CurrentForm->getValue("telp2") : $CurrentForm->getValue("x_telp2");
        if (!$this->telp2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telp2->Visible = false; // Disable update for API request
            } else {
                $this->telp2->setFormValue($val);
            }
        }

        // Check field name 'fax' first before field var 'x_fax'
        $val = $CurrentForm->hasValue("fax") ? $CurrentForm->getValue("fax") : $CurrentForm->getValue("x_fax");
        if (!$this->fax->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fax->Visible = false; // Disable update for API request
            } else {
                $this->fax->setFormValue($val);
            }
        }

        // Check field name 'hp' first before field var 'x_hp'
        $val = $CurrentForm->hasValue("hp") ? $CurrentForm->getValue("hp") : $CurrentForm->getValue("x_hp");
        if (!$this->hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hp->Visible = false; // Disable update for API request
            } else {
                $this->hp->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'npwp' first before field var 'x_npwp'
        $val = $CurrentForm->hasValue("npwp") ? $CurrentForm->getValue("npwp") : $CurrentForm->getValue("x_npwp");
        if (!$this->npwp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->npwp->Visible = false; // Disable update for API request
            } else {
                $this->npwp->setFormValue($val);
            }
        }

        // Check field name 'alamat' first before field var 'x_alamat'
        $val = $CurrentForm->hasValue("alamat") ? $CurrentForm->getValue("alamat") : $CurrentForm->getValue("x_alamat");
        if (!$this->alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamat->Visible = false; // Disable update for API request
            } else {
                $this->alamat->setFormValue($val);
            }
        }

        // Check field name 'kota' first before field var 'x_kota'
        $val = $CurrentForm->hasValue("kota") ? $CurrentForm->getValue("kota") : $CurrentForm->getValue("x_kota");
        if (!$this->kota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kota->Visible = false; // Disable update for API request
            } else {
                $this->kota->setFormValue($val);
            }
        }

        // Check field name 'zip' first before field var 'x_zip'
        $val = $CurrentForm->hasValue("zip") ? $CurrentForm->getValue("zip") : $CurrentForm->getValue("x_zip");
        if (!$this->zip->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->zip->Visible = false; // Disable update for API request
            } else {
                $this->zip->setFormValue($val);
            }
        }

        // Check field name 'klasifikasi_id' first before field var 'x_klasifikasi_id'
        $val = $CurrentForm->hasValue("klasifikasi_id") ? $CurrentForm->getValue("klasifikasi_id") : $CurrentForm->getValue("x_klasifikasi_id");
        if (!$this->klasifikasi_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->klasifikasi_id->Visible = false; // Disable update for API request
            } else {
                $this->klasifikasi_id->setFormValue($val, true, $validate);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->kontak->CurrentValue = $this->kontak->FormValue;
        $this->type_id->CurrentValue = $this->type_id->FormValue;
        $this->telp1->CurrentValue = $this->telp1->FormValue;
        $this->matauang_id->CurrentValue = $this->matauang_id->FormValue;
        $this->_username->CurrentValue = $this->_username->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->telp2->CurrentValue = $this->telp2->FormValue;
        $this->fax->CurrentValue = $this->fax->FormValue;
        $this->hp->CurrentValue = $this->hp->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->npwp->CurrentValue = $this->npwp->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->kota->CurrentValue = $this->kota->FormValue;
        $this->zip->CurrentValue = $this->zip->FormValue;
        $this->klasifikasi_id->CurrentValue = $this->klasifikasi_id->FormValue;
        $this->id_FK->CurrentValue = $this->id_FK->FormValue;
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
        $this->kontak->setDbValue($row['kontak']);
        $this->type_id->setDbValue($row['type_id']);
        $this->telp1->setDbValue($row['telp1']);
        $this->matauang_id->setDbValue($row['matauang_id']);
        $this->_username->setDbValue($row['username']);
        $this->_password->setDbValue($row['password']);
        $this->telp2->setDbValue($row['telp2']);
        $this->fax->setDbValue($row['fax']);
        $this->hp->setDbValue($row['hp']);
        $this->_email->setDbValue($row['email']);
        $this->website->setDbValue($row['website']);
        $this->npwp->setDbValue($row['npwp']);
        $this->alamat->setDbValue($row['alamat']);
        $this->kota->setDbValue($row['kota']);
        $this->zip->setDbValue($row['zip']);
        $this->klasifikasi_id->setDbValue($row['klasifikasi_id']);
        $this->id_FK->setDbValue($row['id_FK']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['kode'] = $this->kode->DefaultValue;
        $row['nama'] = $this->nama->DefaultValue;
        $row['kontak'] = $this->kontak->DefaultValue;
        $row['type_id'] = $this->type_id->DefaultValue;
        $row['telp1'] = $this->telp1->DefaultValue;
        $row['matauang_id'] = $this->matauang_id->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['password'] = $this->_password->DefaultValue;
        $row['telp2'] = $this->telp2->DefaultValue;
        $row['fax'] = $this->fax->DefaultValue;
        $row['hp'] = $this->hp->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['website'] = $this->website->DefaultValue;
        $row['npwp'] = $this->npwp->DefaultValue;
        $row['alamat'] = $this->alamat->DefaultValue;
        $row['kota'] = $this->kota->DefaultValue;
        $row['zip'] = $this->zip->DefaultValue;
        $row['klasifikasi_id'] = $this->klasifikasi_id->DefaultValue;
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

        // kontak
        $this->kontak->RowCssClass = "row";

        // type_id
        $this->type_id->RowCssClass = "row";

        // telp1
        $this->telp1->RowCssClass = "row";

        // matauang_id
        $this->matauang_id->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // password
        $this->_password->RowCssClass = "row";

        // telp2
        $this->telp2->RowCssClass = "row";

        // fax
        $this->fax->RowCssClass = "row";

        // hp
        $this->hp->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // website
        $this->website->RowCssClass = "row";

        // npwp
        $this->npwp->RowCssClass = "row";

        // alamat
        $this->alamat->RowCssClass = "row";

        // kota
        $this->kota->RowCssClass = "row";

        // zip
        $this->zip->RowCssClass = "row";

        // klasifikasi_id
        $this->klasifikasi_id->RowCssClass = "row";

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

            // kontak
            $this->kontak->ViewValue = $this->kontak->CurrentValue;

            // type_id
            $this->type_id->ViewValue = $this->type_id->CurrentValue;
            $this->type_id->ViewValue = FormatNumber($this->type_id->ViewValue, $this->type_id->formatPattern());

            // telp1
            $this->telp1->ViewValue = $this->telp1->CurrentValue;

            // matauang_id
            $this->matauang_id->ViewValue = $this->matauang_id->CurrentValue;
            $this->matauang_id->ViewValue = FormatNumber($this->matauang_id->ViewValue, $this->matauang_id->formatPattern());

            // username
            $this->_username->ViewValue = $this->_username->CurrentValue;

            // password
            $this->_password->ViewValue = $this->_password->CurrentValue;

            // telp2
            $this->telp2->ViewValue = $this->telp2->CurrentValue;

            // fax
            $this->fax->ViewValue = $this->fax->CurrentValue;

            // hp
            $this->hp->ViewValue = $this->hp->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // website
            $this->website->ViewValue = $this->website->CurrentValue;

            // npwp
            $this->npwp->ViewValue = $this->npwp->CurrentValue;

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;

            // kota
            $this->kota->ViewValue = $this->kota->CurrentValue;

            // zip
            $this->zip->ViewValue = $this->zip->CurrentValue;

            // klasifikasi_id
            $this->klasifikasi_id->ViewValue = $this->klasifikasi_id->CurrentValue;
            $this->klasifikasi_id->ViewValue = FormatNumber($this->klasifikasi_id->ViewValue, $this->klasifikasi_id->formatPattern());

            // id_FK
            $this->id_FK->ViewValue = $this->id_FK->CurrentValue;
            $this->id_FK->ViewValue = FormatNumber($this->id_FK->ViewValue, $this->id_FK->formatPattern());

            // id
            $this->id->HrefValue = "";

            // kode
            $this->kode->HrefValue = "";

            // nama
            $this->nama->HrefValue = "";

            // kontak
            $this->kontak->HrefValue = "";

            // type_id
            $this->type_id->HrefValue = "";

            // telp1
            $this->telp1->HrefValue = "";

            // matauang_id
            $this->matauang_id->HrefValue = "";

            // username
            $this->_username->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // telp2
            $this->telp2->HrefValue = "";

            // fax
            $this->fax->HrefValue = "";

            // hp
            $this->hp->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // website
            $this->website->HrefValue = "";

            // npwp
            $this->npwp->HrefValue = "";

            // alamat
            $this->alamat->HrefValue = "";

            // kota
            $this->kota->HrefValue = "";

            // zip
            $this->zip->HrefValue = "";

            // klasifikasi_id
            $this->klasifikasi_id->HrefValue = "";

            // id_FK
            $this->id_FK->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->CurrentValue;

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

            // kontak
            $this->kontak->setupEditAttributes();
            if (!$this->kontak->Raw) {
                $this->kontak->CurrentValue = HtmlDecode($this->kontak->CurrentValue);
            }
            $this->kontak->EditValue = HtmlEncode($this->kontak->CurrentValue);
            $this->kontak->PlaceHolder = RemoveHtml($this->kontak->caption());

            // type_id
            $this->type_id->setupEditAttributes();
            $this->type_id->EditValue = $this->type_id->CurrentValue;
            $this->type_id->PlaceHolder = RemoveHtml($this->type_id->caption());
            if (strval($this->type_id->EditValue) != "" && is_numeric($this->type_id->EditValue)) {
                $this->type_id->EditValue = FormatNumber($this->type_id->EditValue, null);
            }

            // telp1
            $this->telp1->setupEditAttributes();
            if (!$this->telp1->Raw) {
                $this->telp1->CurrentValue = HtmlDecode($this->telp1->CurrentValue);
            }
            $this->telp1->EditValue = HtmlEncode($this->telp1->CurrentValue);
            $this->telp1->PlaceHolder = RemoveHtml($this->telp1->caption());

            // matauang_id
            $this->matauang_id->setupEditAttributes();
            $this->matauang_id->EditValue = $this->matauang_id->CurrentValue;
            $this->matauang_id->PlaceHolder = RemoveHtml($this->matauang_id->caption());
            if (strval($this->matauang_id->EditValue) != "" && is_numeric($this->matauang_id->EditValue)) {
                $this->matauang_id->EditValue = FormatNumber($this->matauang_id->EditValue, null);
            }

            // username
            $this->_username->setupEditAttributes();
            if (!$this->_username->Raw) {
                $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
            }
            $this->_username->EditValue = HtmlEncode($this->_username->CurrentValue);
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // password
            $this->_password->setupEditAttributes();
            if (!$this->_password->Raw) {
                $this->_password->CurrentValue = HtmlDecode($this->_password->CurrentValue);
            }
            $this->_password->EditValue = HtmlEncode($this->_password->CurrentValue);
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // telp2
            $this->telp2->setupEditAttributes();
            if (!$this->telp2->Raw) {
                $this->telp2->CurrentValue = HtmlDecode($this->telp2->CurrentValue);
            }
            $this->telp2->EditValue = HtmlEncode($this->telp2->CurrentValue);
            $this->telp2->PlaceHolder = RemoveHtml($this->telp2->caption());

            // fax
            $this->fax->setupEditAttributes();
            if (!$this->fax->Raw) {
                $this->fax->CurrentValue = HtmlDecode($this->fax->CurrentValue);
            }
            $this->fax->EditValue = HtmlEncode($this->fax->CurrentValue);
            $this->fax->PlaceHolder = RemoveHtml($this->fax->caption());

            // hp
            $this->hp->setupEditAttributes();
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // website
            $this->website->setupEditAttributes();
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // npwp
            $this->npwp->setupEditAttributes();
            if (!$this->npwp->Raw) {
                $this->npwp->CurrentValue = HtmlDecode($this->npwp->CurrentValue);
            }
            $this->npwp->EditValue = HtmlEncode($this->npwp->CurrentValue);
            $this->npwp->PlaceHolder = RemoveHtml($this->npwp->caption());

            // alamat
            $this->alamat->setupEditAttributes();
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // kota
            $this->kota->setupEditAttributes();
            if (!$this->kota->Raw) {
                $this->kota->CurrentValue = HtmlDecode($this->kota->CurrentValue);
            }
            $this->kota->EditValue = HtmlEncode($this->kota->CurrentValue);
            $this->kota->PlaceHolder = RemoveHtml($this->kota->caption());

            // zip
            $this->zip->setupEditAttributes();
            if (!$this->zip->Raw) {
                $this->zip->CurrentValue = HtmlDecode($this->zip->CurrentValue);
            }
            $this->zip->EditValue = HtmlEncode($this->zip->CurrentValue);
            $this->zip->PlaceHolder = RemoveHtml($this->zip->caption());

            // klasifikasi_id
            $this->klasifikasi_id->setupEditAttributes();
            $this->klasifikasi_id->EditValue = $this->klasifikasi_id->CurrentValue;
            $this->klasifikasi_id->PlaceHolder = RemoveHtml($this->klasifikasi_id->caption());
            if (strval($this->klasifikasi_id->EditValue) != "" && is_numeric($this->klasifikasi_id->EditValue)) {
                $this->klasifikasi_id->EditValue = FormatNumber($this->klasifikasi_id->EditValue, null);
            }

            // id_FK
            $this->id_FK->setupEditAttributes();
            $this->id_FK->EditValue = $this->id_FK->CurrentValue;
            $this->id_FK->PlaceHolder = RemoveHtml($this->id_FK->caption());
            if (strval($this->id_FK->EditValue) != "" && is_numeric($this->id_FK->EditValue)) {
                $this->id_FK->EditValue = FormatNumber($this->id_FK->EditValue, null);
            }

            // Edit refer script

            // id
            $this->id->HrefValue = "";

            // kode
            $this->kode->HrefValue = "";

            // nama
            $this->nama->HrefValue = "";

            // kontak
            $this->kontak->HrefValue = "";

            // type_id
            $this->type_id->HrefValue = "";

            // telp1
            $this->telp1->HrefValue = "";

            // matauang_id
            $this->matauang_id->HrefValue = "";

            // username
            $this->_username->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // telp2
            $this->telp2->HrefValue = "";

            // fax
            $this->fax->HrefValue = "";

            // hp
            $this->hp->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // website
            $this->website->HrefValue = "";

            // npwp
            $this->npwp->HrefValue = "";

            // alamat
            $this->alamat->HrefValue = "";

            // kota
            $this->kota->HrefValue = "";

            // zip
            $this->zip->HrefValue = "";

            // klasifikasi_id
            $this->klasifikasi_id->HrefValue = "";

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
            if ($this->id->Visible && $this->id->Required) {
                if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                    $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
                }
            }
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
            if ($this->kontak->Visible && $this->kontak->Required) {
                if (!$this->kontak->IsDetailKey && EmptyValue($this->kontak->FormValue)) {
                    $this->kontak->addErrorMessage(str_replace("%s", $this->kontak->caption(), $this->kontak->RequiredErrorMessage));
                }
            }
            if ($this->type_id->Visible && $this->type_id->Required) {
                if (!$this->type_id->IsDetailKey && EmptyValue($this->type_id->FormValue)) {
                    $this->type_id->addErrorMessage(str_replace("%s", $this->type_id->caption(), $this->type_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->type_id->FormValue)) {
                $this->type_id->addErrorMessage($this->type_id->getErrorMessage(false));
            }
            if ($this->telp1->Visible && $this->telp1->Required) {
                if (!$this->telp1->IsDetailKey && EmptyValue($this->telp1->FormValue)) {
                    $this->telp1->addErrorMessage(str_replace("%s", $this->telp1->caption(), $this->telp1->RequiredErrorMessage));
                }
            }
            if ($this->matauang_id->Visible && $this->matauang_id->Required) {
                if (!$this->matauang_id->IsDetailKey && EmptyValue($this->matauang_id->FormValue)) {
                    $this->matauang_id->addErrorMessage(str_replace("%s", $this->matauang_id->caption(), $this->matauang_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->matauang_id->FormValue)) {
                $this->matauang_id->addErrorMessage($this->matauang_id->getErrorMessage(false));
            }
            if ($this->_username->Visible && $this->_username->Required) {
                if (!$this->_username->IsDetailKey && EmptyValue($this->_username->FormValue)) {
                    $this->_username->addErrorMessage(str_replace("%s", $this->_username->caption(), $this->_username->RequiredErrorMessage));
                }
            }
            if ($this->_password->Visible && $this->_password->Required) {
                if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                    $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
                }
            }
            if ($this->telp2->Visible && $this->telp2->Required) {
                if (!$this->telp2->IsDetailKey && EmptyValue($this->telp2->FormValue)) {
                    $this->telp2->addErrorMessage(str_replace("%s", $this->telp2->caption(), $this->telp2->RequiredErrorMessage));
                }
            }
            if ($this->fax->Visible && $this->fax->Required) {
                if (!$this->fax->IsDetailKey && EmptyValue($this->fax->FormValue)) {
                    $this->fax->addErrorMessage(str_replace("%s", $this->fax->caption(), $this->fax->RequiredErrorMessage));
                }
            }
            if ($this->hp->Visible && $this->hp->Required) {
                if (!$this->hp->IsDetailKey && EmptyValue($this->hp->FormValue)) {
                    $this->hp->addErrorMessage(str_replace("%s", $this->hp->caption(), $this->hp->RequiredErrorMessage));
                }
            }
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
                }
            }
            if ($this->website->Visible && $this->website->Required) {
                if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                    $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
                }
            }
            if ($this->npwp->Visible && $this->npwp->Required) {
                if (!$this->npwp->IsDetailKey && EmptyValue($this->npwp->FormValue)) {
                    $this->npwp->addErrorMessage(str_replace("%s", $this->npwp->caption(), $this->npwp->RequiredErrorMessage));
                }
            }
            if ($this->alamat->Visible && $this->alamat->Required) {
                if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                    $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
                }
            }
            if ($this->kota->Visible && $this->kota->Required) {
                if (!$this->kota->IsDetailKey && EmptyValue($this->kota->FormValue)) {
                    $this->kota->addErrorMessage(str_replace("%s", $this->kota->caption(), $this->kota->RequiredErrorMessage));
                }
            }
            if ($this->zip->Visible && $this->zip->Required) {
                if (!$this->zip->IsDetailKey && EmptyValue($this->zip->FormValue)) {
                    $this->zip->addErrorMessage(str_replace("%s", $this->zip->caption(), $this->zip->RequiredErrorMessage));
                }
            }
            if ($this->klasifikasi_id->Visible && $this->klasifikasi_id->Required) {
                if (!$this->klasifikasi_id->IsDetailKey && EmptyValue($this->klasifikasi_id->FormValue)) {
                    $this->klasifikasi_id->addErrorMessage(str_replace("%s", $this->klasifikasi_id->caption(), $this->klasifikasi_id->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->klasifikasi_id->FormValue)) {
                $this->klasifikasi_id->addErrorMessage($this->klasifikasi_id->getErrorMessage(false));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // kode
        $this->kode->setDbValueDef($rsnew, $this->kode->CurrentValue, $this->kode->ReadOnly);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, $this->nama->ReadOnly);

        // kontak
        $this->kontak->setDbValueDef($rsnew, $this->kontak->CurrentValue, $this->kontak->ReadOnly);

        // type_id
        $this->type_id->setDbValueDef($rsnew, $this->type_id->CurrentValue, $this->type_id->ReadOnly);

        // telp1
        $this->telp1->setDbValueDef($rsnew, $this->telp1->CurrentValue, $this->telp1->ReadOnly);

        // matauang_id
        $this->matauang_id->setDbValueDef($rsnew, $this->matauang_id->CurrentValue, $this->matauang_id->ReadOnly);

        // username
        $this->_username->setDbValueDef($rsnew, $this->_username->CurrentValue, $this->_username->ReadOnly);

        // password
        $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, $this->_password->ReadOnly);

        // telp2
        $this->telp2->setDbValueDef($rsnew, $this->telp2->CurrentValue, $this->telp2->ReadOnly);

        // fax
        $this->fax->setDbValueDef($rsnew, $this->fax->CurrentValue, $this->fax->ReadOnly);

        // hp
        $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, $this->hp->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // website
        $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, $this->website->ReadOnly);

        // npwp
        $this->npwp->setDbValueDef($rsnew, $this->npwp->CurrentValue, $this->npwp->ReadOnly);

        // alamat
        $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, $this->alamat->ReadOnly);

        // kota
        $this->kota->setDbValueDef($rsnew, $this->kota->CurrentValue, $this->kota->ReadOnly);

        // zip
        $this->zip->setDbValueDef($rsnew, $this->zip->CurrentValue, $this->zip->ReadOnly);

        // klasifikasi_id
        $this->klasifikasi_id->setDbValueDef($rsnew, $this->klasifikasi_id->CurrentValue, $this->klasifikasi_id->ReadOnly);

        // id_FK
        $this->id_FK->setDbValueDef($rsnew, $this->id_FK->CurrentValue, $this->id_FK->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['kode'])) { // kode
            $this->kode->CurrentValue = $row['kode'];
        }
        if (isset($row['nama'])) { // nama
            $this->nama->CurrentValue = $row['nama'];
        }
        if (isset($row['kontak'])) { // kontak
            $this->kontak->CurrentValue = $row['kontak'];
        }
        if (isset($row['type_id'])) { // type_id
            $this->type_id->CurrentValue = $row['type_id'];
        }
        if (isset($row['telp1'])) { // telp1
            $this->telp1->CurrentValue = $row['telp1'];
        }
        if (isset($row['matauang_id'])) { // matauang_id
            $this->matauang_id->CurrentValue = $row['matauang_id'];
        }
        if (isset($row['username'])) { // username
            $this->_username->CurrentValue = $row['username'];
        }
        if (isset($row['password'])) { // password
            $this->_password->CurrentValue = $row['password'];
        }
        if (isset($row['telp2'])) { // telp2
            $this->telp2->CurrentValue = $row['telp2'];
        }
        if (isset($row['fax'])) { // fax
            $this->fax->CurrentValue = $row['fax'];
        }
        if (isset($row['hp'])) { // hp
            $this->hp->CurrentValue = $row['hp'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
        }
        if (isset($row['website'])) { // website
            $this->website->CurrentValue = $row['website'];
        }
        if (isset($row['npwp'])) { // npwp
            $this->npwp->CurrentValue = $row['npwp'];
        }
        if (isset($row['alamat'])) { // alamat
            $this->alamat->CurrentValue = $row['alamat'];
        }
        if (isset($row['kota'])) { // kota
            $this->kota->CurrentValue = $row['kota'];
        }
        if (isset($row['zip'])) { // zip
            $this->zip->CurrentValue = $row['zip'];
        }
        if (isset($row['klasifikasi_id'])) { // klasifikasi_id
            $this->klasifikasi_id->CurrentValue = $row['klasifikasi_id'];
        }
        if (isset($row['id_FK'])) { // id_FK
            $this->id_FK->CurrentValue = $row['id_FK'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("personlist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
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
