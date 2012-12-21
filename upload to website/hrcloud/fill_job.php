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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "close")) {
  $updateSQL = sprintf("UPDATE jobs SET closedate=%s, closedoropen=%s WHERE id=%s",
                       GetSQLValueString($_POST['closedate'], "date"),
                       GetSQLValueString($_POST['closed'], "text"),
                       GetSQLValueString($_POST['job'], "int"));

  mysql_select_db($database_hrcloud, $hrcloud);
  $Result1 = mysql_query($updateSQL, $hrcloud) or die(mysql_error());

  $updateGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_hrcloud, $hrcloud);
$query_jobs = "SELECT * FROM jobs";
$jobs = mysql_query($query_jobs, $hrcloud) or die(mysql_error());
$row_jobs = mysql_fetch_assoc($jobs);
$totalRows_jobs = mysql_num_rows($jobs);

mysql_select_db($database_hrcloud, $hrcloud);
$query_applicants = "SELECT * FROM applicants";
$applicants = mysql_query($query_applicants, $hrcloud) or die(mysql_error());
$row_applicants = mysql_fetch_assoc($applicants);
$totalRows_applicants = mysql_num_rows($applicants);
 $title = "Close Jobs"; ?>
<?php require_once('assets/wrapper/header.php'); ?>
<script language='JavaScript' type='text/javascript' src='assets/scripts/calendar.js'></script>
Please job- onload -

loads into editishable form...\/\/\/
Please select applicant



Please select date
<div id="calendarDiv"></div>

<form action="<?php echo $editFormAction; ?>" method="POST" name="close">

<p>name 
<select name="name">
  <?php
do {  
?>
  <option value="<?php echo $row_applicants['name']?>"><?php echo $row_applicants['name']?></option>
  <?php
} while ($row_applicants = mysql_fetch_assoc($applicants));
  $rows = mysql_num_rows($applicants);
  if($rows > 0) {
      mysql_data_seek($applicants, 0);
	  $row_applicants = mysql_fetch_assoc($applicants);
  }
?>
</select></p>


<p>Job <select name="job">
  <?php
do {  
?>
  <option value="<?php echo $row_jobs['id']?>"><?php echo $row_jobs['jobtitle']?></option>
  <?php
} while ($row_jobs = mysql_fetch_assoc($jobs));
  $rows = mysql_num_rows($jobs);
  if($rows > 0) {
      mysql_data_seek($jobs, 0);
	  $row_jobs = mysql_fetch_assoc($jobs);
  }
?>
</select>
</p>
<p>Close Date <input name="closedate" type="text" class="calendarSelectDate" ></p>

<input type="hidden" name="closed" value="closed">
<input name="submit" type="submit" id="submit" value="Fill Job">
<input type="hidden" name="MM_update" value="close">
</form>


<?php require_once('assets/wrapper/footer.php'); ?>
<?php
mysql_free_result($jobs);

mysql_free_result($applicants);
?>
