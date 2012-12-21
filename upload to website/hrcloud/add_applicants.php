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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addapplicants")) {
  $insertSQL = sprintf("INSERT INTO applicants (name, address, address2, city, `state`, zip, phone, email, jobapplyed, notes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['addresstwo'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['zip'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['jobapplyed'], "text"),
                       GetSQLValueString($_POST['notes'], "text"));

  mysql_select_db($database_hrcloud, $hrcloud);
  $Result1 = mysql_query($insertSQL, $hrcloud) or die(mysql_error());

  $insertGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_hrcloud, $hrcloud);
$query_jobs = "SELECT * FROM jobs WHERE closedoropen = 'open'";
$jobs = mysql_query($query_jobs, $hrcloud) or die(mysql_error());
$row_jobs = mysql_fetch_assoc($jobs);
$totalRows_jobs = mysql_num_rows($jobs);
 $title = "Add Applicants"; ?>
<?php require_once('assets/wrapper/header.php'); ?>

<p>Add Applicants</p>


<form action="<?php echo $editFormAction; ?>" name="addapplicants" method="POST">

<p>Name<input name="name" type="text"></p>
<p>Address <input name="address" type="text"></p>
<p>Address 2 <input name="addresstwo" type="text"></p>
<p>City <input name="city" type="text"></p>
<p>State <input name="state" type="text"></p>
<p>Zip <input name="zip" type="text"></p>
<p>Phone <input name="phone" type="text"></p>
<p>Email <input name="email" type="text"></p>
<select name="jobapplyed">
  <option value="">Please Select</option>
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
<p>Notes: <textarea name="notes" cols="20" rows="5"></textarea></p>
<p><input name="submit" type="submit" id="submit" value="Add Job">
  <input type="hidden" name="MM_insert" value="addapplicants">
</form>
<?php require_once('assets/wrapper/footer.php'); ?>
<?php
mysql_free_result($jobs);
?>
