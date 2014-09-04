<?php
// for debugging
ini_set("display_errors", 1);
// Authenticate and pick up Calendar object
require_once("AuthorizeCalendar.php");
?>
Select Calendar:
<FORM action="DisplayCalendar.php" method = POST>
  <TABLE>
   <TR><TD>Which Calendar</TD>
     <TD><SELECT name=CalendarId>
<?php // iterate over calendars - using the summary and id
$CalendarList = $Calendar->calendarList->listCalendarList();
foreach ($CalendarList['items'] as $Cal){
    echo "<OPTION value=\"" . $Cal['id']. "\"> " . $Cal['summary'] . " - id: " .$Cal['id'];
}
?>
      </SELECT></td></tr>
  </table>
</FORM>
