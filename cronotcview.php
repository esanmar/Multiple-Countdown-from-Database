<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
define("EW_DEFAULT_LOCALE", "es_ES", TRUE);
@setlocale(LC_ALL, EW_DEFAULT_LOCALE);
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "cronotcinfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$cronotc_view = new ccronotc_view();
$Page =& $cronotc_view;

// Page init
$cronotc_view->Page_Init();

// Page main
$cronotc_view->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cronotc->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cronotc_view = new ew_Page("cronotc_view");

// page properties
cronotc_view.PageID = "view"; // page ID
cronotc_view.FormID = "fcronotcview"; // form ID
var EW_PAGE_ID = cronotc_view.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cronotc_view.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cronotc_view.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cronotc_view.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronotc_view.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<p><span class="phpmaker"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cronotc->TableCaption() ?>
<?php if ($cronotc->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $cronotc_view->ExportPrintUrl ?>"><?php echo $Language->Phrase("PrinterFriendly") ?></a>
&nbsp;&nbsp;<a href="<?php echo $cronotc_view->ExportExcelUrl ?>"><?php echo $Language->Phrase("ExportToExcel") ?></a>
&nbsp;&nbsp;<a href="<?php echo $cronotc_view->ExportWordUrl ?>"><?php echo $Language->Phrase("ExportToWord") ?></a>
<?php } ?>
<br><br>
<?php if ($cronotc->Export == "") { ?>
<a href="<?php echo $cronotc_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<a href="<?php echo $cronotc_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<a href="<?php echo $cronotc_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<a href="<?php echo $cronotc_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<a onclick="return ew_Confirm(ewLanguage.Phrase('DeleteConfirmMsg'));" href="<?php echo $cronotc_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
</span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$cronotc_view->ShowMessage();
?>
<p>
<?php if ($cronotc->Export == "") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cronotc_view->Pager)) $cronotc_view->Pager = new cPrevNextPager($cronotc_view->lStartRec, $cronotc_view->lDisplayRecs, $cronotc_view->lTotalRecs) ?>
<?php if ($cronotc_view->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cronotc_view->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_view->PageUrl() ?>start=<?php echo $cronotc_view->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cronotc_view->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_view->PageUrl() ?>start=<?php echo $cronotc_view->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cronotc_view->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cronotc_view->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_view->PageUrl() ?>start=<?php echo $cronotc_view->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cronotc_view->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_view->PageUrl() ?>start=<?php echo $cronotc_view->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cronotc_view->Pager->PageCount ?></span></td>
	</tr></table>
<?php } else { ?>
	<?php if ($cronotc_view->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<br>
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cronotc->id->Visible) { // id ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->id->FldCaption() ?></td>
		<td<?php echo $cronotc->id->CellAttributes() ?>>
<div<?php echo $cronotc->id->ViewAttributes() ?>><?php echo $cronotc->id->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->nombre->Visible) { // nombre ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->nombre->FldCaption() ?></td>
		<td<?php echo $cronotc->nombre->CellAttributes() ?>>
<div<?php echo $cronotc->nombre->ViewAttributes() ?>><?php echo $cronotc->nombre->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->horaini->Visible) { // horaini ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->horaini->FldCaption() ?></td>
		<td<?php echo $cronotc->horaini->CellAttributes() ?>>
<div<?php echo $cronotc->horaini->ViewAttributes() ?>><?php echo $cronotc->horaini->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->horafin->Visible) { // horafin ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->horafin->FldCaption() ?></td>
		<td<?php echo $cronotc->horafin->CellAttributes() ?>>
<div<?php echo $cronotc->horafin->ViewAttributes() ?>><?php echo $cronotc->horafin->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->visible->Visible) { // visible ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->visible->FldCaption() ?></td>
		<td<?php echo $cronotc->visible->CellAttributes() ?>>
<div<?php echo $cronotc->visible->ViewAttributes() ?>><?php echo $cronotc->visible->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->paquete->Visible) { // paquete ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->paquete->FldCaption() ?></td>
		<td<?php echo $cronotc->paquete->CellAttributes() ?>>
<div<?php echo $cronotc->paquete->ViewAttributes() ?>><?php echo $cronotc->paquete->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->placa->Visible) { // placa ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->placa->FldCaption() ?></td>
		<td<?php echo $cronotc->placa->CellAttributes() ?>>
<div<?php echo $cronotc->placa->ViewAttributes() ?>><?php echo $cronotc->placa->ViewValue ?></div></td>
	</tr>
<?php } ?>
<?php if ($cronotc->color->Visible) { // color ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->color->FldCaption() ?></td>
		<td<?php echo $cronotc->color->CellAttributes() ?>>
<div<?php echo $cronotc->color->ViewAttributes() ?>><?php echo $cronotc->color->ViewValue ?></div></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($cronotc->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$cronotc_view->Page_Terminate();
?>
<?php

//
// Page class
//
class ccronotc_view {

	// Page ID
	var $PageID = 'view';

	// Table name
	var $TableName = 'cronotc';

	// Page object name
	var $PageObjName = 'cronotc_view';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $cronotc;
		if ($cronotc->UseTokenInUrl) $PageUrl .= "t=" . $cronotc->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $cronotc;
		if ($cronotc->UseTokenInUrl) {
			if ($objForm)
				return ($cronotc->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($cronotc->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function ccronotc_view() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (cronotc)
		$GLOBALS["cronotc"] = new ccronotc();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronotc', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $cronotc;

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$cronotc->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$cronotc->Export = $_POST["exporttype"];
		} else {
			$cronotc->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $cronotc->Export; // Get export parameter, used in header
		$gsExportFile = $cronotc->TableVar; // Get export file, used in header
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["id"]);
		}
		if ($cronotc->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($cronotc->Export == "word") {
			header('Content-Type: application/vnd.ms-word');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $lDisplayRecs = 1;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $lRecCnt;
	var $arRecKey = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $cronotc;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$cronotc->id->setQueryStringValue($_GET["id"]);
				$this->arRecKey["id"] = $cronotc->id->QueryStringValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$cronotc->CurrentAction = "I"; // Display form
			switch ($cronotc->CurrentAction) {
				case "I": // Get a record to display
					$this->lStartRec = 1; // Initialize start position
					if ($rs = $this->LoadRecordset()) // Load records
						$this->lTotalRecs = $rs->RecordCount(); // Get record count
					if ($this->lTotalRecs <= 0) { // No record found
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("cronotclist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->lStartRec) <= intval($this->lTotalRecs)) {
							$bMatchRecord = TRUE;
							$rs->Move($this->lStartRec-1);
						}
					} else { // Match key values
						while (!$rs->EOF) {
							if (strval($cronotc->id->CurrentValue) == strval($rs->fields('id'))) {
								$cronotc->setStartRecordNumber($this->lStartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->lStartRec++;
								$rs->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						$this->setMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cronotclist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($rs); // Load row values
					}
			}

			// Export data only
			if (in_array($cronotc->Export, array("html","word","excel","xml","csv","email"))) {
				$this->ExportData();
				if ($cronotc->Export <> "email")
					$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "cronotclist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$cronotc->RowType = EW_ROWTYPE_VIEW;
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $cronotc;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$cronotc->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$cronotc->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $cronotc->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$cronotc->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$cronotc->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$cronotc->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $cronotc;

		// Call Recordset Selecting event
		$cronotc->Recordset_Selecting($cronotc->CurrentFilter);

		// Load List page SQL
		$sSql = $cronotc->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$cronotc->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $cronotc;
		$sFilter = $cronotc->KeyFilter();

		// Call Row Selecting event
		$cronotc->Row_Selecting($sFilter);

		// Load SQL based on filter
		$cronotc->CurrentFilter = $sFilter;
		$sSql = $cronotc->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$cronotc->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $cronotc;
		$cronotc->id->setDbValue($rs->fields('id'));
		$cronotc->nombre->setDbValue($rs->fields('nombre'));
		$cronotc->horaini->setDbValue($rs->fields('horaini'));
		$cronotc->horafin->setDbValue($rs->fields('horafin'));
		$cronotc->visible->setDbValue($rs->fields('visible'));
		$cronotc->paquete->setDbValue($rs->fields('paquete'));
		$cronotc->placa->setDbValue($rs->fields('placa'));
		$cronotc->color->setDbValue($rs->fields('color'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $cronotc;

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->ExportWordUrl = $this->PageUrl() . "export=word&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv&" . "id=" . urlencode($cronotc->id->CurrentValue);
		$this->AddUrl = $cronotc->AddUrl();
		$this->EditUrl = $cronotc->EditUrl();
		$this->CopyUrl = $cronotc->CopyUrl();
		$this->DeleteUrl = $cronotc->DeleteUrl();
		$this->ListUrl = $cronotc->ListUrl();

		// Call Row_Rendering event
		$cronotc->Row_Rendering();

		// Common render codes for all row types
		// id

		$cronotc->id->CellCssStyle = ""; $cronotc->id->CellCssClass = "";
		$cronotc->id->CellAttrs = array(); $cronotc->id->ViewAttrs = array(); $cronotc->id->EditAttrs = array();

		// nombre
		$cronotc->nombre->CellCssStyle = ""; $cronotc->nombre->CellCssClass = "";
		$cronotc->nombre->CellAttrs = array(); $cronotc->nombre->ViewAttrs = array(); $cronotc->nombre->EditAttrs = array();

		// horaini
		$cronotc->horaini->CellCssStyle = ""; $cronotc->horaini->CellCssClass = "";
		$cronotc->horaini->CellAttrs = array(); $cronotc->horaini->ViewAttrs = array(); $cronotc->horaini->EditAttrs = array();

		// horafin
		$cronotc->horafin->CellCssStyle = ""; $cronotc->horafin->CellCssClass = "";
		$cronotc->horafin->CellAttrs = array(); $cronotc->horafin->ViewAttrs = array(); $cronotc->horafin->EditAttrs = array();

		// visible
		$cronotc->visible->CellCssStyle = ""; $cronotc->visible->CellCssClass = "";
		$cronotc->visible->CellAttrs = array(); $cronotc->visible->ViewAttrs = array(); $cronotc->visible->EditAttrs = array();

		// paquete
		$cronotc->paquete->CellCssStyle = ""; $cronotc->paquete->CellCssClass = "";
		$cronotc->paquete->CellAttrs = array(); $cronotc->paquete->ViewAttrs = array(); $cronotc->paquete->EditAttrs = array();

		// placa
		$cronotc->placa->CellCssStyle = ""; $cronotc->placa->CellCssClass = "";
		$cronotc->placa->CellAttrs = array(); $cronotc->placa->ViewAttrs = array(); $cronotc->placa->EditAttrs = array();

		// color
		$cronotc->color->CellCssStyle = ""; $cronotc->color->CellCssClass = "";
		$cronotc->color->CellAttrs = array(); $cronotc->color->ViewAttrs = array(); $cronotc->color->EditAttrs = array();
		if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$cronotc->id->ViewValue = $cronotc->id->CurrentValue;
			$cronotc->id->CssStyle = "";
			$cronotc->id->CssClass = "";
			$cronotc->id->ViewCustomAttributes = "";

			// nombre
			$cronotc->nombre->ViewValue = $cronotc->nombre->CurrentValue;
			$cronotc->nombre->CssStyle = "";
			$cronotc->nombre->CssClass = "";
			$cronotc->nombre->ViewCustomAttributes = "";

			// horaini
			$cronotc->horaini->ViewValue = $cronotc->horaini->CurrentValue;
			$cronotc->horaini->CssStyle = "";
			$cronotc->horaini->CssClass = "";
			$cronotc->horaini->ViewCustomAttributes = "";

			// horafin
			$cronotc->horafin->ViewValue = $cronotc->horafin->CurrentValue;
			$cronotc->horafin->CssStyle = "";
			$cronotc->horafin->CssClass = "";
			$cronotc->horafin->ViewCustomAttributes = "";

			// visible
			if (strval($cronotc->visible->CurrentValue) <> "") {
				switch ($cronotc->visible->CurrentValue) {
					case "0":
						$cronotc->visible->ViewValue = "0";
						break;
					case "1":
						$cronotc->visible->ViewValue = "1";
						break;
					default:
						$cronotc->visible->ViewValue = $cronotc->visible->CurrentValue;
				}
			} else {
				$cronotc->visible->ViewValue = NULL;
			}
			$cronotc->visible->CssStyle = "";
			$cronotc->visible->CssClass = "";
			$cronotc->visible->ViewCustomAttributes = "";

			// paquete
			$cronotc->paquete->ViewValue = $cronotc->paquete->CurrentValue;
			$cronotc->paquete->CssStyle = "";
			$cronotc->paquete->CssClass = "";
			$cronotc->paquete->ViewCustomAttributes = "";

			// placa
			$cronotc->placa->ViewValue = $cronotc->placa->CurrentValue;
			$cronotc->placa->CssStyle = "";
			$cronotc->placa->CssClass = "";
			$cronotc->placa->ViewCustomAttributes = "";

			// color
			if (strval($cronotc->color->CurrentValue) <> "") {
				switch ($cronotc->color->CurrentValue) {
					case "#FF0000":
						$cronotc->color->ViewValue = "Rojo";
						break;
					case "#FFFF00":
						$cronotc->color->ViewValue = "Amarillo";
						break;
					case "#00FF00":
						$cronotc->color->ViewValue = "Verde";
						break;
					default:
						$cronotc->color->ViewValue = $cronotc->color->CurrentValue;
				}
			} else {
				$cronotc->color->ViewValue = NULL;
			}
			$cronotc->color->CssStyle = "";
			$cronotc->color->CssClass = "";
			$cronotc->color->ViewCustomAttributes = "";

			// id
			$cronotc->id->HrefValue = "";
			$cronotc->id->TooltipValue = "";

			// nombre
			$cronotc->nombre->HrefValue = "";
			$cronotc->nombre->TooltipValue = "";

			// horaini
			$cronotc->horaini->HrefValue = "";
			$cronotc->horaini->TooltipValue = "";

			// horafin
			$cronotc->horafin->HrefValue = "";
			$cronotc->horafin->TooltipValue = "";

			// visible
			$cronotc->visible->HrefValue = "";
			$cronotc->visible->TooltipValue = "";

			// paquete
			$cronotc->paquete->HrefValue = "";
			$cronotc->paquete->TooltipValue = "";

			// placa
			$cronotc->placa->HrefValue = "";
			$cronotc->placa->TooltipValue = "";

			// color
			$cronotc->color->HrefValue = "";
			$cronotc->color->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($cronotc->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cronotc->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email format
	function ExportData() {
		global $cronotc;
		$utf8 = FALSE;
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->lTotalRecs = $cronotc->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->lTotalRecs = $rs->RecordCount();
		}
		$this->lStartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->lDisplayRecs < 0) {
			$this->lStopRec = $this->lTotalRecs;
		} else {
			$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($cronotc->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
			$XmlDoc->AddRoot();
		} else {
			$ExportDoc = new cExportDocument($cronotc, "v");
			$ExportDoc->ExportHeader();
			if ($ExportDoc->Horizontal) { // Horizontal format, write header
				$ExportDoc->BeginExportRow();
				$ExportDoc->ExportCaption($cronotc->id);
				$ExportDoc->ExportCaption($cronotc->nombre);
				$ExportDoc->ExportCaption($cronotc->horaini);
				$ExportDoc->ExportCaption($cronotc->horafin);
				$ExportDoc->ExportCaption($cronotc->visible);
				$ExportDoc->ExportCaption($cronotc->paquete);
				$ExportDoc->ExportCaption($cronotc->placa);
				$ExportDoc->ExportCaption($cronotc->color);
				$ExportDoc->EndExportRow();
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			if (!$bSelectLimit && $this->lStartRec > 1)
				$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row
				$cronotc->CssClass = "";
				$cronotc->CssStyle = "";
				$cronotc->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($cronotc->Export == "xml") {
					$XmlDoc->AddRow();
					$XmlDoc->AddField('id', $cronotc->id->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('nombre', $cronotc->nombre->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('horaini', $cronotc->horaini->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('horafin', $cronotc->horafin->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('visible', $cronotc->visible->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('paquete', $cronotc->paquete->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('placa', $cronotc->placa->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
					$XmlDoc->AddField('color', $cronotc->color->ExportValue($cronotc->Export, $cronotc->ExportOriginalValue));
				} else {
					$ExportDoc->BeginExportRow(TRUE); // Allow CSS styles if enabled
					$ExportDoc->ExportField($cronotc->id);
					$ExportDoc->ExportField($cronotc->nombre);
					$ExportDoc->ExportField($cronotc->horaini);
					$ExportDoc->ExportField($cronotc->horafin);
					$ExportDoc->ExportField($cronotc->visible);
					$ExportDoc->ExportField($cronotc->paquete);
					$ExportDoc->ExportField($cronotc->placa);
					$ExportDoc->ExportField($cronotc->color);
					$ExportDoc->EndExportRow();
				}
			}
			$rs->MoveNext();
		}
		if ($cronotc->Export <> "xml")
			$ExportDoc->ExportFooter();

		// Close recordset
		$rs->Close();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($cronotc->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($cronotc->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($cronotc->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($cronotc->ExportReturnUrl());
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}
}
?>
