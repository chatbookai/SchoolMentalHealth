
// ** Hooks
import UserList from 'src/views/Enginee/index'

const AppChat = () => {
    // ** States
    const backEndApi = "form_menuone.php"
    
    return (
        <UserList backEndApi={backEndApi} externalId=''/>
    )
}


export default AppChat
