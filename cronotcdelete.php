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
$cronotc_delete = new ccronotc_delete();
$Page =& $cronotc_delete;

// Page init
$cronotc_delete->Page_Init();

// Page main
$cronotc_delete->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cronotc_delete = new ew_Page("cronotc_delete");

// page properties
cronotc_delete.PageID = "delete"; // page ID
cronotc_delete.FormID = "fcronotcdelete"; // form ID
var EW_PAGE_ID = cronotc_delete.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
cronotc_delete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cronotc_delete.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cronotc_delete.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronotc_delete.ValidateRequired = false; // no JavaScript validation
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
<?php

// Load records for display
if ($rs = $cronotc_delete->LoadRecordset())
	$cronotc_deletelTotalRecs = $rs->RecordCount(); // Get record count
if ($cronotc_deletelTotalRecs <= 0) { // No record found, exit
	if ($rs)
		$rs->Close();
	$cronotc_delete->Page_Terminate("cronotclist.php"); // Return to list
}
?>
<p><span class="phpmaker"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cronotc->TableCaption() ?><br><br>
<a href="<?php echo $cronotc->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$cronotc_delete->ShowMessage();
?>
<form action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" id="t" value="cronotc">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cronotc_delete->arRecKeys as $key) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($key) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable ewTableSeparate">
<?php echo $cronotc->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td valign="top"><?php echo $cronotc->id->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->nombre->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->horaini->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->horafin->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->visible->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->paquete->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->placa->FldCaption() ?></td>
		<td valign="top"><?php echo $cronotc->color->FldCaption() ?></td>
	</tr>
	</thead>
	<tbody>
<?php
$cronotc_delete->lRecCnt = 0;
$i = 0;
while (!$rs->EOF) {
	$cronotc_delete->lRecCnt++;

	// Set row properties
	$cronotc->CssClass = "";
	$cronotc->CssStyle = "";
	$cronotc->RowAttrs = array();
	$cronotc->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cronotc_delete->LoadRowValues($rs);

	// Render row
	$cronotc_delete->RenderRow();
?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td<?php echo $cronotc->id->CellAttributes() ?>>
<div<?php echo $cronotc->id->ViewAttributes() ?>><?php echo $cronotc->id->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->nombre->CellAttributes() ?>>
<div<?php echo $cronotc->nombre->ViewAttributes() ?>><?php echo $cronotc->nombre->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->horaini->CellAttributes() ?>>
<div<?php echo $cronotc->horaini->ViewAttributes() ?>><?php echo $cronotc->horaini->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->horafin->CellAttributes() ?>>
<div<?php echo $cronotc->horafin->ViewAttributes() ?>><?php echo $cronotc->horafin->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->visible->CellAttributes() ?>>
<div<?php echo $cronotc->visible->ViewAttributes() ?>><?php echo $cronotc->visible->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->paquete->CellAttributes() ?>>
<div<?php echo $cronotc->paquete->ViewAttributes() ?>><?php echo $cronotc->paquete->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->placa->CellAttributes() ?>>
<div<?php echo $cronotc->placa->ViewAttributes() ?>><?php echo $cronotc->placa->ListViewValue() ?></div></td>
		<td<?php echo $cronotc->color->CellAttributes() ?>>
<div<?php echo $cronotc->color->ViewAttributes() ?>><?php echo $cronotc->color->ListViewValue() ?></div></td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" id="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$cronotc_delete->Page_Terminate();
?>
<?php

//
// Page class
//
class ccronotc_delete {

	// Page ID
	var $PageID = 'delete';

	// Table name
	var $TableName = 'cronotc';

	// Page object name
	var $PageObjName = 'cronotc_delete';

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
	function ccronotc_delete() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (cronotc)
		$GLOBALS["cronotc"] = new ccronotc();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $lTotalRecs = 0;
	var $lRecCnt;
	var $arRecKeys = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $cronotc;

		// Load key parameters
		$sKey = "";
		$bSingleDelete = TRUE; // Initialize as single delete
		$nKeySelected = 0; // Initialize selected key count
		$sFilter = "";
		if (@$_GET["id"] <> "") {
			$cronotc->id->setQueryStringValue($_GET["id"]);
			if (!is_numeric($cronotc->id->QueryStringValue))
				$this->Page_Terminate("cronotclist.php"); // Prevent SQL injection, exit
			$sKey .= $cronotc->id->QueryStringValue;
		} else {
			$bSingleDelete = FALSE;
		}
		if ($bSingleDelete) {
			$nKeySelected = 1; // Set up key selected count
			$this->arRecKeys[0] = $sKey;
		} else {
			if (isset($_POST["key_m"])) { // Key in form
				$nKeySelected = count($_POST["key_m"]); // Set up key selected count
				$this->arRecKeys = ew_StripSlashes($_POST["key_m"]);
			}
		}
		if ($nKeySelected <= 0)
			$this->Page_Terminate("cronotclist.php"); // No key specified, return to list

		// Build filter
		foreach ($this->arRecKeys as $sKey) {
			$sFilter .= "(";

			// Set up key field
			$sKeyFld = $sKey;
			if (!is_numeric($sKeyFld))
				$this->Page_Terminate("cronotclist.php"); // Prevent SQL injection, return to list
			$sFilter .= "`id`=" . ew_AdjustSql($sKeyFld) . " AND ";
			if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
		}
		if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cronotc class, cronotcinfo.php

		$cronotc->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$cronotc->CurrentAction = $_POST["a_delete"];
		} else {
			$cronotc->CurrentAction = "D"; // Delete record directly
		}
		switch ($cronotc->CurrentAction) {
			case "D": // Delete
				$cronotc->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					$this->setMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($cronotc->getReturnUrl()); // Return to caller
				}
		}
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security, $cronotc;
		$DeleteRows = TRUE;
		$sWrkFilter = $cronotc->CurrentFilter;

		// Set up filter (SQL WHERE clause) and get return SQL
		// SQL constructor in cronotc class, cronotcinfo.php

		$cronotc->CurrentFilter = $sWrkFilter;
		$sSql = $cronotc->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $cronotc->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $conn->Execute($cronotc->DeleteSQL($row)); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($cronotc->CancelMessage <> "") {
				$this->setMessage($cronotc->CancelMessage);
				$cronotc->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$cronotc->Row_Deleted($row);
			}	
		}
		return $DeleteRows;
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
