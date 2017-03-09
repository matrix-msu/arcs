<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Assets Helper
 *
 * The Assets Helper checks the application debug configuration and uses
 * it to determine how assets should be outputted.
 */
class SearchHelper extends AppHelper {
  public $helpers = array('Html');
  private $months = array(
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
  );
  public function getMonths() {
    return $this->months;
  }
  public function printMonthOptions() {
    foreach ($this->months as $month) {
      echo "<option value=\"$month\">$month</option>";
    }
  }
  public function printDayOptions() {
    for ($i=1; $i <= 31; $i++) {
      echo "<option value=\"$i\">$i</option>";
    }
  }
  public function printYearOptions($min, $max, $step) {
    for ($i = $min; $i <= $max; $i += $step) {
      echo "<option value=\"$i\">$i</option>";
    }
  }
  public function printControlList($list) {
    foreach ($list as $control) {
      echo "<option value=\"$control\">$control</option>";
    }
  }
}
