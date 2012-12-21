<?php session_start(); ?>

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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_openjobs = 10;
$pageNum_openjobs = 0;
if (isset($_GET['pageNum_openjobs'])) {
  $pageNum_openjobs = $_GET['pageNum_openjobs'];
}
$startRow_openjobs = $pageNum_openjobs * $maxRows_openjobs;

mysql_select_db($database_hrcloud, $hrcloud);
$query_openjobs = "SELECT * FROM jobs WHERE closedoropen = 'closed' ORDER BY id ASC";
$query_limit_openjobs = sprintf("%s LIMIT %d, %d", $query_openjobs, $startRow_openjobs, $maxRows_openjobs);
$openjobs = mysql_query($query_limit_openjobs, $hrcloud) or die(mysql_error());
$row_openjobs = mysql_fetch_assoc($openjobs);

if (isset($_GET['totalRows_openjobs'])) {
  $totalRows_openjobs = $_GET['totalRows_openjobs'];
} else {
  $all_openjobs = mysql_query($query_openjobs);
  $totalRows_openjobs = mysql_num_rows($all_openjobs);
}
$totalPages_openjobs = ceil($totalRows_openjobs/$maxRows_openjobs)-1;

$queryString_openjobs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_openjobs") == false && 
        stristr($param, "totalRows_openjobs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_openjobs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_openjobs = sprintf("&totalRows_openjobs=%d%s", $totalRows_openjobs, $queryString_openjobs);
?>
<?php $title = "Closed"; ?>
<?php require_once('assets/wrapper/header.php'); ?>
<?php require_once('assets/wrapper/closedhead.php'); ?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  
  <table width="800" border="0">
 <tr>
    <td>job title</td>
    <td>company</td>
    <td>location</td>
    <td>Open date</td>
    <td>Close date</td>
    <td>View Applicants?</td>
  </tr>
 <?php do { ?>
  <tr>
    <td><?php echo $row_openjobs['jobtitle']; ?></td>
    <td><?php echo $row_openjobs['company']; ?></td>
    <td><?php echo $row_openjobs['location']; ?></td>
    <td><?php echo $row_openjobs['opendate']; ?></td>
    <td><?php echo $row_openjobs['closedate']; ?></td>
     <td><a href="view_applicants.php?jobapplyed=<?php echo $row_openjobs['id']; ?>">View </a></td>
  </tr>
  <?php } while ($row_openjobs = mysql_fetch_assoc($openjobs)); ?>
</table>

<table border="0">
  <tr>
    <td><?php if ($pageNum_openjobs > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_openjobs=%d%s", $currentPage, 0, $queryString_openjobs); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_openjobs > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_openjobs=%d%s", $currentPage, max(0, $pageNum_openjobs - 1), $queryString_openjobs); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_openjobs < $totalPages_openjobs) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_openjobs=%d%s", $currentPage, min($totalPages_openjobs, $pageNum_openjobs + 1), $queryString_openjobs); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_openjobs < $totalPages_openjobs) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_openjobs=%d%s", $currentPage, $totalPages_openjobs, $queryString_openjobs); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</p>
</form>

<?php
mysql_free_result($openjobs);
?>
<?php require_once('assets/wrapper/footer.php'); ?>