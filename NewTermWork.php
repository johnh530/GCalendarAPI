<?php
// for debugging
ini_set("display_errors", 1);
// Authenticate and pick up Calendar object
require_once("AuthorizeCalendar.php");
?>
<body>
New Term Calendar:
<FORM action="CopyActWork.php" method = "POST">
  <TABLE>
    <TR><TD>Calendar</TD>
      <TD><SELECT name="CalendarId">
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
    <TR><TD>From Term</TD>
<TD><SELECT name=FromMap>
<?php // iterate over files looking for map files
$Files = scandir(".");
foreach ($Files as $File){
    if (strpos($File,"Map") === 0){
        echo "<OPTION value=\"$File\"> $File";
    }
}
?>
</TD></TR>
    <TR><TD>To Term</TD>
<TD><SELECT name=ToMap>
<?php
$Files = scandir(".");
foreach ($Files as $File){
    if (strpos($File,"Map") === 0){
        echo "<OPTION value=\"$File\"> $File";
    }
}
?>
</TD></TR>
      <TR><TD colspan=2 align=center><INPUT type=SUBMIT value="New Term- (May take a while)"></TD></TR>
  </TABLE>
</FORM>
