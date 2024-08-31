import { useState, useEffect, Fragment } from 'react'

import SoulAssessmentModelMiddleSchool from 'src/views/Enginee/SoulAssessmentModelMiddleSchool'
import SoulAssessmentModelSCL90 from 'src/views/Enginee/SoulAssessmentModelSCL90'
import SoulAssessmentModelCourseInterest from 'src/views/Enginee/SoulAssessmentModelCourseInterest'

import authConfig from 'src/configs/auth'
import axios from 'axios'

interface Props {
  dataOriginal: any
  modelOriginal: string
  id: string
  backEndApi: string
}

const SoulAssessmentModel = ({ dataOriginal, modelOriginal, id, backEndApi }: Props) => {
  // ** Hook

  console.log("dataOriginal", dataOriginal)

  const [data, setData] = useState<any>(dataOriginal)
  const [model, setModel] = useState<any>(modelOriginal)
  const [printModel, setPrintModel] = useState<string>("print")

  useEffect(() => {
    //打印页面时,需要单独再获取一次API的内容
    //const backEndApi = 'apps/apps_378.php'
    const action = 'view_default'
    const storedToken = window.localStorage.getItem(authConfig.storageTokenKeyName)!
    if (id && id.length > 32 && data == null) {
      axios
        .get(authConfig.backEndApiHost + backEndApi, { headers: { Authorization: storedToken+"::::" }, params: { action, id, isMobileData: false } })
        .then(res => {
          const data = res.data
          if(data && data.model) {
            setData(data.data)
            setModel(data.model)
            setPrintModel("")
            console.log("data.model", data, model);
          }
        })
        .catch(() => {
          console.log("axios.get editUrl return")
        })
    }
  }, [id])

  return (
    <Fragment>
        {data && data['测评名称'] == "中学生心理健康量表(MSSMHS)" && ( 
            <SoulAssessmentModelMiddleSchool data={data} id={id} backEndApi={backEndApi} printModel={printModel} /> 
        )}
        {data && data['测评名称'] == "中小学生心理健康量表(MHT)" && ( 
            <SoulAssessmentModelMiddleSchool data={data} id={id} backEndApi={backEndApi} printModel={printModel} /> 
        )}
        {data && data['测评名称'] == "儿童焦虑性情绪障碍筛查表(SCARED)" && ( 
            <SoulAssessmentModelMiddleSchool data={data} id={id} backEndApi={backEndApi} printModel={printModel} /> 
        )}
        {data && data['测评名称'] == "症状自评量表(SCL-90)" && ( 
            <SoulAssessmentModelSCL90 data={data} id={id} backEndApi={backEndApi} printModel={printModel} /> 
        )}
        {data && data['测评名称'] == "中学生学科兴趣测评" && ( 
            <SoulAssessmentModelCourseInterest data={data} id={id} backEndApi={backEndApi} printModel={printModel} /> 
        )}
    </Fragment>
  )
}

export default SoulAssessmentModel
