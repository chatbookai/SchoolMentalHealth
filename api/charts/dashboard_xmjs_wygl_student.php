<?php
header("Content-Type: application/json"); 
require_once('../cors.php');
require_once('../include.inc.php');

CheckAuthUserLoginStatus();

$RS = [];

$colorArray = ['primary','success','warning','info','error'];

$USER_ID    = ForSqlInjection($GLOBAL_USER->USER_ID);

$厦门技师菜单MAP = [386,387];
$sql    = "select * from data_menutwo where id in ('".join("','",$厦门技师菜单MAP)."') and FaceTo = 'Student' order by MenuOneName, FlowId";
$rs     = $db->Execute($sql);
$rs_a   = $rs->GetArray();
$菜单MAP = [];
$Counter = 0;
foreach($rs_a as $Item) {
    $菜单MAP[$Item['MenuOneName']][] = ['title'=>$Item['MenuTwoName'],'icon'=>'mdi:'.$Item['Menu_Three_Icon'],'url'=>'/apps/'.$Item['id'], 'color'=>$colorArray[$Counter%5]];
    $Counter ++;
}

foreach($菜单MAP as $Key=>$Value) {
    $MenuIcon['Title']       = $Key;
    $MenuIcon['SubTitle']    = "";
    $MenuIcon['grid']        = 12;
    $MenuIcon['data']        = $Value;
    $MenuIcon['type']        = "MenuIcon";
    $RS[]                    = $MenuIcon;
}

print_R(json_encode($RS));



?>