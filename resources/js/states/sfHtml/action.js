import api from "../../utils/api";
const BASE_URL = api.BASE_URL;
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
  window.location.replace('/logout');
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
        error;
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

function openFormEntri(url){
  window.open(api.UrlFormEntri+url)
}
function newTab(url){
  window.open(api.BASE_URL+url)
}
const checkForm=(dt)=>{
  // type, minLength, value
  try {
    dt.map((v,i)=>{
        switch (v.type) {
          case "text": 
            cfMinLength({...v,ind:i});
          break;
          case "email": 
            cfEmail({...v,ind:i});
          break;
        }
    })

    return {
      cf:1,
      msg:'',
      ind:-1
    }
  } catch (error) {
    return {
      cf:0,
      ...error
    }
  }
}
const cfMinLength=({value, name ,minLength, ind})=>{
  if(String(value).length>=minLength){
    return true;
  }
  throw {msg: (name!=undefined ? name:'value')+" harus terisi minimal "+minLength+" huruf", ind}
}
const cfEmail=({value,minLength, ind})=>{
  cfMinLength({value,minLength, ind});
  if(String(value).split("@").length>1){
    return true;
  }
  throw {msg: (name!=undefined ? name:'value email')+' harus menggunakan tanda @ ', ind}
}
export {
    actType,
    BASE_URL,
    setAll,
    setLeftBar,

    setHtml,
    modalClose,

    logout,
    session,
    changeMenu,
    changeMenuSub,
    openFormEntri,
    newTab,
    checkForm
}
