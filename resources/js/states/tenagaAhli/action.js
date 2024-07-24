/* eslint-disable no-unused-vars */
import api from "../../utils/api";
import { toast } from 'react-toastify';
import sfLib from "../../components/mfc/sfLib";

const tahapan=[
  "proses dokumen","tuntas"
];
const actType = {
  __user:"__user",
  __doc:"__doc",
  __checkList:"__checkList",

  __sjp:"__sjp",
  _sjp:"_sjp",
  updSjp:"updSjp",
};
function __user({kdDF}) {
  return async (dispatch) => {
    try {
      const dt = await api.__api('vd/'+(btoa(JSON.stringify({...api.paramNoted,kdDF}))));
      dispatch({
        type: actType.__user,
        payload: dt
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}
function __doc({kdDF}) {
  return async (dispatch) => {
    try {
      const dt = await api.__api('vd/'+(btoa(JSON.stringify({...api.paramNoted,kdDF}))));
      dispatch({
        type: actType.__doc,
        payload: dt
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}
function __checkList({kdDF}) {
  return async (dispatch) => {
    try {
      const dt = await api.__api('vd/'+(btoa(JSON.stringify({...api.paramNoted,kdDF}))));
      dispatch({
        type: actType.__checkList,
        payload: dt
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}

function __sjp(v) {
  return async (dispatch) => {
    try {
      const dt = await api.GET({url:'spj/get/'+v});
      dispatch({
        type: actType.__sjp,
        payload:{...dt}
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}

function _sjp(v) {
  return async (dispatch) => {
    try {
      const data = await api.POST({ url:'spj/set',body:v });
      dispatch({
        type: actType._sjp,
        payload:data
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}
function updSjp(v) {
  return async (dispatch) => {
    try {
      const data = await api.POST({ url:'spj/upd',body:v});
      dispatch({
        type: actType.updSjp,
        payload:{
          ...v,
          data:JSON.parse(atob(v.data))
        }
      });
    } catch (error) { 
      alert(error.message);
    }
  }; 
}
function __tahapan(status) {
  return tahapan[parseInt(status)-1];
}
export {
  actType,
  __user,__doc,
  __sjp,_sjp,updSjp,
  __tahapan,
  __checkList,
}
