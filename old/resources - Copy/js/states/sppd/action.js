/* eslint-disable no-unused-vars */
import api from "../../utils/api";
import { toast } from 'react-toastify';
import sfLib from "../../components/mfc/sfLib";

const nm = 'sppd';
const actType = {
  dt      : 'data'+nm,
  add     : 'entri'+nm,
  upd     : 'update'+nm,
  del     : 'delete'+nm,
  anggota: "anggota",
  anggotaSelect: "anggotaSelect",
  updWorkAnggota: "updWorkAnggota",
  crudWork: "crudWork",
  workSetAnggota:'workSetAnggota',
  workDelAnggota:'workDelAnggota',
  nextStep:{
    dasar: 'uploadDasar',
    setPimpinan: 'setPimpinan',
    setTandaTangan:'setTandaTangan',
    type : 'nextStep',
    start:'berproses',
    step1:'entriRincian',
    step3:'final',
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
function setPimpinan(body){
    return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.POST({url:"sppd/setPimpinan",body});
        dispatch({
          type : actType.crudWork,
          payload:{
            ...body,
            type:actType.nextStep.setPimpinan
          }
        });
        toast.success('berhasil diperbarui');
      } catch (error) {
        alert(error.message);
      }
      // dispatch(hideLoading());
    };
}
function setTandaTanganManual(body){
    return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.POST({url:"sppd/setPimpinan",body});
        dispatch({
          type : actType.crudWork,
          payload:{
            ...body,
            type:actType.nextStep.setTandaTangan
          }
        });
        toast.success('berhasil diperbarui');
      } catch (error) {
        alert(error.message);
      }
      // dispatch(hideLoading());
    };
}
function Step3(body){
    return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const exec = await api.POST({url:"sppd/step3",body});
        window.location.reload();
        // dispatch({
        //   type : actType.crudWork,
        //   payload:{
        //     ...body,
        //     type:actType.nextStep.step3
        //   }
        // });
        // toast.success("sukses malaksanakan aksi !!!");
      } catch (error) {
        toast.error(error.message);
      }
      // dispatch(hideLoading());
    };
}

function uploadDasar(body){
    return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const fileD = await api.POST({url:"sppd/uploadDasar",body});
        dispatch({
          type : actType.crudWork,
          payload:{
            fileD,
            ind:body.ind,
            dasar:body.dasar,
            type:actType.nextStep.dasar
          }
        });
      } catch (error) {
        // alert(error.message);
      }
      // dispatch(hideLoading());
    };
}

function addedWorkStaf({ dt, ind, param  }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dtx = await api.POST({url:"sppd/addedUser",body:{  ...param,dt} });
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
//       name: 'Bidang',
//       selector: row => row.asBidang,
//       width : '150px'
//   },{
      name: 'Nama',
      selector: row => row.nmAnggota,
  },{
    name: 'Jabatan',
    selector: row => row.nmJabatan,
  }
];
const coldata = [
  {
      name: 'No',
      selector: row => row.no,
      width : '50px'
  },{
    name: 'Tujuan',
    selector: row => row.tempatE,
  },{
      name: 'Tanggal',
      selector: row => row.date,
  },{
    name: 'Status',
    selector: row =>{
        if(row.status==="final"){
            return sfLib._$(row.total);
        }
        return row.lokasi;
    },
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
function updWorkAnggota(body){
    return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.POST({url:"sppd/updWorkAnggota",body});
        dispatch({
          type : actType.crudWork,
          payload:{
            ...body,
            type:actType.updWorkAnggota
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

const cbDasar = [
    {
      label :'Undangan',
      value :'Undangan',
    },{
      label :'Telaahan Staf',
      value :'Telaahan',
    }
];

export {
    actType,
    setDT,
    getDT,

    added,
    upded,
    deled,

    uploadDasar,
    nextStep,
    setPimpinan,
    setTandaTanganManual,
    Step3,

    colAnggota,
    coldata,

    workSetAnggota,
    workDelAnggota,

    anggotaSelect,
    addedWorkStaf,
    updWorkAnggota,

    addWorkUraian,
    updWorkUraian,
    delWorkUraian,

    cbDasar,
}
