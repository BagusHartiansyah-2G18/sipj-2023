import React, { useState } from "react"; 
import Select from "react-select";
import { useInput } from '../../../hooks/useInput';
import { toast } from "react-toastify";
import sfLib from "../../mfc/sfLib";
import TAlistStaf from "./listStaf";

function TAFEdata({ form, xadded, xupded, close, duser, userOps}){
    const [user,_user] = useState();
    const [userSelected,_userSelected] = useState([]);
    const [bulanS,_bulanS] = useInput('');
    const [bulanE,_bulanE] = useInput('');
    const [totVol,_totVol] = useState(0); 
    const [fbe,_fbe] = useState(0);
    const [ket,_ket] = useState('');
    const [volume,_volume] = useState([]);

    if(form.start != undefined && form.start){
        const row = form.row;
        const fvolume = JSON.parse(row.volume); 
        _bulanS({target:{value:row.taSPJ+'-'+(fvolume[0]<10?'0'+fvolume[0]:fvolume[0])}});
        _fbe(1);
        if(fvolume.length ==2){
            _bulanE({target:{value:row.taSPJ+'-'+(fvolume[1]<10?'0'+fvolume[1]:fvolume[1])}}); 
        } 
        _volume(fvolume);
        _totVol(row.totVol);
        // _user(duser.filter(v=>v.label==row.an).map((v,i)=>v));
        _userSelected(row.data);
        _ket(row.keterangan);
        form.start=false;
    }

    const chgBulanS=(v)=>{ 
        _bulanS(v);
        _fbe(1);
        hitungBulan({ bulan:v});
    }
    const chgBulanE=(v)=>{ 
        _bulanE(v);
        hitungBulan({ bulan:v,start:0 });
    }
    const hitungBulan=({ bulan, start=1 })=>{
        if(start){
            try {
                console.log(bulanE);
                if(bulanE.split("-").length!=2){
                    throw "Bulum terisi";
                };
                return proses2Bulan(bulan.target.value,bulanE);
            } catch (error) {
                volume[0]=__valBulan(bulan.target.value);
                _totVol(1); 
                return _ket(" 1 BULAN ( "+sfLib.__namaBulan(__valBulan(bulan.target.value))+" )");
            }
        }else{
            try {
                if(bulanS.split("-").length!=2 ){
                    throw "Bulum terisi";
                }else{
                    if(bulan.target.value.split("-").length!=2){
                        _volume(volume.splice(0,1));
                        _totVol(1);
                        return _ket(" 1 BULAN ( "+sfLib.__namaBulan(__valBulan(bulanS))+" )");          
                    }
                    return proses2Bulan(bulanS,bulan.target.value);
                } 
            } catch (error) {   
                _ket("");   
                // return toast.error("kondisi ini error !!!");
            }
        } 
    }
    const proses2Bulan=(start,end)=>{
        start= __valBulan(start);
        end = __valBulan(end);
        volume[0]=start;
        volume[1]=end;
        const tot = (end - start)+1;
        if(tot<0){
            toast.error("mohon untuk menyesuaikan ulang, kesalahan input !!!");
            return chgBulanE({target:{}});
        }
        if(tot==1){
            _totVol(1); 
            return _ket(" 1 BULAN ( "+sfLib.__namaBulan(start)+" )");
        }
        _totVol(tot); 
        return _ket(` ${tot} BULAN ( ${sfLib.__namaBulan(start)} - ${sfLib.__namaBulan(end)} )`);
    }
    const __valBulan=(val,tahun=false)=>{
        if(tahun){
            return parseInt(val.split("-")[0]);
        }
        return parseInt(val.split("-")[1]);
    }
    const xadd=()=>{ 
        xadded({ user:userSelected ,keterangan:ket,totVol,totSatuan:'Bulan',volume });
        reset();
    }
    const xupd=()=>{
        xupded({ user:userSelected,keterangan:ket,totVol,totSatuan:'Bulan',volume });
        reset();
    }
    const reset=()=>{
        _bulanS({target:{value:''}});
        _bulanE({target:{value:''}});
        _user('');
        _ket('');
        _userSelected([]);
    }

    const _staf=({value, label})=>{ 
        _user({value, label});
        _userSelected([...userSelected,duser[value]])
    }   
    const delStaf=(indUser)=>{  
       _userSelected(userSelected.filter((v,i)=>i!=indUser));
    }  
    return (
        <>
            <div className={`header ${(form.ins?'bprimary clight':'bwarning cdark')} `}>
                <div className="icon">
                    <span className="mdi mdi-clock-edit-outline fz25"></span>
                    <h3 className="">{(form.ins?'Entri':'Perbarui')} Data</h3>
                </div>
                <button className="btn2 blight cmuted" onClick={close}>Close</button>
            </div>
            <div className="body">
                <div className="flexC w95p justifySA pwrap">
                    <div className={`ptb10px `}>
                        <label className="fbold">Nama Staf / Pegawai</label><br></br>
                        <Select
                            options={userOps}
                            placeholder="Pilih Staf / Pegawai"
                            value={user}
                            onChange={_staf}
                            isSearchable={true}
                        />
                    </div>
                    {(
                        userSelected.length>0 &&
                        <div className="borderB">
                            <TAlistStaf
                                dstaf={userSelected}
                                ondel={delStaf}
                            ></TAlistStaf>
                        </div>
                    )}
                    <div className="doubleInput ptb10px">
                        <label>Dari Bulan</label>
                        <div className="iconInput2">
                            <input className="borderR10px" type="month" value={bulanS} onChange={chgBulanS} placeholder="1-12" />
                            <span className={`mdi mdi-calendar ${(form.ins?'cprimary':'cwarning')} `}></span>
                        </div>
                    </div>
                    {
                        (fbe==1 &&
                            <div className="doubleInput ptb10px">
                                <label>Hingga Bulan</label>
                                <div className="iconInput2">
                                    <input className="borderR10px" type="month" value={bulanE} onChange={chgBulanE} placeholder="1-12" />
                                    <span className={`mdi mdi-calendar ${(form.ins?'cprimary':'cwarning')} `}></span>
                                </div>
                            </div>
                        )
                    }
                    {
                        (ket!='' &&
                            <div className="doubleInput ptb10px">
                                <label>keterangan :</label>
                                <div className="iconInput2">
                                    <label>{ket}</label>
                                </div>
                            </div>
                        )
                    } 
                    
                </div>
            </div>
            <div className="footer posEnd">
                <div className="btnGroup">
                    <button className="btn2"  onClick={close}>Close</button>
                    <button className={`btn2 ${(form.ins?'bprimary':'bwarning')}`}  onClick={(form.ins?xadd:xupd)}>{(form.ins?'Entri':'Perbarui')}</button>
                </div>
            </div>
        </>
    )
}
export default TAFEdata;