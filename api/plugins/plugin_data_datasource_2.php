<?php

//FlowName: 基础数据同步

function plugin_data_datasource_2_init_default()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_add_default_data_before_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_add_default_data_after_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    /*
    $sql        = "select * from `$TableName` where id = '$id'";
    $rs         = $db->Execute($sql);
    $rs_a       = $rs->GetArray();
    foreach($rs_a as $Line)  {
        //
    }
    */
}

function plugin_data_datasource_2_edit_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_edit_default_data_before_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_edit_default_data_after_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_edit_default_configsetting_data($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    $数据库地址     = $_POST['数据库地址'];
    $数据库用户名   = $_POST['数据库用户名'];
    $数据库密码     = $_POST['数据库密码'];
    $数据库名称     = "TD_OA";
    $db_remote = NewADOConnection($DB_TYPE);
    $db_remote->connect($数据库地址, $数据库用户名, $数据库密码, $数据库名称);
    $db_remote->Execute("Set names utf8;");
    $db_remote->setFetchMode(ADODB_FETCH_ASSOC);
    $databases = $db_remote->MetaDatabases();
    if($db_remote->databaseName!="" && $db_remote->databaseName==$数据库名称 && in_array($数据库名称, $databases)) {
        //$sql = "delete from user where USER_ID!='admin'";
        //$db->Execute($sql);
        $sql = "select * from user where LIMIT_LOGIN=0 and NOT_LOGIN=0";
        $rsR = $db_remote->Execute($sql);
        $rs_a = $rsR->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $Element = [];
            $Element['USER_ID']         = $rs_a[$i]['BYNAME'];
            $Element['USER_NAME']       = $rs_a[$i]['USER_NAME'];
            $Element['DEPT_ID']         = $rs_a[$i]['DEPT_ID'];
            $Element['USER_NO']         = $rs_a[$i]['USER_NO'];
            $Element['BIRTHDAY']        = $rs_a[$i]['BIRTHDAY'];
            $Element['EMAIL']           = $rs_a[$i]['EMAIL'];
            $Element['USER_PRIV_OTHER']         = $rs_a[$i]['USER_PRIV_OTHER'];
            //$Element['DEPT_ID_OTHER']           = $rs_a[$i]['DEPT_ID_OTHER'];
            $Element['TEL_NO_DEPT']             = $rs_a[$i]['TEL_NO_DEPT'];
            $Element['USER_PRIV']               = $rs_a[$i]['USER_PRIV'];
            $Element['USER_PRIV_OTHER']         = $rs_a[$i]['USER_PRIV_OTHER'];
            $Element['USER_PRIV']               = $rs_a[$i]['USER_PRIV'];
            InsertOrUpdateTableByArray($TableName="data_user",$Element,"USER_ID",0,"Insert");  
            //print_R($RS);
        }
        $sql = "select * from user_priv";
        $rs = $db_remote->Execute($sql);
        $rs_a = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $Element = [];
            $Element['id']          = $rs_a[$i]['USER_PRIV'];
            $Element['name']        = $rs_a[$i]['PRIV_NAME'];
            $Element['content']     = $rs_a[$i]['FUNC_ID_STR'];
            $Element['CreateTime']  = date("Y-m-d H:i:s");
            $Element['Creator']     = "admin";
            InsertOrUpdateTableByArray($TableName="data_role",$Element,"name",0,"Insert");  
        }
        $sql = "select * from department";
        $rs = $db_remote->Execute($sql);
        $rs_a = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $Element = [];
            $Element['id']               = $rs_a[$i]['DEPT_ID'];
            $Element['DEPT_NAME']        = $rs_a[$i]['DEPT_NAME'];
            $Element['TEL_NO']           = $rs_a[$i]['TEL_NO'];
            $Element['DEPT_NO']          = $rs_a[$i]['DEPT_NO'];
            $Element['DEPT_PARENT']      = $rs_a[$i]['DEPT_PARENT'];
            $Element['MANAGER']          = $rs_a[$i]['MANAGER'];
            $Element['LEADER1']          = $rs_a[$i]['LEADER1'];
            $Element['LEADER2']          = $rs_a[$i]['LEADER2'];
            $Element['DESCRIPTION']      = $rs_a[$i]['DEPT_FUNC'];
            InsertOrUpdateTableByArray($TableName="data_department",$Element,"id",0);  
            //print_R($RS);
        }
        $sql    = "select * from td_edu.edu_xi";
        $rs     = $db_remote->Execute($sql);
        $rs_a   = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $Element = [];
            $Element['系部名称']            = $rs_a[$i]['系名称'];
            $Element['系部代码']            = $rs_a[$i]['系代码'];
            $Element['系部负责人1']         = $rs_a[$i]['专业科科长'];
            $Element['系部负责人2']         = $rs_a[$i]['专业科副科长'];
            $Element['教学秘书']            = $rs_a[$i]['教学秘书'];
            $Element['系部简介']            = $rs_a[$i]['系简介'];
            $Element['学籍二级管理']        = $rs_a[$i]['学籍二级管理'];
            $Element['学生成绩二级管理']     = $rs_a[$i]['成绩二级管理'];
            InsertOrUpdateTableByArray($TableName="data_xi",$Element,"系部名称",0);  
            //print_R($RS);
        }
        $sql    = "select * from td_edu.edu_zhuanye";
        $rs     = $db_remote->Execute($sql);
        $rs_a   = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $sql        = "select * from td_edu.edu_xi where 系代码='".$rs_a[$i]['所属系']."'";
            $rs         = $db_remote->Execute($sql);
            $所属系部    = $rs->fields['系名称'];
            $Element    = [];
            $Element['专业名称']            = $rs_a[$i]['专业名称'];
            $Element['专业代码']            = $rs_a[$i]['专业代码'];
            $Element['所属系部']            = $所属系部;
            $Element['学制']                = $rs_a[$i]['学制'];
            $Element['学位']                = $rs_a[$i]['学位'];
            InsertOrUpdateTableByArray($TableName="data_zhuanye",$Element,"专业名称",0);  
        }
        $sql    = "select * from td_edu.edu_banjidata where 毕业时间>'".date("Y-m-d")."'";
        $rs     = $db_remote->Execute($sql);
        $rs_a   = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            $sql        = "select * from td_edu.edu_xi where 系代码='".$rs_a[$i]['所属系']."'";
            $rs         = $db_remote->Execute($sql);
            $所属系部    = $rs->fields['系名称'];
            $sql        = "select * from td_edu.edu_zhuanye where 专业代码='".$rs_a[$i]['所属专业']."'";
            $rs         = $db_remote->Execute($sql);
            $所属专业    = $rs->fields['专业名称'];
            $Element    = [];
            $Element['班级名称']            = $rs_a[$i]['班级名称'];
            $Element['班级代码']            = $rs_a[$i]['班级代码'];
            $Element['所属系部']            = $所属系部;
            $Element['所属专业']            = $所属专业;
            $Element['入学年份']            = $rs_a[$i]['入学年份'];
            $Element['固定教室']            = $rs_a[$i]['固定教室'];
            $Element['班主任姓名']          = $rs_a[$i]['班主任姓名'];
            $Element['班主任用户名']         = $rs_a[$i]['班主任'];
            $Element['毕业时间']            = $rs_a[$i]['毕业时间'];
            $Element['实习班主任']          = $rs_a[$i]['实习班主任'];
            $Element['所属校区']            = $rs_a[$i]['所属校区'];
            if($rs_a[$i]['是否教学班']=="是") {
                $Element['班级类型']            = "教学班";
            }
            else {
                $Element['班级类型']            = "行政班";
            }
            //print_R($Element);
            InsertOrUpdateTableByArray($TableName="data_banji",$Element,"班级名称",0);  
        }
        //print_R($Element);exit;
        
        $sql    = "select * from td_edu.dorm_building";
        $rs     = $db_remote->Execute($sql);
        $rs_a   = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            //print_R($rs_a[$i]);
            $Element = [];
            $Element['宿舍楼名称']              = $rs_a[$i]['宿舍楼名称'];
            $Element['宿舍总数']                = $rs_a[$i]['宿舍总数'];
            $Element['楼层数']                  = $rs_a[$i]['楼层数'];
            $Element['生管老师一']              = $rs_a[$i]['生管老师一'];
            $Element['管理范围一']              = $rs_a[$i]['管理范围一'];
            $Element['生管老师二']              = $rs_a[$i]['生管老师二'];
            $Element['管理范围二']              = $rs_a[$i]['管理范围二'];
            $Element['生管老师三']              = $rs_a[$i]['生管老师三'];
            $Element['管理范围三']              = $rs_a[$i]['管理范围三'];
            $Element['生管老师四']              = $rs_a[$i]['生管老师四'];
            $Element['管理范围四']              = $rs_a[$i]['管理范围四'];
            $Element['生管老师五']              = $rs_a[$i]['生管老师五'];
            $Element['管理范围五']              = $rs_a[$i]['管理范围五'];
            $Element['生管老师六']              = $rs_a[$i]['生管老师六'];
            $Element['管理范围六']              = $rs_a[$i]['管理范围六'];
            $Element['生管老师七']              = $rs_a[$i]['生管老师七'];
            $Element['管理范围七']              = $rs_a[$i]['管理范围七'];
            $Element['生管老师八']              = $rs_a[$i]['生管老师八'];
            $Element['管理范围八']              = $rs_a[$i]['管理范围八'];
            $Element['生管老师九']              = $rs_a[$i]['生管老师九'];
            $Element['管理范围九']              = $rs_a[$i]['管理范围九'];
            $Element['生管老师十']              = $rs_a[$i]['生管老师十'];
            $Element['管理范围十']              = $rs_a[$i]['管理范围十'];
            //print_R($Element);
            InsertOrUpdateTableByArray($TableName="data_dorm_building",$Element,"宿舍楼名称",0);              
        }

        $sql    = "select * from td_edu.dorm_room";
        $rs     = $db_remote->Execute($sql);
        $rs_a   = $rs->GetArray();
        for($i=0;$i<sizeof($rs_a);$i++) {
            //print_R($rs_a[$i]);
            $Element = [];
            $Element['宿舍房间']                = $rs_a[$i]['房间名称'];
            $Element['宿舍楼']                  = $rs_a[$i]['宿舍楼'];
            $Element['房间性质']                = $rs_a[$i]['房间性质'];
            $Element['床位数']                  = $rs_a[$i]['房间床位数'];
            $Element['所属班级']                = $rs_a[$i]['所属班级'];
            $Element['性别']                    = $rs_a[$i]['性别'];
            $Element['楼层数']                  = $rs_a[$i]['楼层数'];
            //print_R($Element);
            InsertOrUpdateTableByArray($TableName="data_dorm_dorm",$Element,"宿舍房间",0);              
        }

    }
    else {
        $RS = [];
        $RS['status']   = "ERROR";
        $RS['data']     = $data;
        $RS['sql']      = $sql;
        $RS['msg']      = "您输入的数据库连接信息错误,请重新输入.";
        print json_encode($RS);
        exit;  
    }
    //print_R($db_remote->databaseName);
}

function plugin_data_datasource_2_view_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_delete_array($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_updateone($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_datasource_2_import_default_data_before_submit($Element)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    return $Element;
}

function plugin_data_datasource_2_import_default_data_after_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

?>