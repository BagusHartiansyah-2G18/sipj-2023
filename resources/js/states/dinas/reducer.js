import { forEach } from 'lodash';
import { actType } from './action';
function dinasReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.dt:
        return action.payload.dt;
      case actType.upd:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return action.payload;
          }
          return v;
        });
      case actType.del:
        return dt.filter((v,i)=> i!=action.payload.ind);

      // batas
      case actType.dtBidangSub:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              ...action.payload.bidang
            };
          }
          return v;
        });
    case actType.dtBidang:
        return dt.map((v,ind)=>{
            if(ind === action.payload.ind){
            return {
                ...v,
                bidang: action.payload.bidang
            };
            }
            return v;
        });
    case actType.dtSubBidangKhusus:
        // console.log(action.payload);
        return dt.map((v,ind)=>{
            if(ind === action.payload.ind){
                return {
                    ...v,
                    bidang: v.bidang.map((v1,i1)=>{
                        if(i1 === action.payload.index){
                            return {
                                ...v1,
                                sub : action.payload.sub
                            }
                        }
                        return v1;
                    })
                };
            }
            return v;
        });
    case "actType.dtBidang jika ada error":
        return dt.map((v,ind)=>{
            if(ind === action.payload.ind){
            return {
                ...v,
                bidang: action.payload.bidang,
            };
            }
            return v;
        });
      case actType.updBidang:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              bidang : v.bidang.map((v1,i1)=>{
                if( i1 === action.payload.index ){
                  return {
                    ...v1,
                    nmBidang:action.payload.nmBidang,
                    asBidang:action.payload.asBidang,
                  };
                }
                return v1;
              })
            }
          }
          return v;
        });
      case actType.delBidang:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              bidang : v.bidang.filter((v1,i1)=> i1!=action.payload.index)
            }
          }
          return v;
        });

      case actType.dtAnggota:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              bidang: v.bidang.map((v1,i1)=>{
                if(i1 === action.payload.index){
                  return {
                    ...v1,
                    anggota : action.payload.anggota
                  }
                }
                return v1;
              })
            };
          }
          return v;
        });
      case actType.updAnggota:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              bidang : v.bidang.map((v1,i1)=>{
                if( i1 === action.payload.index ){
                  return {
                    ...v1,
                    anggota : v1.anggota.map((v2,i2)=>{
                      if( i2 === action.payload.index1){
                        return {
                          ...v2,
                          nmAnggota : action.payload.nmAnggota,
                          nmJabatan : action.payload.nmJabatan,
                          nip : action.payload.nip,
                          status : action.payload.status,
                        }
                      }
                      return v2;
                    })
                  };
                }
                return v1;
              })
            }
          }
          return v;
        });
      case actType.delAnggota:
        return dt.map((v,ind)=>{
          if(ind === action.payload.ind){
            return {
              ...v,
              bidang : v.bidang.map((v1,i1)=>{
                if( i1 === action.payload.index ){
                  return {
                    ...v1,
                    anggota : v1.anggota.filter((v2,i2)=> i2!=action.payload.index1)
                  };
                }
                return v1;
              })
            }
          }
          return v;
        });

      case actType.selectSubKeg:
        return dt.map((v,i)=>{
          if(i === action.payload.ind){
            return {
              ...v,
              sub : v.sub.map((v1,i1)=>{
                      if(i1 === action.payload.index){
                        return {
                          ...v1,
                          kdBidang :action.payload.kdBidang
                        }
                      }
                    return v1;
                  })
            }
          }
          return v;
        });
      case actType.delselectSubKeg:
        return dt.map((v,i)=>{
          if(i === action.payload.ind){
            return {
              ...v,
              sub : v.sub.map((v1,i1)=>{
                if(i1 === action.payload.index){
                  return {
                    ...v1,
                    kdBidang :''
                  }
                }
              return v1;
            })
            }
          }
          return v;
        })
      case actType.actRincian:
        return dt.map((v,i)=>{
          if(i === action.payload.ind){
            return {
              ...v,
              bidang : v.bidang.map((v1,i1)=>{
                if( i1 === action.payload.index){
                  return {
                    ...v1,
                    sub: actRincian({dt: v1, act: action.payload })
                  }
                }
                return v1;
              })
            }
          }
          return v;
        })
        default:
          return dt;
    }
}

export default dinasReducer;


function actRincian({ dt, act }){
  switch (act.act) {
    case 'upded':
      return dt.sub.map((v2,i2)=>{
        if(i2 === act.index_1){
          return {
            ...v2,
            rincian: v2.rincian.map((v3,i3)=>{
              if(i3 === act.index_2){
                return {
                  ...v3,
                  nama: act.nama,
                  total: act.total,
                  kdJenis: act.kdJenis,
                  nmJPJ: act.nmJPJ,
                  kdApbd6: act.kdApbd6,
                  nmApbd6: act.nmApbd6
                }
              }
              return v3;
            })
          }
        }
        return v2;
      })
    case 'deled':
      return dt.sub.map((v2,i2)=>{
        if(i2 === act.index_1){
          return {
            ...v2,
            rincian : v2.rincian.filter((v3,i3)=> i3!=act.index_2)
          }
        }
        return v2;
      })
    case 'addedTriwulan':
      return dt.sub.map((v2,i2)=>{
        if(i2 === act.index_1){
          return {
            ...v2,
            rincian : v2.rincian.map((v3,i3)=>{
              if(i3 == act.index_2){
                return {
                  ...v3,
                  tw1 : act.tw1,
                  tw2 : act.tw2,
                  tw3 : act.tw3,
                  tw4 : act.tw4,
                  ada : 1,
                }
              }
              return v3;
            })
          }
        }
        return v2;
      })
    default: // add
      return dt.sub.map((v2,i2)=>{
              if(i2 === act.index_1){
                return {
                  ...v2,
                  rincian :act.dt
                }
              }
              return v2;
            })
  }
}
