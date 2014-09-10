<?php
// for debugging
ini_set("display_errors", 1);

// Authenticate and pick up Calendar object
require_once("AuthorizeCalendar.php");

// on entry posted variables FromCalendarId, fromdatepicker, todatepicker, ToCalendarId

// convert to RFC3339
$FromDateTime = date_format(date_create($_POST['FromDate']),DATE_RFC3339);

// Add 1 day to ToDate
$DayAfter = date_add(date_create($_POST['ToDate']),
    date_interval_create_from_date_string('1 day'));
$ToDateTime= date_format($DayAfter,DATE_RFC3339);

//calendar ids
$CalendarId = $_POST['CalendarId'];

// we now have calendarids and range of dates in DateTime Format we can iterate
// over the from calendar

$events = $CalendarService->events->ListEvents($CalendarId, array(
    'timeMin' => $FromDateTime,
    'timeMax' => $ToDateTime));
while(true) {
  foreach ($events->getItems() as $event) {
    if (isset($event['start']['date'])){
      echo $event['start']['date'] . " - " . $event['summary'] . "<br>";;
      $CalendarService->events->delete($CalendarId, $event['id']);
      exit;
    }
  }
  $pageToken = $events->getNextPageToken();
  if ($pageToken) {
    $optParams = array(
      'pageToken' => $pageToken,
      'timeMin' => $FromDateTime,
      'timeMax' => $ToDateTime);
    $events = $service->events->listEvents($CalendarId, $optParams);
  } else {
    break;
  }
}
?>
