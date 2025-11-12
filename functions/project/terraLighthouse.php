<?php
if ( function_exists('get_field') ) {
    $emails = get_field('terra_lighthouse_emails', 'option');
    $interval = get_field('terra_lighthouse_interval', 'option');

    if ($emails) {
        $emailList = [];

        foreach ($emails as $row) {
            if (!empty($row['email'])) {
                $emailList[] = $row['email'];
            }
        }

        new TerraLighthouse((object) [
            'email' => implode(',', $emailList),
            'interval' => $interval ?? 300000,
            'url' => 'https://www.sei.com/',
        ]);
    }
}
?>
