import React,{useState} from "react";
import { useInput } from '../../../../hooks/useInput';
function FormVerifiikasiPimpinan({ dt,saved, kunci="pimOpd" }) { 
    const {nip,nmAnggota,nmJabatan,golongan} = dt;
    const [nipOPD, _nipOPD] = useInput();
    const [namaOPD, _namaOPD] = useInput();
    const [jabatanOPD, _jabatanOPD] = useInput();
    const [pangkatOPD, _pangkatOPD] = useInput();

    if(dt.start){ 
        _nipOPD({target:{value:nip}});
        _namaOPD({target:{value:nmAnggota}});
        _jabatanOPD({target:{value:nmJabatan}});
        _pangkatOPD({target:{value:golongan}});
        
        dt.start = false;
    }

    return (
        <div class="FM1 ">
            <div class="header bwhite">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Verifikasi Data</b> 
                    </h2>
                </div> 
                <div className="btnGroup">
                    <button className="btn2 bwarning"  onClick={()=>saved({
                        ...dt,
                        nip:nipOPD,
                        nmAnggota:namaOPD,
                        nmJabatan:jabatanOPD,
                        golongan:pangkatOPD,
                        kunci
                    })}>perbarui</button>
                </div>
            </div>
            <div className="body bdark" style={{width:"unset"}}>
                <div class="doubleInput  bdahedB1">
                    <label>Nama</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={namaOPD} onChange={_namaOPD} placeholder="Bagus H.." />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>NIP</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={nipOPD} onChange={_nipOPD} placeholder="1202" />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>Jabatan</label>
                    <div class="iconInput2 ">
                        <textarea rows={3} className="borderR10px pwrap w100p" value={jabatanOPD} onChange={_jabatanOPD}></textarea> 
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>Pangkat/Gol</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={pangkatOPD} onChange={_pangkatOPD} placeholder="Pembina" />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div><br/>
            </div> 
        </div>
    );
}
export default FormVerifiikasiPimpinan;