import api from "../../utils/api";
import { toast } from 'react-toastify';

const nm = 'sppd';
const actType = {
  dt      : 'data'+nm,
  add     : 'entri'+nm,
  upd     : 'update'+nm,
  del     : 'delete'+nm,
  anggota: "anggota",
  anggotaSelect: "anggotaSelect",
  crudWork: "crudWork",
  workSetAnggota:'workSetAnggota',
  workDelAnggota:'workDelAnggota',
  nextStep:{
    type : 'nextStep',
    start:'berproses',
    step1:'entriRincian',
  },
  setUraian:'setUraian',
  updUraian:'updUraian',
  delUraian:'delUraian',
};
function setDT(dt) {
    return {
      type: actType.dt,
      payload: {
        dt: dt,
      },
    };
}
function getDT(v) {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:'sppd/'+v});
        dispatch(setDT(dt));
      } catch (error) {
        alert(error.message);
      }
      // dispatch(hideLoading());
  };
}

function added(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"sppd/added",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          dt,
          type:actType.add
        }
      });
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
      const dt = await api.POST({url:"sppd/upded",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          type:actType.upd
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
      const dt = await api.POST({url:"sppd/deled",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          type:actType.del
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function nextStep(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"sppd/nextStep",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          type:actType.nextStep.type
        }
      });
    } catch (error) {
      alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function addedWorkStaf({ dt, ind, param  }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      dt.forEach(async(v)=>{
        await api.POST({url:"sppd/addedUser",body:{ ...v, ...param} });
      })
      dispatch({
        type : actType.crudWork,
        payload : {
          ind,
          dt,
          param,
          type:actType.workSetAnggota
        }
      });
    } catch (error) {
      toast.error(error.message);
    }
    // dispatch(hideLoading());
  };
}

const colAnggota = [
  {
      name: 'Bidang',
      selector: row => row.asBidang,
      width : '150px'
  },{
      name: 'Staf',
      selector: row => row.nmAnggota,
  },{
    name: 'Jabatan',
    selector: row => row.nmJabatan,
  }
];
const coldata = [
  {
      name: 'Nomor',
      selector: row => row.no,
      width : '150px'
  },{
    name: 'Tujuan',
    selector: row => row.tujuan,
  },{
      name: 'Tanggal',
      selector: row => row.date,
  },{
    name: 'Status',
    selector: row => row.status,
  }
];

function workSetAnggota({ ind, param }){
  return async (dispatch) => {
    try {
      const dt = await api.POST({url:"sppd/getAnggotaSelected", body:param });
      dispatch({
        type : actType.crudWork,
        payload : {
          ind,
          dt,
          param,
          type:actType.workSetAnggota
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function anggotaSelect({ ind }){
  return async (dispatch) => {
    try {
      dispatch({
        type : actType.anggota,
        payload : {
          ind,
          type:actType.anggotaSelect
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function workDelAnggota({ ind, index, param }){
  return async (dispatch) => {
    try {
      const dt = await api.POST({url:"sppd/delAnggotaSelected", body:param });
      dispatch({
        type : actType.crudWork,
        payload : {
          ind,
          index,
          type:actType.workDelAnggota
        }
      });
    } catch (error) {
      // alert(error.message);
    }
    // dispatch(hideLoading());
  };
}


function addWorkUraian(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"sppd/addWorkUraian",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          dt,
          type:actType.setUraian
        }
      });
      toast.success('berhasil ditambahkan');
    } catch (error) {
      toast.error(error.message);
    }
    // dispatch(hideLoading());
  };
}
function updWorkUraian(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"sppd/updWorkUraian",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          type:actType.updUraian
        }
      });
      toast.success('berhasil diperbarui');
    } catch (error) {
      alert(error.message);
    }
    // dispatch(hideLoading());
  };
}
function delWorkUraian(body){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"sppd/delWorkUraian",body});
      dispatch({
        type : actType.crudWork,
        payload:{
          ...body,
          type:actType.delUraian
        }
      });
      toast.success('berhasil dihapus');
    } catch (error) {
      alert(error.message);
    }
    // dispatch(hideLoading());
  };
}


export {
    actType,
    setDT,
    getDT,

    added,
    upded,
    deled,
    nextStep,

    colAnggota,
    coldata,

    workSetAnggota,
    workDelAnggota,

    anggotaSelect,
    addedWorkStaf,

    addWorkUraian,
    updWorkUraian,
    delWorkUraian,
}