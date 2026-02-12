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
        "bottom-small" => "u--pb-8 u--pb-tabletm-5",
        "bottom-medium" => "u--pb-10 u--pb-tabletm-7",
        "bottom-large" => "u--pb-15 u--pb-tabletm-10",
        "bottom-extra-large" => "u--pb-22 u--pb-tabletm-15",
        "top-small" => "u--pt-8 u--pt-tabletm-5",
        "top-medium" => "u--pt-10 u--pt-tabletm-7",
        "top-large" => "u--pt-15 u--pt-tabletm-10",
        "top-extra-large" => "u--pt-22 u--pt-tabletm-15",
        // MIXED OPTIONS
        "top-small bottom-small" => "u--pt-8 u--pt-tabletm-5 u--pb-8 u--pb-tabletm-5",
        "top-small bottom-medium" => "u--pt-8 u--pt-tabletm-5 u--pb-10 u--pb-tabletm-7",
        "top-small bottom-large" => "u--pt-8 u--pt-tabletm-5 u--pb-15 u--pb-tabletm-10",
        "top-small bottom-extra-large" => "u--pt-8 u--pt-tabletm-5 u--pb-22 u--pb-tabletm-15",
        "top-medium bottom-small" => "u--pt-10 u--pt-tabletm-7 u--pb-8 u--pb-tabletm-5",
        "top-medium bottom-medium" => "u--pt-10 u--pt-tabletm-7 u--pb-10 u--pb-tabletm-7",
        "top-medium bottom-large" => "u--pt-10 u--pt-tabletm-7 u--pb-15 u--pb-tabletm-10",
        "top-medium bottom-extra-large" => "u--pt-10 u--pt-tabletm-7 u--pb-22 u--pb-tabletm-15",
        "top-large bottom-small" => "u--pt-15 u--pt-tabletm-10 u--pb-8 u--pb-tabletm-5",
        "top-large bottom-medium" => "u--pt-15 u--pt-tabletm-10 u--pb-10 u--pb-tabletm-7",
        "top-large bottom-large" => "u--pt-15 u--pt-tabletm-10 u--pb-15 u--pb-tabletm-10",
        "top-large bottom-extra-large" => "u--pt-15 u--pt-tabletm-10 u--pb-22 u--pb-tabletm-15",
        "top-extra-large bottom-small" => "u--pt-22 u--pt-tabletm-15 u--pb-8 u--pb-tabletm-5",
        "top-extra-large bottom-medium" => "u--pt-22 u--pt-tabletm-15 u--pb-10 u--pb-tabletm-7",
        "top-extra-large bottom-large" => "u--pt-22 u--pt-tabletm-15 u--pb-15 u--pb-tabletm-10",
        "top-extra-large bottom-extra-large" => "u--pt-22 u--pt-tabletm-15 u--pb-22 u--pb-tabletm-15"
    );

    if($space != '-'){
        return $spaces[$space];
    }else{
        return "";
    }
}
?>