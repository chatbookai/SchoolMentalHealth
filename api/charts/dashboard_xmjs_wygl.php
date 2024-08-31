<?php
header("Content-Type: application/json"); 
require_once('../cors.php');
require_once('../include.inc.php');

CheckAuthUserLoginStatus();

$optionsMenuItem = $_GET['optionsMenuItem'];
if($optionsMenuItem=="")  {
    $optionsMenuItem = "当前学期";
}
$RS = [];

$学期 = returntablefield("data_xueqi","当前学期","是","学期名称")['学期名称'];
$colorArray = ['primary','success','warning','info','error'];

$USER_ID    = ForSqlInjection($GLOBAL_USER->USER_ID);


function 得到数字化校园权限($新旧权限映射) {
    global $db;
	global $GLOBAL_USER;
    $USER_ID    = ForSqlInjection($GLOBAL_USER->USER_ID);
    $sql        = "select * from td_edu.user where USER_ID='$USER_ID'";
	$rs         = $db->Execute($sql);
	$rs_a       = $rs->GetArray();
    $USER_PRIV_ALL  = $rs_a[0]['USER_PRIV'].','.$rs_a[0]['USER_PRIV_OTHER'];
	$sql            = "select * from td_edu.systemprivate where ID in ('".str_replace(',',"','",$USER_PRIV_ALL)."')";
	$rs             = $db->Execute($sql);
	$rs_a           = $rs->GetArray();
    $LOGIN_USER_PRIV_TEXT_ARRAY         = [];
	for($i=0;$i<sizeof($rs_a);$i++)		{
		$LOGIN_USER_PRIV_TEXT_ARRAY[]   = $rs_a[$i]['CONTENT'];
	}
    $LOGIN_USER_PRIV_TEXT_ARRAY_TEXT = join(',',$LOGIN_USER_PRIV_TEXT_ARRAY);
    $LOGIN_USER_PRIV_TEXT_ARRAY = explode(',',$LOGIN_USER_PRIV_TEXT_ARRAY_TEXT);
    $LOGIN_USER_PRIV_TEXT_ARRAY = @array_flip($LOGIN_USER_PRIV_TEXT_ARRAY);
    $LOGIN_USER_PRIV_TEXT_ARRAY = @array_flip($LOGIN_USER_PRIV_TEXT_ARRAY);
    $LOGIN_USER_PRIV_TEXT_ARRAY = @array_values($LOGIN_USER_PRIV_TEXT_ARRAY);
    $菜单列表NEW = [];
    foreach($新旧权限映射 as $旧名称=>$新名称) {
        if(in_array($旧名称, $LOGIN_USER_PRIV_TEXT_ARRAY)) {
            $菜单列表NEW[] = $新名称;
        }
    }
	return $菜单列表NEW;
}

$菜单列表 = [];
$菜单列表[] = "报修信息";
$菜单列表[] = "宿管员审核";
$菜单列表[] = "报修受理";
$菜单列表[] = "维修组长派单";
$菜单列表[] = "确认维修";
$菜单列表[] = "服务评价";
$新旧权限映射['后勤管理-网上报修-报修信息']     = "报修信息";
$新旧权限映射['后勤管理-网上报修-宿管员审核']   = "宿管员审核";
$新旧权限映射['后勤管理-网上报修-报修受理']     = "报修受理";
$新旧权限映射['后勤管理-网上报修-维修组长派单'] = "维修组长派单";
$新旧权限映射['后勤管理-网上报修-确认维修']     = "确认维修";
$新旧权限映射['后勤管理-网上报修-服务评价']     = "服务评价";
//$菜单列表NEW = 得到数字化校园权限($新旧权限映射);

$sql    = "select * from data_menutwo where MenuTwoName in ('".join("','",$菜单列表)."') and FaceTo = 'AuthUser' order by MenuOneName, FlowId";
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