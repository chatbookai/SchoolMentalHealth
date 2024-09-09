import { useRouter } from 'next/router'
import { Fragment, ReactNode } from 'react'
import BlankLayout from 'src/@core/layouts/BlankLayout'

import SoulAssessmentModel from 'src/views/Enginee/SoulAssessmentModel'


const SoulAssessmentModelApp = () => {

  const router = useRouter()
  const { id } = router.query
  const idList = String(id).split('____')
  if(idList[1] == '378' || idList[1] == '380' || idList[1] == '384' || idList[1] == '385') {
    const backEndApi = 'apps/apps_' + idList[1] + '.php'

    return <SoulAssessmentModel modelOriginal={"测评模式"} dataOriginal={null} id={String(idList[0])} backEndApi={backEndApi}/>
  }
  else {

    return <Fragment>Not Allow {idList[1]}</Fragment>
  }

}

SoulAssessmentModelApp.getLayout = (page: ReactNode) => <BlankLayout>{page}</BlankLayout>

SoulAssessmentModelApp.setConfig = () => {
  return {
    mode: 'light'
  }
}

export default SoulAssessmentModelApp

