<?php 
/**
 *  RETURNS THE Target of a link
 *  IF NO ALT, RETURNS THE FILENAME
 *  @author: Nerea
 */
//get link target

function get_spacing($space)
{
    $spaces = array(
        "bottom-small" => "f--pb-8 f--pb-tablets-5",
        "bottom-medium" => "f--pb-10 f--pb-tablets-7",
        "bottom-large" => "f--pb-15 f--pb-tablets-10",
        "bottom-extra-large" => "f--pb-22 f--pb-tablets-15",
        "top-small" => "f--pt-8 f--pt-tablets-5",
        "top-medium" => "f--pt-10 f--pt-tablets-7",
        "top-large" => "f--pt-15 f--pt-tablets-10",
        "top-extra-large" => "f--pt-22 f--pt-tablets-15",
        // MIXED OPTIONS
        "top-small bottom-small" => "f--pt-8 f--pt-tablets-5 f--pb-8 f--pb-tablets-5",
        "top-small bottom-medium" => "f--pt-8 f--pt-tablets-5 f--pb-10 f--pb-tablets-7",
        "top-small bottom-large" => "f--pt-8 f--pt-tablets-5 f--pb-15 f--pb-tablets-10",
        "top-small bottom-extra-large" => "f--pt-8 f--pt-tablets-5 f--pb-22 f--pb-tablets-15",
        "top-medium bottom-small" => "f--pt-10 f--pt-tablets-7 f--pb-8 f--pb-tablets-5",
        "top-medium bottom-medium" => "f--pt-10 f--pt-tablets-7 f--pb-10 f--pb-tablets-7",
        "top-medium bottom-large" => "f--pt-10 f--pt-tablets-7 f--pb-15 f--pb-tablets-10",
        "top-medium bottom-extra-large" => "f--pt-10 f--pt-tablets-7 f--pb-22 f--pb-tablets-15",
        "top-large bottom-small" => "f--pt-15 f--pt-tablets-10 f--pb-8 f--pb-tablets-5",
        "top-large bottom-medium" => "f--pt-15 f--pt-tablets-10 f--pb-10 f--pb-tablets-7",
        "top-large bottom-large" => "f--pt-15 f--pt-tablets-10 f--pb-15 f--pb-tablets-10",
        "top-large bottom-extra-large" => "f--pt-15 f--pt-tablets-10 f--pb-22 f--pb-tablets-15",
        "top-extra-large bottom-small" => "f--pt-22 f--pt-tablets-15 f--pb-8 f--pb-tablets-5",
        "top-extra-large bottom-medium" => "f--pt-22 f--pt-tablets-15 f--pb-10 f--pb-tablets-7",
        "top-extra-large bottom-large" => "f--pt-22 f--pt-tablets-15 f--pb-15 f--pb-tablets-10",
        "top-extra-large bottom-extra-large" => "f--pt-22 f--pt-tablets-15 f--pb-22 f--pb-tablets-15"
    );

    if($space != '-'){
        return $spaces[$space];
    }else{
        return "";
    }
}
?>