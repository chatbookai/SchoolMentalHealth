<?php

//FlowName: 我的选课

$开放学生选课学期 = "2023-2024-第二学期";
$选课启用轮数 = "1";
$第一轮选课开始时间 = "2024-02-28 12:10:00";
$第一轮选课结束时间 = "2024-03-10 16:20:00";
$第二轮选课开始时间 = "";
$第二轮选课结束时间 = "";
$第三轮选课开始时间 = "";
$第三轮选课结束时间 = "";
$第四轮选课开始时间 = "";
$第四轮选课结束时间 = "";
$每一轮允许学生选修的课程门数 = 1;
$每学期选课数      = 1;



function plugin_data_xuanke_record_2_init_default()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_init_default_filter_RS($RS)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    global $FlowId,$AllShowTypesArray;
    //Here is your write code
    //Get All Fields
    $defaultValuesAdd      = [];
    
    global $开放学生选课学期;
    global $选课启用轮数;
    global $第一轮选课开始时间;
    global $第一轮选课结束时间;
    global $每一轮允许学生选修的课程门数;
    $defaultValuesAdd['选课学期'] = $开放学生选课学期;
    $defaultValuesAdd['选课轮数'] = $选课启用轮数;
    $defaultValuesAdd['开始时间'] = $第一轮选课开始时间;
    $defaultValuesAdd['结束时间'] = $第一轮选课结束时间;
    $defaultValuesAdd['允许选课门数'] = $每一轮允许学生选修的课程门数;

    $allFieldsAdd['Default'][0]['name'] = '选课学期';
    $allFieldsAdd['Default'][0]['label'] = '选课学期';
    $allFieldsAdd['Default'][0]['value'] = '';
    $allFieldsAdd['Default'][0]['placeholder'] = '';
    $allFieldsAdd['Default'][0]['helptext'] = '';
    $allFieldsAdd['Default'][0]['show'] = true;
    $allFieldsAdd['Default'][0]['FieldTypeArray'] = ['input'];
    $allFieldsAdd['Default'][0]['type'] = 'input';
    $allFieldsAdd['Default'][0]['rules'] = ["required"=> false, "xs"=> 12, "sm"=> 6, "disabled"=> true, "min"=> 0, "max"=> 0 ];

    $allFieldsAdd['Default'][1]['name'] = '开始时间';
    $allFieldsAdd['Default'][1]['label'] = '开始时间';
    $allFieldsAdd['Default'][1]['value'] = '';
    $allFieldsAdd['Default'][1]['placeholder'] = '';
    $allFieldsAdd['Default'][1]['helptext'] = '';
    $allFieldsAdd['Default'][1]['show'] = true;
    $allFieldsAdd['Default'][1]['FieldTypeArray'] = ['input'];
    $allFieldsAdd['Default'][1]['type'] = 'input';
    $allFieldsAdd['Default'][1]['rules'] = ["required"=> false, "xs"=> 12, "sm"=> 6, "disabled"=> true, "min"=> 0, "max"=> 0 ];

    $allFieldsAdd['Default'][2]['name'] = '结束时间';
    $allFieldsAdd['Default'][2]['label'] = '结束时间';
    $allFieldsAdd['Default'][2]['value'] = '';
    $allFieldsAdd['Default'][2]['placeholder'] = '';
    $allFieldsAdd['Default'][2]['helptext'] = '';
    $allFieldsAdd['Default'][2]['show'] = true;
    $allFieldsAdd['Default'][2]['FieldTypeArray'] = ['input'];
    $allFieldsAdd['Default'][2]['type'] = 'input';
    $allFieldsAdd['Default'][2]['rules'] = ["required"=> false, "xs"=> 12, "sm"=> 6, "disabled"=> true, "min"=> 0, "max"=> 0 ];

    $allFieldsAdd['Default'][3]['name'] = '选课轮数';
    $allFieldsAdd['Default'][3]['label'] = '选课轮数';
    $allFieldsAdd['Default'][3]['value'] = '';
    $allFieldsAdd['Default'][3]['placeholder'] = '';
    $allFieldsAdd['Default'][3]['helptext'] = '';
    $allFieldsAdd['Default'][3]['show'] = true;
    $allFieldsAdd['Default'][3]['FieldTypeArray'] = ['input'];
    $allFieldsAdd['Default'][3]['type'] = 'input';
    $allFieldsAdd['Default'][3]['rules'] = ["required"=> false, "xs"=> 12, "sm"=> 6, "disabled"=> true, "min"=> 0, "max"=> 0 ];

    $allFieldsAdd['Default'][4]['name'] = '允许选课门数';
    $allFieldsAdd['Default'][4]['label'] = '允许选课门数';
    $allFieldsAdd['Default'][4]['value'] = '';
    $allFieldsAdd['Default'][4]['placeholder'] = '';
    $allFieldsAdd['Default'][4]['helptext'] = '';
    $allFieldsAdd['Default'][4]['show'] = true;
    $allFieldsAdd['Default'][4]['FieldTypeArray'] = ['input'];
    $allFieldsAdd['Default'][4]['type'] = 'input';
    $allFieldsAdd['Default'][4]['rules'] = ["required"=> false, "xs"=> 12, "sm"=> 6, "disabled"=> true, "min"=> 0, "max"=> 0 ];

    $allFieldsAdd['Default'][5]['name'] = '可选课程_名称';
    $allFieldsAdd['Default'][5]['code'] = '可选课程';
    $allFieldsAdd['Default'][5]['label'] = '可选课程';
    $allFieldsAdd['Default'][5]['value'] = '';
    $allFieldsAdd['Default'][5]['placeholder'] = '';
    $allFieldsAdd['Default'][5]['helptext'] = '';
    $allFieldsAdd['Default'][5]['show'] = true;
    $allFieldsAdd['Default'][5]['FieldTypeArray'] = ['autocomplete','data_xuanke_record','1','1'];
    $allFieldsAdd['Default'][5]['type'] = 'autocomplete';
    $allFieldsAdd['Default'][5]['rules'] = ["required"=> true, "xs"=> 12, "sm"=> 6, "disabled"=> false, "min"=> 0, "max"=> 0 ];
    //得到可选课程列表 and 教学班来源
    $sql = "select * from edu_banjijiaoxue where 开课学期='$开放学生选课学期' and 适用选课轮数='$选课启用轮数' and FIND_IN_SET('".$GLOBAL_USER->班级."', 教学班来源) ";
    $rs = $db->Execute($sql);
    $rs_a = $rs->GetArray();
    $可选课程列表 = [];
    foreach($rs_a as $Item) {
        $空闲 = $Item['限选人数'];
        $可选课程列表[] = ["value"=> $Item['班级名称'], "label"=> $Item['班级名称']."(限选:".$Item['限选人数'].",空闲:$空闲)"];
    }
    $allFieldsAdd['Default'][5]['options'] = $可选课程列表;

    //print_R($AllShowTypesArray);
    //print $sql;
    $RS['add_default']['allFields']        = $allFieldsAdd;
    $RS['add_default']['allFieldsMode']    = [['value'=>"Default", 'label'=>__("")]];
    $RS['add_default']['defaultValues']    = $defaultValuesAdd;
    $RS['add_default']['dialogContentHeight']  = "90%";
    $RS['add_default']['submitaction']     = "add_default_data";
    $RS['add_default']['componentsize']    = "small";
    $RS['add_default']['submittext']       = $SettingMap['Rename_Add_Submit_Button'];
    $RS['add_default']['canceltext']       = __("Cancel");
    $RS['add_default']['titletext']        = $SettingMap['Add_Title_Name'];
    $RS['add_default']['titlememo']        = $SettingMap['Add_Subtitle_Name'];
    $RS['add_default']['tablewidth']       = 650;
    $RS['add_default']['submitloading']    = __("SubmitLoading");
    $RS['add_default']['loading']          = __("Loading");
    $RS['add_default']['sql']              = $sql;

    //判断是否已经选过课程
    $sql = "select Count(*) AS NUM from data_xuanke_record where 学号='".$GLOBAL_USER->学号."'";
    $rs = $db->Execute($sql);
    $NUM = $rs->fields['NUM'];
    if($NUM>=$每一轮允许学生选修的课程门数)  {
        $RS['init_default']['button_add'] = null;
        $RS['add_default'] = [];
    }
    
    print_R(json_encode($RS, true));
    exit;

    return $RS;
}

function plugin_data_xuanke_record_2_add_default_data_before_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    
    global $开放学生选课学期;
    global $选课启用轮数;
    global $第一轮选课开始时间;
    global $第一轮选课结束时间;
    global $每一轮允许学生选修的课程门数;
    $教学班 = $_POST['可选课程'];
    $教学班信息 = returntablefield("edu_banjijiaoxue","班级名称",$教学班,"课程名称,入学年份,固定教室,课程代码");

    $sql = "select Count(*) AS NUM from data_xuanke_record where 学号='".$GLOBAL_USER->学号."'";
    $rs = $db->Execute($sql);
    $NUM = $rs->fields['NUM'];
    if($NUM>=$每一轮允许学生选修的课程门数)  {
        $RS['status']   = "ERROR";
        $RS['msg']      = "已经完成选课,不允许再选";
    }
    else {
        $sql = "insert into data_xuanke_record(学期,开课专业,课程,教学班,学号,姓名,时间,行政班,入学年份,教室,课程代码) values ('$开放学生选课学期','".$_POST['专业']."','".$教学班信息['课程名称']."','".$_POST['可选课程']."','".$GLOBAL_USER->学号."','".$GLOBAL_USER->姓名."','".date('Y-m-d H:i:s')."','".$GLOBAL_USER->班级."','".$_POST['入学年份']."','".$_POST['固定教室']."','".$_POST['课程代码']."') ";
        $db->Execute($sql);
        $RS['status']   = "OK";
        $RS['msg']      = $SettingMap['Tip_When_Add_Success'];
    }
    print_R(json_encode($RS, true));
    exit;
}

function plugin_data_xuanke_record_2_add_default_data_after_submit($id)  {
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

function plugin_data_xuanke_record_2_edit_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_edit_default_data_before_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_edit_default_data_after_submit($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_edit_default_configsetting_data($id)  {
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

function plugin_data_xuanke_record_2_view_default($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_delete_array($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_updateone($id)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

function plugin_data_xuanke_record_2_import_default_data_before_submit($Element)  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
    return $Element;
}

function plugin_data_xuanke_record_2_import_default_data_after_submit()  {
    global $db;
    global $SettingMap;
    global $MetaColumnNames;
    global $GLOBAL_USER;
    global $TableName;
    //Here is your write code
}

?>