import { configureStore } from '@reduxjs/toolkit';
import dinasReducer from './dinas/reducer';
import subReducer from './subKegiatan/reducer';
import rekReducer from './rekeningB/reducer';
import jenisReducer from './jenisP/reducer';
import htmlReducer from './sfHtml/reducer';
import sppdReducer from './sppd/reducer';

const store = configureStore({
    reducer: {
      _dinas: dinasReducer, 
      _sub: subReducer, 
      _rek: rekReducer, 
      _jenis:jenisReducer,
      _html:htmlReducer,
      _sppd:sppdReducer,
    },
});
  
export default store;