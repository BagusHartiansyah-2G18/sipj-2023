import api from "../../utils/api";

const nm = 'subkegiatan';
const actType = {
  dt      : 'data'+nm,
  add     : 'entri'+nm,
  upd     : 'update'+nm,
  del     : 'delete'+nm, 
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
          const dt = await api.GET({url:'sub'}); 
          dispatch(setDT(dt));
        } catch (error) {
          // alert(error.message);
        }
        // dispatch(hideLoading());
    };
} 
function getSub($kdDinas) {
  return async (dispatch) => {
      // dispatch(showLoading());
      try {
        const dt = await api.GET({url:'sub/'+$kdDinas}); 
        dispatch(setDT(dt));
      } catch (error) {
        // alert(error.message);
      }
      // dispatch(hideLoading());
  };
} 


const colSub = [
  {
      name: 'Kode',
      selector: row => row.kdSub,
      width : '150px'
  },{
      name: 'Sub Kegiatan',
      selector: row => row.nmSub,
  }
];  
const colUrusan = [
  {
      name: 'Kode',
      selector: row => row.value,
      width : '150px'
  },{
      name: 'URUSAN BIDANG PROGRAM KEGIATAN',
      selector: row => row.label,
  }
]; 
export {
    actType,
    setDT,
    getDT, 
    getSub,

    colSub,
    colUrusan
}