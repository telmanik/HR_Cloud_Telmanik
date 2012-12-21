<?php require_once('Connections/hrcloud.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_displayapplicants = 10;
$pageNum_displayapplicants = 0;
if (isset($_GET['pageNum_displayapplicants'])) {
  $pageNum_displayapplicants = $_GET['pageNum_displayapplicants'];
}
$startRow_displayapplicants = $pageNum_displayapplicants * $maxRows_displayapplicants;

$colname_displayapplicants = "-1";
if (isset($_GET['jobapplyed'])) {
  $colname_displayapplicants = $_GET['jobapplyed'];
}
mysql_select_db($database_hrcloud, $hrcloud);
$query_displayapplicants = sprintf("SELECT * FROM applicants WHERE jobapplyed = %s ORDER BY id ASC", GetSQLValueString($colname_displayapplicants, "text"));
$query_limit_displayapplicants = sprintf("%s LIMIT %d, %d", $query_displayapplicants, $startRow_displayapplicants, $maxRows_displayapplicants);
$displayapplicants = mysql_query($query_limit_displayapplicants, $hrcloud) or die(mysql_error());
$row_displayapplicants = mysql_fetch_assoc($displayapplicants);

if (isset($_GET['totalRows_displayapplicants'])) {
  $totalRows_displayapplicants = $_GET['totalRows_displayapplicants'];
} else {
  $all_displayapplicants = mysql_query($query_displayapplicants);
  $totalRows_displayapplicants = mysql_num_rows($all_displayapplicants);
}
$totalPages_displayapplicants = ceil($totalRows_displayapplicants/$maxRows_displayapplicants)-1;

$colname_jobsname = "-1";
if (isset($_GET['jobapplyed'])) {
  $colname_jobsname = $_GET['jobapplyed'];
}
mysql_select_db($database_hrcloud, $hrcloud);
$query_jobsname = sprintf("SELECT * FROM jobs WHERE id = %s", GetSQLValueString($colname_jobsname, "int"));
$jobsname = mysql_query($query_jobsname, $hrcloud) or die(mysql_error());
$row_jobsname = mysql_fetch_assoc($jobsname);
$totalRows_jobsname = mysql_num_rows($jobsname);

$queryString_displayapplicants = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_displayapplicants") == false && 
        stristr($param, "totalRows_displayapplicants") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_displayapplicants = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_displayapplicants = sprintf("&totalRows_displayapplicants=%d%s", $totalRows_displayapplicants, $queryString_displayapplicants);
 $title = "View Applicants"; ?>
<?php require_once('assets/wrapper/header.php'); ?>


<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="get" name="viewapplicants">
<p>View Applicants for this job - <?php echo $row_jobsname['jobtitle']; ?></p>
  <?php do { ?>
    <table width="800" border="0">
      <tr>
        <td width="200"><?php echo $row_displayapplicants['name']; ?></td>
        <td width="200"><?php echo $row_displayapplicants['phone']; ?></td>
        <td width="200"><?php echo $row_displayapplicants['email']; ?></td>
        <td width="200"><?php echo $row_displayapplicants['notes']; ?></td>
      </tr>
  </table>
    <?php } while ($row_displayapplicants = mysql_fetch_assoc($displayapplicants)); ?>
    <table border="0">
      <tr>
        <td><?php if ($pageNum_displayapplicants > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_displayapplicants=%d%s", $currentPage, 0, $queryString_displayapplicants); ?>">First</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_displayapplicants > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_displayapplicants=%d%s", $currentPage, max(0, $pageNum_displayapplicants - 1), $queryString_displayapplicants); ?>">Previous</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_displayapplicants < $totalPages_displayapplicants) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_displayapplicants=%d%s", $currentPage, min($totalPages_displayapplicants, $pageNum_displayapplicants + 1), $queryString_displayapplicants); ?>">Next</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_displayapplicants < $totalPages_displayapplicants) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_displayapplicants=%d%s", $currentPage, $totalPages_displayapplicants, $queryString_displayapplicants); ?>">Last</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>
</form>

<?php require_once('assets/wrapper/footer.php'); ?>
<?php
mysql_free_result($displayapplicants);

mysql_free_result($jobsname);
?>
