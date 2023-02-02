<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 


    if($_POST['action'] == 'service'){
        if(empty($_POST['service_pack'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `service_packs` WHERE `id` = '".check_string($_POST['service_pack'])."' ")) {
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => __($row['content'])
                ]));
            }
            $ck = 0;
            if(isset($_POST['token'])){
                if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
                    $ck = $getUser['chietkhau'];
                }
            }
            $amount = check_string($_POST['amount']);
            $total = $amount * $row['price'];
            $total = $total - $total * $ck / 100;
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'msg'   => __($row['content'])
            ]));
        }
    }

    die(format_currency(0));
    
}
die(format_currency(0));
