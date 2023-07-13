import api from "../../utils/api";
const actType = {
    setAll : "ALL",
    leftBar: "leftBar",
    setHtml: "setHtml",
};
function setAll(v) {
  return {
    type: actType.setAll,
    payload: {
      v,
    },
  };
}
function setLeftBar(v) {
  return {
    type: actType.leftBar,
    payload: {
      v,
    },
  };
}

function setHtml(v) {
  return async (dispatch) => {
    dispatch({
        type : actType.setHtml,
        payload : v,
    })
  }
}

function modalClose(){
  return async (dispatch) => {
    dispatch({
        type : actType.setHtml,
        payload : {
          modal : false,
        },
    })
  }
}
function logout(){
  localStorage.removeItem('sess');
  return async (dispatch) => {
    // const resp = api.POST({
    //   url:'logout/',
    //   api:''
    // });
    window.location.replace('/logout');
  }
}
function session(){
  return async (dispatch) => {
    let sess= null, menu=null ,data= null;
    try {
      sess = await localStorage.getItem('sess').then(resp=>{
        return resp;
      });
      menu = listMenu({
        jenis : await localStorage.getItem('menu').then(resp=>{
          return resp;
        })
      });
    } catch (error) {

    }

    if(sess === null){
      data = await api.GET({url:'dinas/sess'});
      await localStorage.setItem('sess',data.sess);
      await localStorage.setItem('menu',data.jenis);
      dispatch(setHtml({
        sess: data['user'],
        menu:listMenu({
            jenis : data['jenis'],
        })
      }))
    }else{
      dispatch(setHtml({
        sess,
        menu
      }))
    }

  }
}
function changeMenu(url){
  return async (dispatch) => {
    let ind = 0 ;
    if(url.split('work').length>1){
        ind = 1;
    }
    const xurl = url.split("/");
    return dispatch(
      setHtml({
        indMenu : ind,
        menuSub : xurl[xurl.length-1],
      })
    )
  }

}

function changeMenuSub({menuSub}){
  return async (dispatch) => {
    return dispatch(
      setHtml({
        menuSub
      })
    )
  }

}

function listMenu({ jenis }){
  return [
    {
      id  : 1,
      url : 'home',
      nm  : 'BASIS DATA',
      menu : [
        {
          url : 'dashboard',
          nm  : 'DASHBOARD'
        },{
          url : 'dinas',
          nm  : 'DINAS'
        },{
          url : 'rekeningBelanja',
          nm  : 'REKENING BELANJA'
        },{
          url : 'jenisP',
          nm  : 'JENIS PJ'
        },{
          url : 'subkegiatan',
          nm  : 'SUB KEGIATAN'
        }
      ]
    },{
      id  : 2,
      url : 'work',
      nm  : 'LEMBAR KERJA',
      menu : jenis.map((v,i)=>{
        return {
          ...v,
          act :(i ===0 && true)
        }
      })
    }
  ]
}

export {
    actType,

    setAll,
    setLeftBar,

    setHtml,
    modalClose,

    logout,
    session,
    changeMenu,
    changeMenuSub,
}
