import { actType } from './action';
function sppdReducer(dt = [], action = {}) {
    switch (action.type) {
      case actType.dt: 
        return  {
          ...action.payload.dt,
          anggota:action.payload.dt.anggota.map((v,i)=>{
            return {
              ...v,
              ind:i
            }
          })
        };
      case actType.crudWork:
        return selectdwork({dt, act:action.payload});
      case actType.anggota:
        return selectAnggota({dt, act:action.payload});
      default: 
        return dt;
    }
}
  
export default sppdReducer;

function selectAnggota({ dt, act }){
  return {
    ...dt,
    anggota: dt.anggota.map((v,i)=>{ 
      if(i=== act.ind){
        switch (act.type) {
          case actType.anggotaSelect:
            
            return {
              ...v,
              aktif:(v.aktif?0:1)
            }
        }
      }
      return v;
    })
  }
}
function selectdwork({ dt, act }){
  let dwork =[];
  switch (act.type) {
    case actType.add:
      dwork =act.dt;
    break;
    case actType.upd:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            no: act.no,
            date: act.date,
            tujuan: act.tujuan,
          }
        }
        return v;
      })
    break;
    case actType.nextStep.type:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            status:act.status
          }
        }
        return v;
      })
    break;
    case actType.del:
      dwork = dt.dwork.filter((v,i)=>i!=act.ind);
    break;
    case actType.workSetAnggota:
      let anggota=[]; 
      if(act.dt.length>0){ 
        anggota = concatDataAnggotaSelected({
          dataTerpilih: act.dt,
          allData:(dt.dwork[act.ind].anggota === undefined ? dt.anggota:dt.dwork[act.ind].anggota ),
          param: act.param,
          dpendukung: dt.dpendukung,
        })
      } 
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            anggota:(anggota.length>0? anggota:dt.anggota),
          }
        }
        return v;
      })
    break;
    case actType.workDelAnggota:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            anggota:v.anggota.map((v1,i1)=>{
              if(i1 === act.index){
                return {
                  ...v1,
                  xind:undefined,
                }
              }
              return v1;
            }),
          }
        }
        return v;
      })
    break;
    case actType.setUraian:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            anggota:v.anggota.map((v1,i1)=>{
              if(i1 === act.index){ 
                return {
                  ...v1,
                  ddukung: v1.ddukung.map((v2,i2)=>{ 
                    if(i2 === act.index_1){
                      return {
                        ...v2,
                        uraian: act.dt,
                        // [
                        //   ...v2.uraian,
                        //   {
                        //     nilai: 0,
                        //     uraian:'',
                        //     volume:0,
                        //     satuan:''
                        //   }
                        // ] 
                      }
                    }
                    return v2;
                  })
                }
              }
              return v1;
            }),
          }
        }
        return v;
      })
    break;
    case actType.updUraian:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            anggota:v.anggota.map((v1,i1)=>{
              if(i1 === act.index){ 
                return {
                  ...v1,
                  ddukung: v1.ddukung.map((v2,i2)=>{ 
                    if(i2 === act.index_1){
                      return {
                        ...v2,
                        uraian: v2.uraian.map((v3,i3)=>{
                          if(i3 === act.iuraian){
                            return {
                              ...v3,
                              nilai: act.nilai,
                              uraian:act.uraian,
                              volume:act.volume,
                              satuan:act.satuan,
                            }
                          }
                          return v3;
                        })
                      }
                    }
                    return v2;
                  })
                }
              }
              return v1;
            }),
          }
        }
        return v;
      })
    break;
    case actType.delUraian:
      dwork = dt.dwork.map((v,i)=>{
        if(i=== act.ind){
          return{
            ...v,
            anggota:v.anggota.map((v1,i1)=>{
              if(i1 === act.index){ 
                return {
                  ...v1,
                  ddukung: v1.ddukung.map((v2,i2)=>{ 
                    if(i2 === act.index_1){
                      return {
                        ...v2,
                        uraian: v2.uraian.filter((v3,i3)=> i3!=act.iuraian)
                      }
                    }
                    return v2;
                  })
                }
              }
              return v1;
            }),
          }
        }
        return v;
      })
    break;
  }
  return {
    ...dt,
    dwork
  }
}

function concatDataAnggotaSelected({ dataTerpilih, allData, param, dpendukung }){ 
  let xdt = [], add=false;
  allData.forEach((v,i)=>{ 
    add=true;
    dataTerpilih.forEach((v1,i1) => {   
      if(v1.kdBAnggota===v.kdBAnggota && v1.kdBidang===v.kdBidang){
        xdt.push({
            ...v,
            ...param,
            xind: i,
            kdBAnggota: v.kdBAnggota,
            ddukung:(v1.ddukung==undefined? dpendukung: v1.ddukung)
            // uraian:(v1.uraian==undefined? []: v1.uraian)
        });
        add=false;
      }
    });
    if(add){
      xdt.push(v);
    }
  }); 
  // if(dataTerpilih.length != xdt.length){
  //   console.log(dataTerpilih,xdt);
  //   // toast.error('terjadi kesalahan pengelolaan data');
  //   return [];
  // }
  return xdt;
}