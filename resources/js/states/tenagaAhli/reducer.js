/* eslint-disable no-case-declarations */
import { json } from 'react-router-dom';
import { actType } from './action';
function taReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.__user:
        return  {
          ...dt,
          duser:action.payload.map((v,i)=>JSON.parse(atob(v.data))),
        };
      case actType.__doc:
        return  {
          ...dt,
          ddoc:action.payload.map((v,i)=>JSON.parse(atob(v.data))),
        };   
      case actType.__checkList:
        return  {
          ...dt,
          checkList:action.payload,
        }; 
      
      case actType.__sjp:  
        return  {
          ...dt,
          ...action.payload,
          data:action.payload.data.map((v1,i1)=>{
            return {
              ...v1,
              data:JSON.parse(atob(v1.data))
            }
          })
        }; 
      case actType._sjp:  
        return  {
          ...dt, 
          data:action.payload.map((v1,i1)=>{
            return {
              ...v1,
              data:JSON.parse(atob(v1.data))
            }
          })
        };
      case actType.updSjp:  
        return  {
          ...dt, 
          data:dt.data.map((v1,i1)=>{
            if(i1 == action.payload.ind){
              return action.payload;
            }
            return v1;
          })
        };
      default:
        return dt;
    }
}

export default taReducer; 
