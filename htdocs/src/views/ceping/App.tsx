// ** React Imports
import { Fragment, useEffect, useState, useCallback } from 'react'

import AppModel from 'src/views/ceping/AppModel'

// ** Axios Imports
import axios from 'axios'
import authConfig from 'src/configs/auth'
import AddOrEditTable from 'src/views/Enginee/AddOrEditTable'
import ViewTable from 'src/views/Enginee/ViewTable'
import { DecryptDataAES256GCM } from 'src/configs/functions'
import { useAuth } from 'src/hooks/useAuth'

const AllApp = () => {

  const [pageid, setPageid] = useState<number>(0)
  const [show, setShow] = useState<boolean>(false)
  const [loadingAllData, setLoadingAllData] = useState<boolean>(false)
  const [app, setApp] = useState<any[]>([])
  const [loading, setLoading] = useState<boolean>(true)
  const [loadingText, setLoadingText] = useState<string>('Loading')
  const [appId, setAppId] = useState<string>('')
  const [store, setStore] = useState<any>({})
  const [forceUpdate, setForceUpdate] = useState(0)
  const [addEditActionName, setAddEditActionName] = useState<string>('')
  const [addEditActionId, setAddEditActionId] = useState<string>('')
  const [editViewCounter, setEditViewCounter] = useState<number>(1)
  const [externalId, setExternalId] = useState<number>(0)
  const [addEditActionOpen, setAddEditActionOpen] = useState<boolean>(false)
  const [viewActionOpen, setViewActionOpen] = useState<boolean>(false)
  const [backEndApi, setBackEndApi] = useState<string>("/apps/apps_378.php")
  const [addEditViewShowInWindow, setAddEditViewShowInWindow] = useState<boolean>(false)
  const [CSRF_TOKEN, setCSRF_TOKEN] = useState<string>('')

  const auth = useAuth()

  useEffect(() => {

    if (auth && auth.user && auth.user.type && auth.user.type == "User") {
      setBackEndApi("/apps/apps_378.php")
    }

    if (auth && auth.user && auth.user.type && auth.user.type == "Student") {
      setBackEndApi("/apps/apps_385.php")
    }
    getAppsPage()

    setCSRF_TOKEN('')
    setAddEditViewShowInWindow(false)
    setExternalId(0)

  }, [])

  const toggleViewTableDrawer = () => {
    setAddEditActionName('view_default')
    setViewActionOpen(!viewActionOpen)
  }

  const toggleEditTableDrawer = () => {
    setAddEditActionName('edit_default')
    setAddEditActionOpen(!addEditActionOpen)
  }

  const addUserHandleFilter = useCallback(() => {
    setAddEditActionId('')
    setEditViewCounter(0)
  }, [])

  const handleIsLoadingTipChange = () => {
    console.log("forceUpdate", forceUpdate)
  }

  const toggleImagesPreviewListDrawer = () => {
    console.log("forceUpdate", forceUpdate)
  }

  const getAppsPage = async function () {
    const storedToken = window.localStorage.getItem(authConfig.storageTokenKeyName)!
    
    if(loadingAllData == false && storedToken)  {
      setLoading(true)
      const response = await axios.get(authConfig.backEndApiHost + backEndApi, {
        headers: {
          Authorization: storedToken
        },
        params: {}
      }).then(res => {
        const data = res.data
        if(data && data.isEncrypted == "1" && data.data)  {
          const i = data.data.slice(0, 32);
          const t = data.data.slice(-32);
          const e = data.data.slice(32, -32);
          const k = authConfig.k;
          const DecryptDataAES256GCMData = DecryptDataAES256GCM(e, i, t, k)
          try{
            const ResJson = JSON.parse(DecryptDataAES256GCMData)
            
            return ResJson
          }
          catch(Error: any) {
            console.log("DecryptDataAES256GCMData Error", Error)
  
            return []
          }
        }
        else {
  
          return data
        }
      })

      console.log("loadingAllData response", response)

      setLoadingAllData(true)
      setStore(response)
      setApp(response.init_default.data)
      setAppId("")
      
      const timer = setTimeout(() => {
        setLoading(false);
      }, 500);  

      return () => {
        clearTimeout(timer);
      };

    }
    else {
      setLoading(true)
      setLoadingText('Finished')
      const timer2 = setTimeout(() => {
        setLoading(false);
      }, 500);

      return () => {
        clearTimeout(timer2);
      };
    }
  }

  useEffect(() => {
    const handleScroll = () => {
      if (window.innerHeight + document.documentElement.scrollTop !== document.documentElement.offsetHeight) return;
      setPageid(pageid + 1)
      getAppsPage();
    };

    window.addEventListener('scroll', handleScroll);

    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, [app]); 

  return (
    <Fragment>

      <AppModel app={app} loading={loading} loadingText={loadingText} appId={appId} setAppId={setAppId} show={show} setShow={setShow} setAddEditActionId={setAddEditActionId} setViewActionOpen={setViewActionOpen} setEditViewCounter={setEditViewCounter} viewActionOpen={viewActionOpen} setAddEditActionName={setAddEditActionName} setAddEditActionOpen={setAddEditActionOpen}/>

      {store && store[addEditActionName] && store[addEditActionName]['defaultValues'] && addEditActionName == 'edit_default' && addEditActionId!='' ? <AddOrEditTable externalId={Number(externalId)} id={addEditActionId} action={addEditActionName} addEditStructInfo={store[addEditActionName]} open={addEditActionOpen} toggleAddTableDrawer={toggleEditTableDrawer} addUserHandleFilter={addUserHandleFilter} backEndApi={backEndApi} editViewCounter={editViewCounter + 1} IsGetStructureFromEditDefault={0} addEditViewShowInWindow={addEditViewShowInWindow}  CSRF_TOKEN={CSRF_TOKEN} dataGridLanguageCode={store.init_default.dataGridLanguageCode} dialogMaxWidth={store.init_default.dialogMaxWidth} toggleImagesPreviewListDrawer={toggleImagesPreviewListDrawer} handleIsLoadingTipChange={handleIsLoadingTipChange} setForceUpdate={setForceUpdate}/> : ''}

      {store && store.view_default && store.view_default.defaultValues && addEditActionName.indexOf("view_default") != -1 && addEditActionId!='' ? <ViewTable externalId={Number(externalId)} id={addEditActionId} action={addEditActionName} pageJsonInfor={store[addEditActionName]} open={viewActionOpen} toggleViewTableDrawer={toggleViewTableDrawer} backEndApi={backEndApi} editViewCounter={editViewCounter + 1} addEditViewShowInWindow={addEditViewShowInWindow} CSRF_TOKEN={CSRF_TOKEN} toggleImagesPreviewListDrawer={toggleImagesPreviewListDrawer} dialogMaxWidth={store.init_default.dialogMaxWidth} /> : ''}

    </Fragment>
  )
}


export default AllApp
