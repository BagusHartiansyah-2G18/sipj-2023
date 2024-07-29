import { actType } from './action';
function jenisReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.dt:
        return action.payload.dt;
      case actType.upd:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              nmJPJ:action.payload.nmJPJ
            };
          }
          return v;
        });
      case actType.del:
        return dt.filter((v,i)=> i!=action.payload.ind); 
      case actType.dtDukung:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              dukung: action.payload.dt,
            };
          }
          return v;
        });
      case actType.updDukung:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              dukung : v.dukung.map((v1,i1)=>{
                if(i1 === action.payload.index){
                  return {
                    ...v1,
                    nmDP : action.payload.nmDP
                  }
                }
                return v1;
              })
            };
          }
          return v;
        });
      case actType.delDukung:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              dukung : v.dukung.filter((v1,i1)=> i1!=action.payload.index)
            }
          }
          return v;
        }); 
      default: 
        return dt;
    }
}
  
  export default jenisReducer;