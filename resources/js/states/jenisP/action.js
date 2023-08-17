/* eslint-disable no-unused-vars */
import api from "../../utils/api";

const nm = 'jenis';
const actType = {
  dt      : 'data'+nm,
  add     : 'entri'+nm,
  upd     : 'update'+nm,
  del     : 'delete'+nm,
  dtDukung:'dataDukung',
  addDukung:'addDukung',
  updDukung:'updDukung',
  delDukung:'delDukung',
};
function setDT(dt) {
    return {
      type: actType.dt,
      payload: {
        dt: dt,
      },
    };
}
function getDT() {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:'jenisP'});
        dispatch(setDT(dt));
      } catch (error) {
        // alert(error.message);
      }
      // dispatch(hideLoading());
  };
}

function added(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/added",body});
      dispatch(setDT(dt));
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}

function upded(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/upded",body});
      dispatch({
        type : actType.upd,
        payload: {
          nmJPJ: body.nmJPJ,
          ind :body.ind
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function deled(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/deled",body});
      dispatch({
        type : actType.del,
        payload : {
          ind :body.ind
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}

function setDataDukung({dt,ind}){
  return {
    type: actType.dtDukung,
    payload: {
      dt,
      ind
    },
  }
}
function getDataDukung({kdJPJ,ind}) {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:'jenisP/dataDukung/'+kdJPJ});
        dispatch(setDataDukung({dt,ind}));
      } catch (error) {
        // alert(error.message);
      }
      // dispatch(hideLoading());
  };
}
function addedDukung(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/addedDukung",body});
      dispatch(setDataDukung({ dt, ind: body.ind }));
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}

function updedDukung(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/updedDukung",body});
      dispatch({
        type : actType.updDukung,
        payload: {
          nmDP: body.nmDP,
          ind :body.ind,
          index:body.index
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function deledDukung(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"jenisP/deledDukung",body});
      dispatch({
        type : actType.delDukung,
        payload : {
          ind :body.ind,
          index :body.index
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}

const colJenis = [
  {
      name: 'Kode',
      selector: row => row.kdJPJ,
      width : '150px'
  },{
      name: 'Nama Jenis',
      selector: row => row.nmJPJ,
  }
];
const colDataDukug = [
  {
      name: 'Kode',
      selector: row => row.kdDP,
      width : '150px'
  },{
      name: 'Daftar Data Pendukung',
      selector: row => row.nmDP,
  }
];
export {
    actType,
    setDT,
    getDT,

    added,
    upded,
    deled,


    getDataDukung,
    addedDukung,
    updedDukung,
    deledDukung,

    colJenis,
    colDataDukug
}
