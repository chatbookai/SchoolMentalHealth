<?php

//FlowName: 评价公开课

function plugin_data_gongkaike_5_init_default()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_init_default_filter_RS($RS)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    $评价人用户名   = $GLOBAL_USER->学号;
    $sql = "select * from data_gongkaike_pingjia where 评价人用户名='".$评价人用户名."'";
    $rs   = $db->Execute($sql);
    $rs_a = $rs->GetArray();
    $已经评价数据 = [];
    foreach($rs_a as $Item) {
        $已经评价数据[$Item['开课教师用户名']][$Item['班级']][$Item['课程']][$Item['时间']][$Item['节次']][$Item['类型']] = 1;
    }
    //过滤数据
    $data           = $RS['init_default']['data'];
    $MobileEndData  = $RS['init_default']['MobileEndData'];
    $Counter        = 0;
    foreach($data as $Item) {
        if($已经评价数据[$Item['用户名']][$Item['班级']][$Item['课程']][$Item['时间']][$Item['节次']][$Item['类型']] == 1) {
            $RS['init_default']['MobileEndData'][$Counter]['EditIcon'] = "mdi:eye-outline";
        }
        $Counter ++;
    }
    return $RS;
}

function plugin_data_gongkaike_5_add_default_data_before_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_add_default_data_after_submit($id)  {
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

function plugin_data_gongkaike_5_edit_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    global $FlowId,$AllShowTypesArray;
    //Here is your write code
    //Get All Fields
    $sql                    = "select * from form_configsetting where FlowId='378' and IsEnable='1' order by SortNumber asc, id asc";
    $rs                     = $db->Execute($sql);
    $AllFieldsFromTable     = $rs->GetArray();
    $defaultValuesEdit      = [];
    $allFieldsEdit          = getAllFields($AllFieldsFromTable, $AllShowTypesArray, 'EDIT', $FilterFlowSetting=false, $SettingMap);
    foreach($allFieldsEdit as $ModeName=>$allFieldItem) {
        foreach($allFieldItem as $ITEM) {
            $defaultValuesEdit[$ITEM['name']] = $ITEM['value'];
        }
    }
    //Value
    $sql    = "select * from data_gongkaike where id='$id'";
    $rs     = $db->Execute($sql);
    $评价人用户名   = $GLOBAL_USER->学号;
    $开课教师用户名 = $rs->fields['用户名'];
    $班级 = $rs->fields['班级'];
    $类型 = $rs->fields['类型'];
    $课程 = $rs->fields['课程'];
    $时间 = $rs->fields['时间'];
    $节次 = $rs->fields['节次'];
    $sql  = "select * from data_gongkaike_pingjia where 评价人用户名='$评价人用户名' and 开课教师用户名='$开课教师用户名' and 班级='$班级' and 类型='$类型' and 课程='$课程' and 时间='$时间' and 节次='$节次'";
    $rs   = $db->Execute($sql);
    foreach($rs->fields as $Key=>$Value) {
        $defaultValuesEdit[$Key] = $Value;
    }

    //print_R($AllShowTypesArray);
    //print $sql;
    $RS['edit_default']['allFields']        = $allFieldsEdit;
    $RS['edit_default']['allFieldsMode']    = [['value'=>"Default", 'label'=>__("")]];
    $RS['edit_default']['defaultValues']    = $defaultValuesEdit;
    $RS['edit_default']['dialogContentHeight']  = "90%";
    $RS['edit_default']['submitaction']     = "edit_default_data";
    $RS['edit_default']['componentsize']    = "small";
    if($defaultValuesEdit['提交状态']!='是')            {
        $RS['edit_default']['submittext']       = $SettingMap['Rename_Edit_Submit_Button'];
    }
    $RS['edit_default']['canceltext']       = __("Cancel");
    $RS['edit_default']['titletext']        = $SettingMap['Edit_Title_Name'];
    $RS['edit_default']['titlememo']        = $SettingMap['Edit_Subtitle_Name'];
    $RS['edit_default']['tablewidth']       = 650;
    $RS['edit_default']['submitloading']    = __("SubmitLoading");
    $RS['edit_default']['loading']          = __("Loading");
    
    $RS['forceuse'] = true;
    $RS['status']   = "OK";
    $RS['data']     = $defaultValuesEdit;
    $RS['sql']      = $sql;
    $RS['msg']      = __("Get Data Success");
    print_R(json_encode($RS, true));
    exit;
}

function plugin_data_gongkaike_5_edit_default_data_before_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write codeglobal $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    $sql    = "select * from data_gongkaike where id='$id'";
    $rs     = $db->Execute($sql);
    $Element = [];
    $Element['评价人用户名']    = $GLOBAL_USER->学号;
    $Element['评价人姓名']      = $GLOBAL_USER->姓名;
    $Element['评价人部门']      = $GLOBAL_USER->班级;
    $Element['开课教师用户名']  = $rs->fields['用户名'];
    $Element['开课教师姓名']    = $rs->fields['姓名'];
    $Element['班级'] = $rs->fields['班级'];
    $Element['类型'] = $rs->fields['类型'];
    $Element['课程'] = $rs->fields['课程'];
    $Element['时间'] = $rs->fields['时间'];
    $Element['节次'] = $rs->fields['节次'];
    $Element['学期'] = $rs->fields['学期'];
    $Element['教师所属系部'] = returntablefield("data_user","USER_ID",$rs->fields['用户名'],"DEPT_ID")['DEPT_ID'];
    $Element['星期'] = $rs->fields['星期'];

    $Element['教案格式及内容']  = $_POST['教案格式及内容'];
    $Element['教案教学策略']    = $_POST['教案教学策略'];
    $Element['教学目标及重难点'] = $_POST['教学目标及重难点'];
    $Element['教学实施情况']    = $_POST['教学实施情况'];
    $Element['教学方法和手段应用'] = $_POST['教学方法和手段应用'];
    $Element['教学内容及板书'] = $_POST['教学内容及板书'];
    $Element['师生互动'] = $_POST['师生互动'];
    $Element['教仪教态'] = $_POST['教仪教态'];
    $Element['学生学习效果'] = $_POST['学生学习效果'];
    $Element['教学整体印象'] = $_POST['教学整体印象'];
    $Element['优点与不足及建议'] = $_POST['优点与不足及建议'];

    $Element['总分']        = $_POST['教案格式及内容'] + $_POST['教案教学策略'] + $_POST['教学目标及重难点'] + $_POST['教学实施情况'] + $_POST['教学方法和手段应用'] + $_POST['教学内容及板书'] + $_POST['师生互动'] + $_POST['教仪教态'] + $_POST['学生学习效果'] + $_POST['教学整体印象'];
    $Element['提交状态']    = $_POST['提交状态'];
    $Element['提交时间']    = date("Y-m-d H:i:s");
    $Element['提交人']      = $GLOBAL_USER->学号;

    $ImportUniqueFields = ['评价人用户名','开课教师用户名','班级','课程','时间','节次','类型'];

    InsertOrUpdateTableByArray('data_gongkaike_pingjia',$Element,join(',',$ImportUniqueFields),0,'InsertOrUpdate');

    $RS['status']   = "OK";
    $RS['msg']      = $SettingMap['Tip_When_Edit_Success'];
    $RS['_POST']   = $_POST;
    
    print_R(json_encode($RS, true));
    exit;
}

function plugin_data_gongkaike_5_edit_default_data_after_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_edit_default_configsetting_data($id)  {
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

function plugin_data_gongkaike_5_view_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_delete_array($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_updateone($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_gongkaike_5_import_default_data_before_submit($Element)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    return $Element;
}

function plugin_data_gongkaike_5_import_default_data_after_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

?>