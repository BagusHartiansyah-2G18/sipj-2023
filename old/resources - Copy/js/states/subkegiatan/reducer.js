import { actType } from './action';
function subReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.dt: 
        return action.payload.dt;
      default:
        return dt;
    }
  }
  
  export default subReducer;