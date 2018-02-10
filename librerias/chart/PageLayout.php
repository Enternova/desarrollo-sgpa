<?php
include_once("Functions.php");

// This page just contains functions to render page layout.
function render_pageHeader() {
	//This function renders the page header. It includes headers too.
	$htmldata = <<<HTMLINFO
	<table width="960" align="center" cellpadding="0" cellspacing="0" border="0" background="images/PageBg.jpg">
		<tr height="70">
			<td width="33">	
			&nbsp;
			</td>
			<td align="left" valign="bottom">
				<a href="http://www.InfoSoftGlobal.com" target="_blank"><img src="Images/IGPLogo.jpg" alt="InfoSoft Global" border="0"></a>
			</td>
			<td align="right" valign="bottom">
				<img src="Images/TopRightText.gif" border="0">	
			</td>
			<td width="37">	
			&nbsp;
			</td>
		</tr>

		<tr>
			<td width="33">		
			</td>
			<td height="1" colspan="2" bgColor="#EEEEEE">
			</td>
			<td width="37">		
			</td>
		</tr>
HTMLINFO;

	return $htmldata;
}

//This function renders the page table open
function render_pageTableOpen() {
	$htmldata = <<< HTMLINFO
	<tr>
		<td height="10" colspan="4">
		</td>
	</tr>

	<tr>
		<td width="33">	
		</td>
		<td colspan="2">		
HTMLINFO;

	return $htmldata;
}

//This function renders the page table closing tags
function render_pageTableClose() {
	$htmldata = <<<HTMLINFO
			<br>
			</td>
			<td width="37">
			&nbsp;
			</td>
		</tr>	
		
		<tr>
			<td width="33">		
			</td>
			<td height="1" colspan="2" bgColor="#EEEEEE">
			</td>
			<td width="37">		
			</td>
		</tr>
		
		<tr>
			<td height="4" colspan="4">		
			</td>			
		</tr>
		
		<tr>
			<td width="33">		
			</td>
			<td colspan="2" align="center">
			<span class="text">This application was built using <a href="http://www.InfoSoftGlobal.com/FusionCharts" target="_blank"><b>FusionCharts v3</b></a> - &quot;Animated flash charts for the web&quot;.</span>
			</td>
			<td width="33">
			</td>
		</tr>
		
		<tr>
			<td width="33">		
			</td>
			<td colspan="2" align="center">
			<span class="text">� All Rights Reserved</span>
			</td>
			<td width="33">
			</td>
		</tr>
		
		<tr>
			<td height="4" colspan="4">		
			</td>			
		</tr>
	</table>
HTMLINFO;

	return $htmldata;
}

//This function draws a separator line between two tables
function drawSepLine() {
	$htmldata = <<<HTMLINFO
	<table width="875">
		<tr>
			<td width="33">		
			</td>
			<td height="1" colspan="2" bgColor="#EEEEEE">
			</td>
			<td width="37">		
			</td>
		</tr>
	</table>
HTMLINFO;

	return $htmldata;
}

//This function renders the year selection form
function render_yearSelectionFrm($intYear) {
    if (getAnimationState()=="1") {
        $animateYes = "checked";
        $animateNo  = "";
    } else {
        $animateYes = "";
        $animateNo  = "checked";
    }

    // Function to connect to the DB
    $link = connectToDB();

    //Retrieve the years
    $strSQL = "SELECT DISTINCT YEAR(OrderDate) As Year FROM FC_Orders ORDER BY 1";
    $result = mysql_query($strSQL) or die(mysql_error());

    //Render them in drop down box	
    $strYears = "";
    if ($result) {
        while($ors = mysql_fetch_array($result)) {
            if ($intYear == $ors['Year'])
                $checked="checked";
            else
                $checked="";

            $strYears .= "<input type='radio' name='year' value='" . $ors['Year'] . "' " . $checked . "><span class='text'>" . $ors['Year'] . "</span>";
        }
    }
    mysql_close($link);


    $htmldata = <<<HTMLINFO

<!-- Code to render the form for year selection and animation selection -->
<tr>
	<td width="33">		
	</td>
	<td height="1" colspan="2" bgColor="#FFFFFF">
	</td>
	<td width="37">		
	</td>
</tr>

<form name="frmYr" action="Default.php" method="post" id="frmYr">
<tr height="30">
	<td width="33">		
	</td>
	<td height="22" colspan="2" align="center" bgColor="#EEEEEE" valign="middle">
	<nobr>
	<span class="textbolddark">Select Year: </span>
$strYears
	<span class="textbolddark"><span class='text'>&nbsp;&nbsp;&nbsp;</span>Animate Charts: </span>

    <input type="radio" name="animate" value="1" $animateYes><span class="text">Yes</span>
	<input type="radio" name="animate" value="0" $animateNo><span class="text">No</span>

    <span class='text'>&nbsp;&nbsp;</span>
	<input type="submit" class="button" value="Go" id="submit" 1 name="submit" 1>
	
	</nobr>	
	</td>
	<td width="37">		
	</td>
</tr>
</form>	

<tr>
	<td width="33">		
	</td>
	<td height="1" colspan="2" bgColor="#FFFFFF">
	</td>
	<td width="37">		
	</td>
</tr>

<tr>
	<td width="33">		
	</td>
	<td height="1" colspan="2" bgColor="#EEEEEE">
	</td>
	<td width="37">		
	</td>
</tr>
<!-- End code to render form -->

HTMLINFO;

	return $htmldata;
}
?>