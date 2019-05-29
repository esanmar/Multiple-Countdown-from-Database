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
$cronotc_list = new ccronotc_list();
$Page =& $cronotc_list;

// Page init
$cronotc_list->Page_Init();

// Page main
$cronotc_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($cronotc->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var cronotc_list = new ew_Page("cronotc_list");

// page properties
cronotc_list.PageID = "list"; // page ID
cronotc_list.FormID = "fcronotclist"; // form ID
var EW_PAGE_ID = cronotc_list.PageID; // for backward compatibility

// extend page with ValidateForm function
cronotc_list.ValidateForm = function(fobj) {
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
cronotc_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
cronotc_list.SelectAllKey = function(elem) {
	ew_SelectAll(elem);
	ew_ClickAll(elem);
}
<?php if (EW_CLIENT_VALIDATE) { ?>
cronotc_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
cronotc_list.ValidateRequired = false; // no JavaScript validation
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
<?php if ($cronotc->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cronotc_list->lTotalRecs = $cronotc->SelectRecordCount();
	} else {
		if ($rs = $cronotc_list->LoadRecordset())
			$cronotc_list->lTotalRecs = $rs->RecordCount();
	}
	$cronotc_list->lStartRec = 1;
	if ($cronotc_list->lDisplayRecs <= 0 || ($cronotc->Export <> "" && $cronotc->ExportAll)) // Display all records
		$cronotc_list->lDisplayRecs = $cronotc_list->lTotalRecs;
	if (!($cronotc->Export <> "" && $cronotc->ExportAll))
		$cronotc_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $cronotc_list->LoadRecordset($cronotc_list->lStartRec-1, $cronotc_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $cronotc->TableCaption() ?>
<?php if ($cronotc->Export == "" && $cronotc->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $cronotc_list->ExportPrintUrl ?>"><?php echo $Language->Phrase("PrinterFriendly") ?></a>
&nbsp;&nbsp;<a href="<?php echo $cronotc_list->ExportExcelUrl ?>"><?php echo $Language->Phrase("ExportToExcel") ?></a>
&nbsp;&nbsp;<a href="<?php echo $cronotc_list->ExportWordUrl ?>"><?php echo $Language->Phrase("ExportToWord") ?></a>
<?php } ?>
</span></p>
<?php if ($cronotc->Export == "" && $cronotc->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(cronotc_list);" style="text-decoration: none;"><img id="cronotc_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="cronotc_list_SearchPanel">
<form name="fcronotclistsrch" id="fcronotclistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="cronotc">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($cronotc->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $cronotc_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($cronotc->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($cronotc->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($cronotc->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$cronotc_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<?php if ($cronotc->Export == "") { ?>
<div class="ewGridUpperPanel">
<?php if ($cronotc->CurrentAction <> "gridadd" && $cronotc->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($cronotc_list->Pager)) $cronotc_list->Pager = new cPrevNextPager($cronotc_list->lStartRec, $cronotc_list->lDisplayRecs, $cronotc_list->lTotalRecs) ?>
<?php if ($cronotc_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($cronotc_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_list->PageUrl() ?>start=<?php echo $cronotc_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($cronotc_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_list->PageUrl() ?>start=<?php echo $cronotc_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cronotc_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($cronotc_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_list->PageUrl() ?>start=<?php echo $cronotc_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($cronotc_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $cronotc_list->PageUrl() ?>start=<?php echo $cronotc_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cronotc_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cronotc_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cronotc_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cronotc_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($cronotc_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($cronotc->CurrentAction <> "gridadd" && $cronotc->CurrentAction <> "gridedit") { // Not grid add/edit mode ?>
<a href="<?php echo $cronotc_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php if ($cronotc_list->lTotalRecs > 0) { ?>
<a href="<?php echo $cronotc_list->GridEditUrl ?>"><?php echo $Language->Phrase("GridEditLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($cronotc_list->lTotalRecs > 0) { ?>
<a href="" onclick="ew_SubmitSelected(document.fcronotclist, '<?php echo $cronotc_list->MultiDeleteUrl ?>', ewLanguage.Phrase('DeleteMultiConfirmMsg'));return false;"><?php echo $Language->Phrase("DeleteSelectedLink") ?></a>&nbsp;&nbsp;
<a href="" onclick="ew_SubmitSelected(document.fcronotclist, '<?php echo $cronotc_list->MultiUpdateUrl ?>');return false;"><?php echo $Language->Phrase("UpdateSelectedLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } else { // Grid add/edit mode ?>
<?php if ($cronotc->CurrentAction == "gridedit") { ?>
<a href="" onclick="f=document.fcronotclist;if(cronotc_list.ValidateForm(f))f.submit();return false;"><?php echo $Language->Phrase("GridSaveLink") ?></a>&nbsp;&nbsp;
<a href="<?php echo $cronotc_list->PageUrl() ?>a=cancel"><?php echo $Language->Phrase("GridCancelLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<?php } ?>
<form name="fcronotclist" id="fcronotclist" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" id="t" value="cronotc">
<div id="gmp_cronotc" class="ewGridMiddlePanel">
<?php if ($cronotc_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $cronotc->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cronotc_list->RenderListOptions();

// Render list options (header, left)
$cronotc_list->ListOptions->Render("header", "left");
?>
<?php if ($cronotc->id->Visible) { // id ?>
	<?php if ($cronotc->SortUrl($cronotc->id) == "") { ?>
		<td><?php echo $cronotc->id->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->id) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->id->FldCaption() ?></td><td style="width: 10px;"><?php if ($cronotc->id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->nombre->Visible) { // nombre ?>
	<?php if ($cronotc->SortUrl($cronotc->nombre) == "") { ?>
		<td><?php echo $cronotc->nombre->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->nombre) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->nombre->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->nombre->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->horaini->Visible) { // horaini ?>
	<?php if ($cronotc->SortUrl($cronotc->horaini) == "") { ?>
		<td><?php echo $cronotc->horaini->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->horaini) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->horaini->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->horaini->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->horaini->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->horafin->Visible) { // horafin ?>
	<?php if ($cronotc->SortUrl($cronotc->horafin) == "") { ?>
		<td><?php echo $cronotc->horafin->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->horafin) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->horafin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->horafin->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->horafin->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->visible->Visible) { // visible ?>
	<?php if ($cronotc->SortUrl($cronotc->visible) == "") { ?>
		<td><?php echo $cronotc->visible->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->visible) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->visible->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->visible->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->visible->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->paquete->Visible) { // paquete ?>
	<?php if ($cronotc->SortUrl($cronotc->paquete) == "") { ?>
		<td><?php echo $cronotc->paquete->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->paquete) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->paquete->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->paquete->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->paquete->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->placa->Visible) { // placa ?>
	<?php if ($cronotc->SortUrl($cronotc->placa) == "") { ?>
		<td><?php echo $cronotc->placa->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->placa) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->placa->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($cronotc->placa->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->placa->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cronotc->color->Visible) { // color ?>
	<?php if ($cronotc->SortUrl($cronotc->color) == "") { ?>
		<td><?php echo $cronotc->color->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $cronotc->SortUrl($cronotc->color) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $cronotc->color->FldCaption() ?></td><td style="width: 10px;"><?php if ($cronotc->color->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($cronotc->color->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cronotc_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($cronotc->ExportAll && $cronotc->Export <> "") {
	$cronotc_list->lStopRec = $cronotc_list->lTotalRecs;
} else {
	$cronotc_list->lStopRec = $cronotc_list->lStartRec + $cronotc_list->lDisplayRecs - 1; // Set the last record to display
}
$cronotc_list->lRecCount = $cronotc_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $cronotc_list->lStartRec > 1)
		$rs->Move($cronotc_list->lStartRec - 1);
}

// Initialize aggregate
$cronotc->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cronotc_list->RenderRow();
$cronotc_list->lRowCnt = 0;
$cronotc_list->lEditRowCnt = 0;
if ($cronotc->CurrentAction == "edit")
	$cronotc_list->lRowIndex = 1;
if ($cronotc->CurrentAction == "gridedit")
	$cronotc_list->lRowIndex = 0;
while (($cronotc->CurrentAction == "gridadd" || !$rs->EOF) &&
	$cronotc_list->lRecCount < $cronotc_list->lStopRec) {
	$cronotc_list->lRecCount++;
	if (intval($cronotc_list->lRecCount) >= intval($cronotc_list->lStartRec)) {
		$cronotc_list->lRowCnt++;
		if ($cronotc->CurrentAction == "gridadd" || $cronotc->CurrentAction == "gridedit")
			$cronotc_list->lRowIndex++;

	// Init row class and style
	$cronotc->CssClass = "";
	$cronotc->CssStyle = "";
	$cronotc->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($cronotc->CurrentAction == "gridadd") {
		$cronotc_list->LoadDefaultValues(); // Load default values
	} else {
		$cronotc_list->LoadRowValues($rs); // Load row values
	}
	$cronotc->RowType = EW_ROWTYPE_VIEW; // Render view
	if ($cronotc->CurrentAction == "edit") {
		if ($cronotc_list->CheckInlineEditKey() && $cronotc_list->lEditRowCnt == 0) { // Inline edit
			$cronotc->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
	}
	if ($cronotc->CurrentAction == "gridedit") { // Grid edit
		$cronotc->RowType = EW_ROWTYPE_EDIT; // Render edit
	}
	if ($cronotc->RowType == EW_ROWTYPE_EDIT && $cronotc->EventCancelled) { // Update failed
		if ($cronotc->CurrentAction == "edit")
			$cronotc_list->RestoreFormValues(); // Restore form values
		if ($cronotc->CurrentAction == "gridedit")
			$cronotc_list->RestoreCurrentRowFormValues($cronotc_list->lRowIndex); // Restore form values
	}
	if ($cronotc->RowType == EW_ROWTYPE_EDIT) // Edit row
		$cronotc_list->lEditRowCnt++;
	if ($cronotc->RowType == EW_ROWTYPE_ADD || $cronotc->RowType == EW_ROWTYPE_EDIT) { // Add / Edit row
		$cronotc->RowAttrs = array_merge($cronotc->RowAttrs, array('onmouseover'=>'this.edit=true;ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);'));
		$cronotc->CssClass = "ewTableEditRow";
	}

	// Render row
	$cronotc_list->RenderRow();

	// Render list options
	$cronotc_list->RenderListOptions();
?>
	<tr<?php echo $cronotc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cronotc_list->ListOptions->Render("body", "left");
?>
	<?php if ($cronotc->id->Visible) { // id ?>
		<td<?php echo $cronotc->id->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div<?php echo $cronotc->id->ViewAttributes() ?>><?php echo $cronotc->id->EditValue ?></div><input type="hidden" name="x<?php echo $cronotc_list->lRowIndex ?>_id" id="x<?php echo $cronotc_list->lRowIndex ?>_id" value="<?php echo ew_HtmlEncode($cronotc->id->CurrentValue) ?>">
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->id->ViewAttributes() ?>><?php echo $cronotc->id->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->nombre->Visible) { // nombre ?>
		<td<?php echo $cronotc->nombre->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cronotc_list->lRowIndex ?>_nombre" id="x<?php echo $cronotc_list->lRowIndex ?>_nombre" title="<?php echo $cronotc->nombre->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->nombre->EditValue ?>"<?php echo $cronotc->nombre->EditAttributes() ?>>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->nombre->ViewAttributes() ?>><?php echo $cronotc->nombre->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->horaini->Visible) { // horaini ?>
		<td<?php echo $cronotc->horaini->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cronotc_list->lRowIndex ?>_horaini" id="x<?php echo $cronotc_list->lRowIndex ?>_horaini" title="<?php echo $cronotc->horaini->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->horaini->EditValue ?>"<?php echo $cronotc->horaini->EditAttributes() ?>>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->horaini->ViewAttributes() ?>><?php echo $cronotc->horaini->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->horafin->Visible) { // horafin ?>
		<td<?php echo $cronotc->horafin->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cronotc_list->lRowIndex ?>_horafin" id="x<?php echo $cronotc_list->lRowIndex ?>_horafin" title="<?php echo $cronotc->horafin->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->horafin->EditValue ?>"<?php echo $cronotc->horafin->EditAttributes() ?>>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->horafin->ViewAttributes() ?>><?php echo $cronotc->horafin->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->visible->Visible) { // visible ?>
		<td<?php echo $cronotc->visible->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<div id="tp_x<?php echo $cronotc_list->lRowIndex ?>_visible" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><label><input type="radio" name="x<?php echo $cronotc_list->lRowIndex ?>_visible" id="x<?php echo $cronotc_list->lRowIndex ?>_visible" title="<?php echo $cronotc->visible->FldTitle() ?>" value="{value}"<?php echo $cronotc->visible->EditAttributes() ?>></label></div>
<div id="dsl_x<?php echo $cronotc_list->lRowIndex ?>_visible" repeatcolumn="5">
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
<label><input type="radio" name="x<?php echo $cronotc_list->lRowIndex ?>_visible" id="x<?php echo $cronotc_list->lRowIndex ?>_visible" title="<?php echo $cronotc->visible->FldTitle() ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cronotc->visible->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->visible->ViewAttributes() ?>><?php echo $cronotc->visible->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->paquete->Visible) { // paquete ?>
		<td<?php echo $cronotc->paquete->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cronotc_list->lRowIndex ?>_paquete" id="x<?php echo $cronotc_list->lRowIndex ?>_paquete" title="<?php echo $cronotc->paquete->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->paquete->EditValue ?>"<?php echo $cronotc->paquete->EditAttributes() ?>>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->paquete->ViewAttributes() ?>><?php echo $cronotc->paquete->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->placa->Visible) { // placa ?>
		<td<?php echo $cronotc->placa->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cronotc_list->lRowIndex ?>_placa" id="x<?php echo $cronotc_list->lRowIndex ?>_placa" title="<?php echo $cronotc->placa->FldTitle() ?>" size="30" maxlength="250" value="<?php echo $cronotc->placa->EditValue ?>"<?php echo $cronotc->placa->EditAttributes() ?>>
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->placa->ViewAttributes() ?>><?php echo $cronotc->placa->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cronotc->color->Visible) { // color ?>
		<td<?php echo $cronotc->color->CellAttributes() ?>>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cronotc_list->lRowIndex ?>_color" name="x<?php echo $cronotc_list->lRowIndex ?>_color" title="<?php echo $cronotc->color->FldTitle() ?>"<?php echo $cronotc->color->EditAttributes() ?>>
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
<?php } ?>
<?php if ($cronotc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<div<?php echo $cronotc->color->ViewAttributes() ?>><?php echo $cronotc->color->ListViewValue() ?></div>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cronotc_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php if ($cronotc->RowType == EW_ROWTYPE_EDIT) { ?>
<?php } ?>
<?php
	}
	if ($cronotc->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cronotc->CurrentAction == "edit") { ?>
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cronotc_list->lRowIndex ?>">
<?php } ?>
<?php if ($cronotc->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cronotc_list->lRowIndex ?>">
<?php echo $cronotc_list->sMultiSelectKey ?>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
</td></tr></table>
<?php if ($cronotc->Export == "" && $cronotc->CurrentAction == "") { ?>
<?php } ?>
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
$cronotc_list->Page_Terminate();
?>
<?php

//
// Page class
//
class ccronotc_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'cronotc';

	// Page object name
	var $PageObjName = 'cronotc_list';

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
	function ccronotc_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (cronotc)
		$GLOBALS["cronotc"] = new ccronotc();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["cronotc"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cronotcdelete.php";
		$this->MultiUpdateUrl = "cronotcupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cronotc', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $cronotc;

		// Create form object
		$objForm = new cFormObj();

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

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $cronotc;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$cronotc->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($cronotc->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($cronotc->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($cronotc->CurrentAction == "edit")
					$this->InlineEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$cronotc->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($cronotc->CurrentAction == "gridupdate" || $cronotc->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit")
						$this->GridUpdate();

					// Inline Update
					if (($cronotc->CurrentAction == "update" || $cronotc->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();
				}
			}

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$cronotc->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($cronotc->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $cronotc->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$cronotc->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$cronotc->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$cronotc->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $cronotc->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$cronotc->setSessionWhere($sFilter);
		$cronotc->CurrentFilter = "";

		// Export data only
		if (in_array($cronotc->Export, array("html","word","excel","xml","csv","email"))) {
			$this->ExportData();
			if ($cronotc->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		global $cronotc;
		$cronotc->setKey("id", ""); // Clear inline edit key
		$cronotc->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $cronotc;
		$bInlineEdit = TRUE;
		if (@$_GET["id"] <> "") {
			$cronotc->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$cronotc->setKey("id", $cronotc->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError, $cronotc;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;	
			if ($this->CheckInlineEditKey()) { // Check key
				$cronotc->SendEmail = TRUE; // Send email on update success
				$bInlineUpdate = $this->EditRow(); // Update record
			} else {
				$bInlineUpdate = FALSE;
			}
		}
		if ($bInlineUpdate) { // Update success
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$cronotc->EventCancelled = TRUE; // Cancel event
			$cronotc->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {
		global $cronotc;

		//CheckInlineEditKey = True
		if (strval($cronotc->getKey("id")) <> strval($cronotc->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError, $cronotc;
		$rowindex = 1;
		$bGridUpdate = TRUE;

		// Begin transaction
		$conn->BeginTrans();

		// Get old recordset
		$cronotc->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $cronotc->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));

		// Update all rows based on key
		while ($sThisKey <> "") {

			// Load all values and keys
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$bGridUpdate = FALSE; // Form error, reset action
				$this->setMessage($gsFormError);
			} else {
				if ($this->SetupKeyValues($sThisKey)) { // Set up key values
					$cronotc->SendEmail = FALSE; // Do not send email on update success
					$bGridUpdate = $this->EditRow(); // Update this row
				} else {
					$bGridUpdate = FALSE; // update failed
				}
			}
			if ($bGridUpdate) {
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			} else {
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->setMessage($Language->Phrase("UpdateSuccess")); // Set update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getMessage() == "")
				$this->setMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$cronotc->EventCancelled = TRUE; // Set event cancelled
			$cronotc->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm, $cronotc;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $cronotc->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		global $cronotc;
		$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $key);
		if (count($arrKeyFlds) >= 1) {
			$cronotc->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($cronotc->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm, $cronotc;

		// Get row based on current index
		$objForm->Index = $idx;
		if ($cronotc->CurrentAction == "gridadd")
			$this->LoadFormValues(); // Load form values
		if ($cronotc->CurrentAction == "gridedit") {
			$sKey = strval($objForm->GetValue("k_key"));
			$arrKeyFlds = explode(EW_COMPOSITE_KEY_SEPARATOR, $sKey);
			if (count($arrKeyFlds) >= 1) {
				if (strval($arrKeyFlds[0]) == strval($cronotc->id->CurrentValue)) {
					$this->LoadFormValues(); // Load form values
				}
			}
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $cronotc;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $cronotc->nombre, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->horaini, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->horafin, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->visible, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->paquete, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->placa, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $cronotc->color, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $cronotc;
		$sSearchStr = "";
		$sSearchKeyword = $cronotc->BasicSearchKeyword;
		$sSearchType = $cronotc->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$cronotc->setSessionBasicSearchKeyword($sSearchKeyword);
			$cronotc->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $cronotc;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$cronotc->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $cronotc;
		$cronotc->setSessionBasicSearchKeyword("");
		$cronotc->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $cronotc;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$cronotc->BasicSearchKeyword = $cronotc->getSessionBasicSearchKeyword();
			$cronotc->BasicSearchType = $cronotc->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $cronotc;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$cronotc->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$cronotc->CurrentOrderType = @$_GET["ordertype"];
			$cronotc->UpdateSort($cronotc->id); // id
			$cronotc->UpdateSort($cronotc->nombre); // nombre
			$cronotc->UpdateSort($cronotc->horaini); // horaini
			$cronotc->UpdateSort($cronotc->horafin); // horafin
			$cronotc->UpdateSort($cronotc->visible); // visible
			$cronotc->UpdateSort($cronotc->paquete); // paquete
			$cronotc->UpdateSort($cronotc->placa); // placa
			$cronotc->UpdateSort($cronotc->color); // color
			$cronotc->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $cronotc;
		$sOrderBy = $cronotc->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($cronotc->SqlOrderBy() <> "") {
				$sOrderBy = $cronotc->SqlOrderBy();
				$cronotc->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $cronotc;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$cronotc->setSessionOrderBy($sOrderBy);
				$cronotc->id->setSort("");
				$cronotc->nombre->setSort("");
				$cronotc->horaini->setSort("");
				$cronotc->horafin->setSort("");
				$cronotc->visible->setSort("");
				$cronotc->paquete->setSort("");
				$cronotc->placa->setSort("");
				$cronotc->color->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$cronotc->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $cronotc;

		// "view"
		$this->ListOptions->Add("view");
		$item =& $this->ListOptions->Items["view"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "checkbox"
		$this->ListOptions->Add("checkbox");
		$item =& $this->ListOptions->Items["checkbox"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = True;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" class=\"phpmaker\" onclick=\"cronotc_list.SelectAllKey(this);\">";

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($cronotc->Export <> "" ||
			$cronotc->CurrentAction == "gridadd" ||
			$cronotc->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $cronotc;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($cronotc->CurrentAction == "edit" && $cronotc->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a name=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\" id=\"" . $this->PageObjName . "_row_" . $this->lRowCnt . "\"></a>" .
					"<a href=\"\" onclick=\"f=document.fcronotclist;if(cronotc_list.ValidateForm(f))f.submit();return false;\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			return;
		}

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . $Language->Phrase("ViewLink") . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<span class=\"ewSeparator\">&nbsp;|&nbsp;</span>";
			$oListOpt->Body .= "<a class=\"ewInlineLink\" href=\"" . $this->InlineEditUrl . "#" . $this->PageObjName . "_row_" . $this->lRowCnt . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . $Language->Phrase("CopyLink") . "</a>";
		}

		// "checkbox"
		$oListOpt =& $this->ListOptions->Items["checkbox"];
		if ($oListOpt->Visible)
			$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" id=\"key_m[]\" value=\"" . ew_HtmlEncode($cronotc->id->CurrentValue) . "\" class=\"phpmaker\" onclick='ew_ClickMultiCheckbox(this);'>";
		if ($cronotc->CurrentAction == "gridedit")
			$this->sMultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->lRowIndex . "_key\" id=\"k" . $this->lRowIndex . "_key\" value=\"" . $cronotc->id->CurrentValue . "\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $cronotc;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		global $cronotc;
		$cronotc->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$cronotc->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm, $cronotc;
		$cronotc->id->setFormValue($objForm->GetValue("x_id"));
		$cronotc->nombre->setFormValue($objForm->GetValue("x_nombre"));
		$cronotc->horaini->setFormValue($objForm->GetValue("x_horaini"));
		$cronotc->horafin->setFormValue($objForm->GetValue("x_horafin"));
		$cronotc->visible->setFormValue($objForm->GetValue("x_visible"));
		$cronotc->paquete->setFormValue($objForm->GetValue("x_paquete"));
		$cronotc->placa->setFormValue($objForm->GetValue("x_placa"));
		$cronotc->color->setFormValue($objForm->GetValue("x_color"));
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
		$this->ViewUrl = $cronotc->ViewUrl();
		$this->EditUrl = $cronotc->EditUrl();
		$this->InlineEditUrl = $cronotc->InlineEditUrl();
		$this->CopyUrl = $cronotc->CopyUrl();
		$this->InlineCopyUrl = $cronotc->InlineCopyUrl();
		$this->DeleteUrl = $cronotc->DeleteUrl();

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
		} elseif ($cronotc->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$cronotc->id->EditCustomAttributes = "";
			$cronotc->id->EditValue = $cronotc->id->CurrentValue;
			$cronotc->id->CssStyle = "";
			$cronotc->id->CssClass = "";
			$cronotc->id->ViewCustomAttributes = "";

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

			// Edit refer script
			// id

			$cronotc->id->HrefValue = "";

			// nombre
			$cronotc->nombre->HrefValue = "";

			// horaini
			$cronotc->horaini->HrefValue = "";

			// horafin
			$cronotc->horafin->HrefValue = "";

			// visible
			$cronotc->visible->HrefValue = "";

			// paquete
			$cronotc->paquete->HrefValue = "";

			// placa
			$cronotc->placa->HrefValue = "";

			// color
			$cronotc->color->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language, $cronotc;
		$sFilter = $cronotc->KeyFilter();
		$cronotc->CurrentFilter = $sFilter;
		$sSql = $cronotc->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold =& $rs->fields;
			$rsnew = array();

			// nombre
			$cronotc->nombre->SetDbValueDef($rsnew, $cronotc->nombre->CurrentValue, NULL, FALSE);

			// horaini
			$cronotc->horaini->SetDbValueDef($rsnew, $cronotc->horaini->CurrentValue, NULL, FALSE);

			// horafin
			$cronotc->horafin->SetDbValueDef($rsnew, $cronotc->horafin->CurrentValue, NULL, FALSE);

			// visible
			$cronotc->visible->SetDbValueDef($rsnew, $cronotc->visible->CurrentValue, NULL, FALSE);

			// paquete
			$cronotc->paquete->SetDbValueDef($rsnew, $cronotc->paquete->CurrentValue, NULL, FALSE);

			// placa
			$cronotc->placa->SetDbValueDef($rsnew, $cronotc->placa->CurrentValue, NULL, FALSE);

			// color
			$cronotc->color->SetDbValueDef($rsnew, $cronotc->color->CurrentValue, NULL, FALSE);

			// Call Row Updating event
			$bUpdateRow = $cronotc->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$EditRow = $conn->Execute($cronotc->UpdateSQL($rsnew));
				$conn->raiseErrorFn = '';
			} else {
				if ($cronotc->CancelMessage <> "") {
					$this->setMessage($cronotc->CancelMessage);
					$cronotc->CancelMessage = "";
				} else {
					$this->setMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$cronotc->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email format
	function ExportData() {
		global $cronotc;
		$utf8 = FALSE;
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->lTotalRecs = $cronotc->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->lTotalRecs = $rs->RecordCount();
		}
		$this->lStartRec = 1;

		// Export all
		if ($cronotc->ExportAll) {
			$this->lDisplayRecs = $this->lTotalRecs;
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->lStartRec-1, $this->lDisplayRecs);
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
			$ExportDoc = new cExportDocument($cronotc, "h");
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
