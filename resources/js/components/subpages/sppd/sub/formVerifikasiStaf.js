import React,{useState} from "react";
import { useInput } from '../../../../hooks/useInput';
import { cbTingkatan } from '../../../../states/dinas/action'
import Select from "react-select";

export default function FormVerifikasiStaf({ value, saved, ind }) {  
    const { nmAnggota,golongan,nmJabatan,nip,tingkatan } =( value.fileD!=undefined && value.fileD.length>2 ? 
        {...value, ...JSON.parse(atob(value.fileD))}
        :value
    );
    const [nama, _nama] = useInput(nmAnggota);
    const [gol, _gol] = useInput(golongan);
    const [jabatan, _jabatan] = useInput(nmJabatan);
    const [fnip, _fnip] = useInput(nip); 
    const findex = cbTingkatan.findIndex(v=> v.value == tingkatan); 
    const [ tingkat, settingkat] = useState({value:cbTingkatan[findex].value,label:cbTingkatan[findex].label});

    if(value.start){
        _nama({target:{value:nmAnggota}});
        _gol({target:{value:golongan}});
        _jabatan({target:{value:nmJabatan}});
        _fnip({target:{value:nip}}); 
        const findex1 = cbTingkatan.findIndex(v=> v.value == tingkatan); 
        settingkat({value:cbTingkatan[findex1].value,label:cbTingkatan[findex1].label});
        value.start =false;
    }

    return (
        <div class="FM1 ">
            <div class="header bwhite">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Verifikasi Data </b> 
                    </h2>
                </div> 
                <div class="btnGroup">
                    <button class="btn2 bsuccess " onClick={()=>
                        saved({
                            nmAnggota:nama,golongan:gol,nmJabatan:jabatan,nip:fnip,ind,
                            tingkatan:tingkat.value
                        })}>
                        <span class="mdi mdi-account-check  fzXl"></span> Perbarui Data
                    </button>
                </div>
            </div>
            <div class="body blight flexC jcSA" style={{width:"unset", padding:"10px" }}><br/>
                
                <div class="doubleInput  bdahedB1">
                    <label>Nama</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={nama} onChange={_nama} placeholder="Bagus H.." />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>Pangkat/Gol</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={gol} onChange={_gol} placeholder="IT dev" />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>NIP</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={fnip} onChange={_fnip} placeholder="0012" />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>
                <div class="doubleInput  bdahedB1">
                    <label>Jabatan</label>
                    <div class="iconInput2 ">
                        <input className=" borderR10px" type="text" value={jabatan} onChange={_jabatan} placeholder="dev" />
                        <span class="mdi mdi-cloud-search cprimary "></span>
                    </div>
                </div>  
                <div className="doubleInput ptb10px">
                    <label>Tingkatan</label>
                    <Select
                        options={cbTingkatan}
                        placeholder="Select Tingkatan"
                        value={tingkat}
                        onChange={settingkat}
                        isSearchable={true}
                    />
                </div>
            </div>
        </div>
            
    )
}