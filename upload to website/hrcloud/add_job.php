<?php require_once('Connections/hrcloud.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addjob")) {
  $insertSQL = sprintf("INSERT INTO jobs (jobtitle, company, location, opendate, closedoropen) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['jobtitle'], "text"),
                       GetSQLValueString($_POST['company'], "text"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['opendate'], "date"),
                       GetSQLValueString($_POST['open'], "text"));

  mysql_select_db($database_hrcloud, $hrcloud);
  $Result1 = mysql_query($insertSQL, $hrcloud) or die(mysql_error());

  $insertGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 $title = "Add Jobs"; ?>
<?php require_once('assets/wrapper/header.php'); ?>
<script language='JavaScript' type='text/javascript' src='assets/scripts/calendar.js'></script>
<p>Add Jobs</p>
<div id="calendarDiv">	</div>

<form action="<?php echo $editFormAction; ?>" name="addjob" method="POST">

<p>Job Title <input name="jobtitle" type="text"></p>
<p>Company <input name="company" type="text"></p>
<p>Location <input name="location" type="text"></p>

<p>Open Date <input name="opendate" type="text" class="calendarSelectDate" ></p>
<input type="hidden" name="open" value="open">
<p><input name="submit" type="submit" id="submit" value="Add Job">
  <input type="hidden" name="MM_insert" value="addjob">
</form>
<?php require_once('assets/wrapper/footer.php'); ?>