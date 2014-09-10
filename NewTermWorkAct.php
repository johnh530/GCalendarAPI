<?php
// for debugging
ini_set("display_errors", 1);

// Authenticate and pick up Calendar object
require_once("AuthorizeCalendar.php");

// on entry posted variables CalendarId, FromMap, ToMap

require($_POST['FromMap']);
$FromMeta = $Map;
require($_POST['ToMap']);
$ToMeta = $Map;
require("NewTermMakeMap.php");

//make map of lecture daes 
$Map = MakeMap($FromMeta, $ToMeta);

//calendar id
$CalendarId = $_POST['CalendarId'];

// convert to RFC3339
$FromDateTime = date_format(date_create($FromMeta['start']), DATE_RFC3339);
$ToDateTime = date_format(date_create($FromMeta['stop']), DATE_RFC3339);


// we now have calendarids and range of dates in DateTime Format we can iterate
// over the from calendar

$events = $CalendarService->events->ListEvents($CalendarId, array(
    'timeMin' => $FromDateTime,
    'timeMax' => $ToDateTime));
while(true) {
  foreach ($events->getItems() as $OldEvent) {
    if (isset($OldEvent['recurrence'])){ // skip recurring events
        echo "Skipping - Recurrence event<br>";
        continue;
    }
    if (!isset($OldEvent['start']['date'])){
        echo "Skipping - No start date<br>";
        continue;
    }
    $Date = $OldEvent['start']['date'];// get old date
    echo "$Date: " . $OldEvent['summary'];
    if (!isset($Map[$Date])){
	echo " - Skipping - No map date<br>";
	continue;
    }
    $startDate = new Google_Service_Calendar_EventDateTime();
    $startDate->setDate($Map[$Date]);
    echo " to " . $Map[$Date];
    if (!isset($OldEvent['end']['date']))
      die(" - start date with no end date!");
    $DateObject = date_create($Map[$Date]);
    date_modify($DateObject, "+ 1 day");
    // have dates for new event - creat a new event and fill
    $NewEvent = new Google_Service_Calendar_Event();
    $NewEvent->setSummary($OldEvent['summary']);
    if (isset($OldEvent['colorId'])) {
        echo " - " . $OldEvent['colorId'];
        $NewEvent->setColorId($OldEvent['colorId']);
    }
    $endDate = new Google_Service_Calendar_EventDateTime();
    $endDate->setDate(date_format($DateObject, 'Y-m-d'));
    $NewEvent->setStart($startDate);
    $NewEvent->setEnd($endDate);
    echo "<br>";
    flush();
    $CalendarService->events->insert($CalendarId, $NewEvent);
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
