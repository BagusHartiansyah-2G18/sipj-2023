import { actType } from './action';
function htmlReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.setAll:
        return action.payload.v;
      case actType.leftBar:
        return {
          ...dt,
          leftBar :action.payload.v
        };
      case actType.setHtml:
        // console.log(action.payload);
        return {
          ...dt,
          ...action.payload
        }
      default:
        return dt;
    }
}

export default htmlReducer;