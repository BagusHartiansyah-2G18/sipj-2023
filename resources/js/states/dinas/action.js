/* eslint-disable no-unused-vars */
import api from "../../utils/api";
import { toast } from 'react-toastify';
import sfLib from "../../components/mfc/sfLib";

const nm = 'dinas';
const actType = {
  dt      : 'data'+nm,
  add     : 'entri'+nm,
  upd     : 'update'+nm,
  del     : 'delete'+nm,
  dtBidang: 'bidang',
  dtBidangSub: 'bidangSub',
  dtSubBidangKhusus: 'dtSubBidangKhusus',
  dtUraianSub: 'dtUraianSub',
  addBidang: 'addBidang',
  updBidang: 'updBidang',
  delBidang: 'delBidang',

  dtAnggota: 'dtAnggota',
  addAnggota: 'addAnggota',
  updAnggota: 'updAnggota',
  delAnggota: 'delAnggota',

  setSubValue: 'setSubValue',
  selectSubKeg: 'selectSubKeg',
  delselectSubKeg: 'delselectSubKeg',

  actRincian: 'actRincian',
  actTriwulan: 'actTriwulan',
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
          const dt = await api.GET({url:"dinas"});
          dispatch(setDT(dt));
        } catch (error) {
          toast(error.message);
        }
        // dispatch(hideLoading());
    };
}

function added({ kdDinas, nmDinas, kadis, nip, asDinas }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/added",body: { kdDinas, nmDinas, kadis, nip, asDinas }});
      dispatch(setDT(dt));
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}
function upded({ kdDinas, nmDinas, kadis, nip, asDinas, ind }){
  return async (dispatch) => {
    const dt = await api.POST({url:"dinas/upded",body: { kdDinas, nmDinas, kadis, nip, asDinas }});
    dispatch({
        type : actType.upd,
        payload: { kdDinas, nmDinas, kadis, nip, asDinas, ind }
    });
  };
}
function deled({ kdDinas, ind }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/deled",body: { kdDinas}});
      dispatch({
        type : actType.del,
        payload : { kdDinas, ind }
      });
    } catch (error) {
      toast(error.message);
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}

//batas

function setDBidang({dt,ind}) {
  return {
    type: actType.dtBidang,
    payload: {
      bidang: dt,
      ind   : ind,
    },
  };
}
function getDBidang({kdDinas,ind}) {
    return async (dispatch) => {
      // dispatch(showLoading());
        const dt = await api.GET({url:'dinas/bidang/'+kdDinas});
        dispatch(setDBidang({dt,ind}));
      // dispatch(hideLoading());
    };
}
function addedBidang({ kdDinas, nmBidang, asBidang, ind}){
  return async (dispatch) => {
    // dispatch(showLoading());
    const dt = await api.POST({url:"dinas/addedBidang",body: { kdDinas, nmBidang, asBidang}});
    dispatch(setDBidang({ dt, ind }));
    // dispatch(hideLoading());
  };
}
function updedBidang({ kdDinas, kdDBidang, nmBidang, asBidang, ind, index }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/updedBidang",body: { kdDinas, kdDBidang, nmBidang, asBidang }});
      dispatch({
        type : actType.updBidang,
        payload: { kdDinas, kdDBidang, nmBidang, asBidang, ind, index }
      });
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}
function deledBidang({ kdDinas, kdDBidang, ind, index }){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/deledBidang",body: { kdDinas, kdDBidang }});
      dispatch({
        type : actType.delBidang,
        payload : { ind, index }
      });
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}

function setDAnggota({ dt, ind, index }) {
  return {
    type: actType.dtAnggota,
    payload: {
      anggota : dt,
      ind,
      index
    },
  };
}
function getDAnggota(v) {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:`dinas/anggota/${v.kdDinas}/${v.kdDBidang}`});
        dispatch(setDAnggota({...v, dt}));
      } catch (error) {
        toast(error.message);
      }
      // dispatch(hideLoading());
  };
}
function addedAnggota(v){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/addedAnggota",body: v});
      dispatch(setDAnggota({...v, dt}));
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}
function updedAnggota(v){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/updedAnggota",body:v});
      dispatch({
        type : actType.updAnggota,
        payload: v
      });
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}
function deledAnggota(v){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"dinas/deledAnggota",body: v});
      dispatch({
        type : actType.delAnggota,
        payload : v
      });
    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}

const colDinas = [
  {
      name: 'Dinas',
      selector: row => row.nmDinas,
      width : '340px'
  },{
      name: 'Pimpinan',
      selector: row => row.kadis,
      width : '220px'
  },{
      name: 'NIP',
      selector: row => row.nip,
      width : '200px'
  },{
    name: 'Singkatan',
    selector: row => row.asDinas,
    width : '100px'
},
];
const colBidang = [
  {
    name: 'Kode Bidang',
    selector: row => row.kdDBidang,
    width : "150px"
  },{
      name: 'Nama Bidang',
      selector: row => row.nmBidang,
      width : "250px"
  },{
      name: 'Singkatan',
      selector: row => row.asBidang,
      width : "150px"
  },
];
const colAnggota = [
  {
      name: 'Nama Pegawai',
      selector: row => row.nmAnggota,
    //   width : "250px"
  },{
    name: 'NIP',
    selector: row => row.nip,
    // width : '200px'
  }
  ,{
//       name: 'Jabatan',
//       selector: row => row.nmJabatan,
//       width : '250px'
//   },{
    name: 'Jabatan',
    selector: row => row.asJabatan,
    // width : '150px'
  },
];
const cbStatus = [
    {
      label :'Bidang',
      value :'bidang',
    },{
      label :'Bendahara',
      value :'bendahara',
    },{
        label :'Sekretaris',
        value :'sekretaris',
    },{
        label :'Pimpinan',
        value :'pimpinan',
    },{
      label :'Asisten',
      value :'asisten',
    },{
        label :'SETDA',
        value :'setda',
    },{
        label :'Wakil Bupati',
        value :'wabup',
    },{
        label :'Bupati',
        value :'bupati',
    }
];

const cbTingkatan = [
    {
      label :'B',
      value :'2',
    },{
      label :'C',
      value :'3',
    },{
      label :'D',
      value :'4',
    },{
        label :'E',
        value :'5',
    }
];

const colSub = [
  {
    name: 'Kode Sub',
    selector: row => row.kdSub,
    width : '200px'
  },{
      name: 'Nama Sub',
      selector: row => row.nmSub,

  }
];

const colRincian = [
  {
    name: 'Uraian',
    selector: row => row.nama,
    width : '300px'
  },{
      name: 'Total',
      selector: row => sfLib._$(row.total),
      width : '200px'
  },{
    name: 'Jenis',
    selector: row => row.nmJPJ	,
    width : '150px'
  },{
    name: 'Triwulan',
    selector: row => (row.ada != undefined ? 'Terisi':'-')	,
    width : '200px'
  }
];
const colRincianTw = [
  {
    name: 'Uraian',
    selector: row => row.nama,
    width : '300px'
  },{
      name: 'Alokasi',
      selector: row => sfLib._$(row.total),
      width : '150px'
  },{
    name: 'Realisasi',
    selector: row => sfLib._$(row.realisasi),
    width : '150px'
  },{
    name: 'Sisa',
    selector: row => sfLib._$(row.total-row.realisasi)	,
    width : '150px'
  }
];

function getDinasBidang() {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        let dt = await api.GET({url:"dinas/dinasBidangSub"});
        // console.log(dt);
        dispatch(setDT(dt));
      } catch (error) {
        console.log(error);
        toast(error.message+" => getDinasBidang");
      }
      // dispatch(hideLoading());
  };
}
function selectSubBidangDinas(v, ketDel = false){
  return async (dispatch) => {
    try {
      v.forEach(async (v1) => {
        if(ketDel) {
          await api.POST({url:"sub/delSubBidang", body: v1 });
        }else{
          await api.POST({url:"sub/setSubBidang", body: v1 });
        }
        dispatch({
            type : (ketDel? actType.delselectSubKeg : actType.selectSubKeg),
            payload : {...v1}
        });
      });

    } catch (error) {
      toast(error.message);
    }
    // dispatch(hideLoading());
  };
}
function getDataBidangSub(v) {
    return async (dispatch) => {
        // dispatch(showLoading());
        try {
          const bidang = await api.GET({url:"dinas/dinasDataBidangSub/"+v.kdDinas});
          if(bidang.length==0){
            toast("Data Bidang Belum terdaftar !!!");
          }
          dispatch({
            type : actType.dtBidangSub,
            payload: {
                ...v,
                bidang
            }
          });
        } catch (error) {
          console.log(error);
          toast(error.message+" => getDinasBidang");
        }
        // dispatch(hideLoading());
    };
}
function getDataBidang(v) {
    return async (dispatch) => {
        // dispatch(showLoading());
        try {
          const bidang = await api.GET({url:"dinas/dinasDataBidang/"+v.kdDinas});
          if(bidang.length==0){
            toast("Data Bidang Belum terdaftar !!!");
          }
          dispatch({
            type : actType.dtBidang,
            payload: {
                ...v,
                bidang
            }
          });
        } catch (error) {
          console.log(error);
          toast(error.message+" => getDinasBidang");
        }
        // dispatch(hideLoading());
    };
}
function getDataSubBidang(v) {
    return async (dispatch) => {
        // dispatch(showLoading());
        try {
          const sub = await api.GET({url:"dinas/getSubBidang/"+v.kdDinas+"/"+v.kdBidang});
          if(sub.length==0){
            toast("Data Sub kegiatan, Belum terdaftar !!!");
          }
          dispatch({
            type : actType.dtSubBidangKhusus,
            payload: {
                ...v,
                sub
            }
          });
        } catch (error) {
          console.log(error);
          toast(error.message+" => getDinasBidang");
        }
        // dispatch(hideLoading());
    };
}
function getDataUraianSub(v) {
    return async (dispatch) => {
        // dispatch(showLoading());
        try {
          const dt = await api.GET({url:"dinas/getUraianSub/"+v.kdDinas+"/"+v.kdBidang+"/"+v.kdSub});
          dispatch({
            type : actType.actRincian,
            payload: {
                ...v,
                dt
            }
          });
        } catch (error) {
          console.log(error);
          toast(error.message+" => getDinasBidang");
        }
        // dispatch(hideLoading());
    };
}


function getrincianDinas() {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:"dinas/rincian"});
        dispatch(setDT(dt));
      } catch (error) {
        toast(error.message);
      }
      // dispatch(hideLoading());
  };
}

function actRincian(v){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"rincian/"+v.act,body: v});
      dispatch({
        type : actType.actRincian,
        payload : {...v,dt}
      });
    } catch (error) {
      toast(error.message);
      throw error.message;
    }
    // dispatch(hideLoading());
  };
}
function actTriwulan(v){
  return async (dispatch) => {
    // dispatch(showLoading());
    try {
      const dt = await api.POST({url:"rincian/"+v.act,body: v});
      dispatch({
        type : actType.actRincian,
        payload : {...v,dt, act: (v.act === 'updedTriwulan' && 'addedTriwulan')}
      });
    } catch (error) {
      toast(error.message);
      throw error.message;
    }
  };
}

export {
    actType,
    setDT,
    getDT,

    added,
    upded,
    deled,

    setDBidang,
    getDBidang,

    addedBidang,
    updedBidang,
    deledBidang,

    getDAnggota,
    addedAnggota,
    updedAnggota,
    deledAnggota,

    getDinasBidang,
    getDataBidang,
    getDataBidangSub,
    getDataSubBidang,
    getDataUraianSub,
    selectSubBidangDinas,

    getrincianDinas,
    actRincian,
    actTriwulan,
    colRincianTw,

    colDinas,
    colBidang,
    colAnggota,
    colSub,
    colRincian,

    cbStatus,
    cbTingkatan,
}
