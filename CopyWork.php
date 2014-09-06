<?php
// for debugging
ini_set("display_errors", 1);
// Authenticate and pick up Calendar object
require_once("AuthorizeCalendar.php");
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Datepicker - Display month &amp; year menus</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#fromdatepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#todatepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  </script>
</head>
<body>
Copy Calendar:
<FORM action="CopyActWork.php" method = "POST">
  <TABLE>
    <TR><TD>From Calendar</TD>
      <TD><SELECT name="FromCalendarId">
<?php // iterate over calendars - using the summary and id
$CalendarList = $CalendarService->calendarList->listCalendarList();
while (true){
    foreach ($CalendarList['items'] as $Cal){
	echo "<OPTION value=\"" . $Cal['id']. "\"> " . $Cal['summary'];
    }
    $PageToken = $CalendarList->getNextPageToken();
    if ($PageToken) {
        $OptParams = array('pageToken' => $PageToken);
        $CalendarList = $CalendarService->calendarList->listCalendarList($OptParams);
    } else {
        break;
    }
} 
?>
      </SELECT></TD></TR>
    <TR><TD>Start Date</TD><TD><input type="text" id="fromdatepicker"></TD></TR>
    <TR><TD>Stop Date</TD><TD><input type="text" id="todatepicker"></TD></TR>
    <TR><TD>To Calendar</TD>
      <TD><SELECT name="ToCalendarId">
<?php // iterate over calendars - using the summary and id
$CalendarList = $CalendarService->calendarList->listCalendarList();
while (true){
    foreach ($CalendarList['items'] as $Cal){
	echo "<OPTION value=\"" . $Cal['id']. "\"> " . $Cal['summary'];
    }
    $PageToken = $CalendarList->getNextPageToken();
    if ($PageToken) {
        $OptParams = array('pageToken' => $PageToken);
        $CalendarList = $CalendarService->calendarList->listCalendarList($OptParams);
    } else {
        break;
    }
} 
?>
      </SELECT></TD></TR>
      <TR><TD colspan=2 align=center><INPUT type=SUBMIT value="Copy Calendar"></TD></TR>
  </TABLE>
</FORM>
