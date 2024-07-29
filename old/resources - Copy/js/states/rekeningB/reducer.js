import { actType } from './action';
function rekReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.dt:
        return action.payload.dt;
      default:
        return dt;
    }
  }
  
  export default rekReducer;