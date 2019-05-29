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
$cronotc_add = new ccronotc_add();
$Page =& $cronotc_add;

// Page init
$cronotc_add->Page_Init();

// Page main
$cronotc_add->Page_Main();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--

// Create page object
var cronotc_add = new ew_Page("cronotc_add");

// page properties
cronotc_add.PageID = "add"; // page ID
cronotc_add.FormID = "fcronotcadd"; // form ID
var EW_PAGE_ID = cronotc_add.PageID; // for backward compatibility

// extend page with ValidateForm function
cronotc_add.ValidateForm = function(fobj) {
	ew_PostAutoSuggest(fobj);
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";

		// Call Form Custom Validate event
		if (!this.Form_CustomValidate(fobj)) return false;
	}
	return true;
}

// extend page with Form_CustomValidate function
cronotc_add.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cronotc_add.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cronotc_add.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronotc_add.ValidateRequired = false; // no JavaScript validation
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
<p><span class="phpmaker"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cronotc->TableCaption() ?><br><br>
<a href="<?php echo $cronotc->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></span></p>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$cronotc_add->ShowMessage();
?>
<form name="fcronotcadd" id="fcronotcadd" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return cronotc_add.ValidateForm(this);">
<p>
<input type="hidden" name="t" id="t" value="cronotc">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" class="ewTable">
<?php if ($cronotc->nombre->Visible) { // nombre ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->nombre->FldCaption() ?></td>
		<td<?php echo $cronotc->nombre->CellAttributes() ?>><span id="el_nombre">
<input type="text" name="x_nombre" id="x_nombre" title="<?php echo $cronotc->nombre->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->nombre->EditValue ?>"<?php echo $cronotc->nombre->EditAttributes() ?>>
</span><?php echo $cronotc->nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->horaini->Visible) { // horaini ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->horaini->FldCaption() ?></td>
		<td<?php echo $cronotc->horaini->CellAttributes() ?>><span id="el_horaini">
<input type="text" name="x_horaini" id="x_horaini" title="<?php echo $cronotc->horaini->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->horaini->EditValue ?>"<?php echo $cronotc->horaini->EditAttributes() ?>>
</span><?php echo $cronotc->horaini->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->horafin->Visible) { // horafin ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->horafin->FldCaption() ?></td>
		<td<?php echo $cronotc->horafin->CellAttributes() ?>><span id="el_horafin">
<input type="text" name="x_horafin" id="x_horafin" title="<?php echo $cronotc->horafin->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->horafin->EditValue ?>"<?php echo $cronotc->horafin->EditAttributes() ?>>
</span><?php echo $cronotc->horafin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->visible->Visible) { // visible ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->visible->FldCaption() ?></td>
		<td<?php echo $cronotc->visible->CellAttributes() ?>><span id="el_visible">
<div id="tp_x_visible" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x_visible" id="x_visible" title="<?php echo $cronotc->visible->FldTitle() ?>" value="{value}"<?php echo $cronotc->visible->EditAttributes() ?>></label></div>
<div id="dsl_x_visible" repeatcolumn="5">
<?php
$arwrk = $cronotc->visible->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cronotc->visible->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_visible" id="x_visible" title="<?php echo $cronotc->visible->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cronotc->visible->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cronotc->visible->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->paquete->Visible) { // paquete ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->paquete->FldCaption() ?></td>
		<td<?php echo $cronotc->paquete->CellAttributes() ?>><span id="el_paquete">
<input type="text" name="x_paquete" id="x_paquete" title="<?php echo $cronotc->paquete->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->paquete->EditValue ?>"<?php echo $cronotc->paquete->EditAttributes() ?>>
</span><?php echo $cronotc->paquete->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->placa->Visible) { // placa ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->placa->FldCaption() ?></td>
		<td<?php echo $cronotc->placa->CellAttributes() ?>><span id="el_placa">
<input type="text" name="x_placa" id="x_placa" title="<?php echo $cronotc->placa->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->placa->EditValue ?>"<?php echo $cronotc->placa->EditAttributes() ?>>
</span><?php echo $cronotc->placa->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cronotc->color->Visible) { // color ?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
		<td class="ewTableHeader"><?php echo $cronotc->color->FldCaption() ?></td>
		<td<?php echo $cronotc->color->CellAttributes() ?>><span id="el_color">
<select id="x_color" name="x_color" title="<?php echo $cronotc->color->FldTitle() ?>"<?php echo $cronotc->color->EditAttributes() ?>>
<?php
if (is_array($cronotc->color->EditValue)) {
	$arwrk = $cronotc->color->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cronotc->color->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $cronotc->color->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php
$cronotc_add->Page_Terminate();
?>
<?php

//
// Page class
//
class ccronotc_add {

	// Page ID
	var $PageID = 'add';

	// Table name
	var $TableName = 'cronotc';

	// Page object name
	var $PageObjName = 'cronotc_add';

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
	function ccronotc_add() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (cronotc)
		$GLOBALS["cronotc"] = new ccronotc();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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
	var $sDbMasterFilter = "";
	var $sDbDetailFilter = "";
	var $lPriv = 0;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $cronotc;

		// Load key values from QueryString
		$bCopy = TRUE;
		if (@$_GET["id"] != "") {
		  $cronotc->id->setQueryStringValue($_GET["id"]);
		} else {
		  $bCopy = FALSE;
		}

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
		   $cronotc->CurrentAction = $_POST["a_add"]; // Get form action
		  $this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$cronotc->CurrentAction = "I"; // Form error, reset action
				$this->setMessage($gsFormError);
			}
		} else { // Not post back
		  if ($bCopy) {
		    $cronotc->CurrentAction = "C"; // Copy record
		  } else {
		    $cronotc->CurrentAction = "I"; // Display blank record
		    $this->LoadDefaultValues(); // Load default values
		  }
		}

		// Perform action based on action code
		switch ($cronotc->CurrentAction) {
		  case "I": // Blank record, no action required
				break;
		  case "C": // Copy an existing record
		   if (!$this->LoadRow()) { // Load record based on key
		      $this->setMessage($Language->Phrase("NoRecord")); // No record found
		      $this->Page_Terminate("cronotclist.php"); // No matching record, return to list
		    }
				break;
		  case "A": // ' Add new record
				$cronotc->SendEmail = TRUE; // Send email on add success
		    if ($this->AddRow()) { // Add successful
		      $this->setMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $cronotc->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cronotcview.php")
						$sReturnUrl = $cronotc->ViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
		    } else {
		      $this->RestoreFormValues(); // Add failed, restore form values
		    }
		}

		// Render row based on row type
		$cronotc->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $cronotc;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		global $cronotc;
		$cronotc->visible->CurrentValue = "1";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cronotc;
		$cronotc->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$cronotc->horaini->setFormValue($objForm->GetValue("x_horaini"));
		$cronotc->horafin->setFormValue($objForm->GetValue("x_horafin"));
		$cronotc->visible->setFormValue($objForm->GetValue("x_visible"));
		$cronotc->paquete->setFormValue($objForm->GetValue("x_paquete"));
		$cronotc->placa->setFormValue($objForm->GetValue("x_placa"));
		$cronotc->color->setFormValue($objForm->GetValue("x_color"));
		$cronotc->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm, $cronotc;
		$cronotc->id->CurrentValue = $cronotc->id->FormValue;
		$cronotc->nombre->CurrentValue = $cronotc->nombre->FormValue;
		$cronotc->horaini->CurrentValue = $cronotc->horaini->FormValue;
		$cronotc->horafin->CurrentValue = $cronotc->horafin->FormValue;
		$cronotc->visible->CurrentValue = $cronotc->visible->FormValue;
		$cronotc->paquete->CurrentValue = $cronotc->paquete->FormValue;
		$cronotc->placa->CurrentValue = $cronotc->placa->FormValue;
		$cronotc->color->CurrentValue = $cronotc->color->FormValue;
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
		} elseif ($cronotc->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$cronotc->nombre->EditCustomAttributes = "";
			$cronotc->nombre->EditValue = ew_HtmlEncode($cronotc->nombre->CurrentValue);

			// horaini
			$cronotc->horaini->EditCustomAttributes = "";
			$cronotc->horaini->EditValue = ew_HtmlEncode($cronotc->horaini->CurrentValue);

			// horafin
			$cronotc->horafin->EditCustomAttributes = "";
			$cronotc->horafin->EditValue = ew_HtmlEncode($cronotc->horafin->CurrentValue);

			// visible
			$cronotc->visible->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("0", "0");
			$arwrk[] = array("1", "1");
			$cronotc->visible->EditValue = $arwrk;

			// paquete
			$cronotc->paquete->EditCustomAttributes = "";
			$cronotc->paquete->EditValue = ew_HtmlEncode($cronotc->paquete->CurrentValue);

			// placa
			$cronotc->placa->EditCustomAttributes = "";
			$cronotc->placa->EditValue = ew_HtmlEncode($cronotc->placa->CurrentValue);

			// color
			$cronotc->color->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array("#FF0000", "Rojo");
			$arwrk[] = array("#FFFF00", "Amarillo");
			$arwrk[] = array("#00FF00", "Verde");
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$cronotc->color->EditValue = $arwrk;
		}

		// Call Row Rendered event
		if ($cronotc->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$cronotc->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError, $cronotc;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow() {
		global $conn, $Language, $Security, $cronotc;
		$rsnew = array();

		// nombre
		$cronotc->nombre->SetDbValueDef($rsnew, $cronotc->nombre->CurrentValue, NULL, FALSE);

		// horaini
		$cronotc->horaini->SetDbValueDef($rsnew, $cronotc->horaini->CurrentValue, NULL, FALSE);

		// horafin
		$cronotc->horafin->SetDbValueDef($rsnew, $cronotc->horafin->CurrentValue, NULL, FALSE);

		// visible
		$cronotc->visible->SetDbValueDef($rsnew, $cronotc->visible->CurrentValue, NULL, TRUE);

		// paquete
		$cronotc->paquete->SetDbValueDef($rsnew, $cronotc->paquete->CurrentValue, NULL, FALSE);

		// placa
		$cronotc->placa->SetDbValueDef($rsnew, $cronotc->placa->CurrentValue, NULL, FALSE);

		// color
		$cronotc->color->SetDbValueDef($rsnew, $cronotc->color->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$bInsertRow = $cronotc->Row_Inserting($rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $conn->Execute($cronotc->InsertSQL($rsnew));
			$conn->raiseErrorFn = '';
		} else {
			if ($cronotc->CancelMessage <> "") {
				$this->setMessage($cronotc->CancelMessage);
				$cronotc->CancelMessage = "";
			} else {
				$this->setMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {
			$cronotc->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $cronotc->id->DbValue;

			// Call Row Inserted event
			$cronotc->Row_Inserted($rsnew);
		}
		return $AddRow;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
