import api from "../../utils/api";
const nm = 'rekening';
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
          const dt = await api.GET({url:'rekeningB'}); 
          dispatch(setDT(dt));
        } catch (error) {
          // alert(error.message);
        }
        // dispatch(hideLoading());
    };
} 


const colAbpd6 = [
  {
      name: 'Kode',
      selector: row => row.kdApbd6,
      width : '150px'
  },{
      name: 'Nama Belanja',
      selector: row => row.nmApbd6,
      width : '400px'
  }
];  
const colApbd = [
  {
      name: 'Kode',
      selector: row => row.value,
      width : '150px'
  },{
      name: 'Nama Belanja',
      selector: row => row.label,
      width : '400px'
  }
]; 
export {
    actType,
    setDT,
    getDT, 

    colAbpd6,
    colApbd
}