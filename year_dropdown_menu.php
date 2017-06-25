<?php
/*
The following function will create a dropdown menu with the following options:
$start_year: the starting year (required)
$end_year: select and end year (if left blank, the current year becomes the selected end year )
$id: the html name/id of the dropdown
$selected: this is the 'selected' year

*/
function yearDropdownMenu($start_year, $end_year = null, $id , $selected = null) {
 
    // current year as end year
	$end_year = is_null($end_year) ? date('Y') : $end_year;

	// the current year if end year is not specified
    $selected = is_null($selected) ? date('Y') : $selected;

    // range of years
    $range = range($start_year, $end_year);

    //create the HTML select with name and id
    $select = '<select name="' . $id . '" id="' . $id . '">';
    foreach( $range as $year ) {
        $select .= "<option value=\"$year\"";
        $select .= ($year == $selected) ? ' selected="selected"' : '';
        $select .= ">$year</option>\n";
    }
    $select .= '</select>';
    return $select;
}
// Examples:
echo yearDropdownMenu(2000, null, 'year_select'); // 2000 -- current_year

echo yearDropdownMenu(2000, 2015, 'year_select' );  // 2000 -- 2015

echo yearDropdownMenu(2000, 2015, 'year_select' , 2010);  // 2000 -- 2015, 2010 selected year

echo yearDropdownMenu(2000, null, 'year_select' , 2013); // 2000 -- current_year,  2013 selected year

