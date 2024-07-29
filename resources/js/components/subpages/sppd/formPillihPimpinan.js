import React,{ useState } from "react";
import { useDispatch } from 'react-redux';

import { setPimpinan} from '../../../states/sppd/action';
import sfLib from "../../mfc/sfLib";
import PropTypes from "prop-types";
import Select from "react-select"; 

import FormVerifikasiPimpinan from "./sub/formVerifikasiPimpinan";

function FormPilihPimpinan({ dt, param, indWork, dwork }) {  
    const dispatch = useDispatch();    
    const realDOpd = dt.dinas.concat(dt.plhdinas).concat(dt.plhdinas1);
    const dopd      = sfLib.coptionSelect({
        dt:realDOpd,
        row:{label:'nmAnggota', value:'value'},
        xind:true
    }); 
    const realSetda = dt.setda.concat(dt.plhsetda); 
    const dsetda    = sfLib.coptionSelect({
        dt:realSetda,
        row:{label:'nmAnggota', value:'value'},
        xind:true
    });

    
    let xind = (dwork.pimOpd==null ? {...dopd[0], ind:0}: false); 
    if(!xind){  
        xind = JSON.parse(atob(dwork.pimOpd));  
    } 
    const [ dinas, setdinas] = useState(xind);
    
    xind = (dwork.pimSetda==null ?  {...dsetda[0], ind:0}:false); 
    if(!xind){
        xind = JSON.parse(atob(dwork.pimSetda));  
    } 
    const [ setda, setsetda] = useState(xind); 
    if (dt.length===0) {
        return (<> </>);
    } 

    const actSetPimpinanDinas = (v) =>{ 
        setdinas(v);
        const {nip,nmAnggota,nmJabatan,golongan} = realDOpd[v.value]; 
        dispatch(
            setPimpinan({
                col: "pimOpd",
                value:{ nip,nmAnggota,nmJabatan,golongan, ind:v.value, ...v,manual:"no" },
                ...param,
                ind : indWork,
                manual:"no"
            })
        );

        
    } 
    const actSetPimpinanSetda = (v) =>{ 
        setsetda(v);
        const {nip,nmAnggota,nmJabatan,golongan} = realSetda[v.value];
        dispatch(
            setPimpinan({
                col: "pimSetda",
                value:{ nip,nmAnggota,nmJabatan,golongan, ind:v.value, ...v,manual:"no"} ,
                ...param,
                ind : indWork,
                
            })
        );
    }
    function isiManualForm(v){  
        if(v.kunci=="pimSetda"){
            setsetda(v);
        }else{
            setdinas(v);
        } 
        return dispatch(setPimpinan({
            col: v.kunci,
            value:{...v,manual:"yes", start:true},
            ...param,
            ind : indWork
        }));
    }  


    const pimpinan =()=>{  
        return(
            <div className="Mcontainer2Form">
                <div className="right-1" >
                    <FormVerifikasiPimpinan
                        dt={{...(Object.keys(setda).length > 3 ? setda:{...realSetda[setda.value],...setda}), start:true}}
                        saved={isiManualForm}
                        kunci="pimSetda" 
                    ></FormVerifikasiPimpinan>
                </div>
                <div className="left ">
                    <div class="FM1 ">
                        <div class="header bwhite">
                            <div class="cdark flexR">
                                <button className="btn bnone">
                                    <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                                </button>
                                <h2 className="  pl0 aiE fBebasNeue">
                                    <b>Pilih Pimpinan {`(PEMBERI PERINTAH)`}</b> 
                                </h2>
                            </div>  
                        </div>
                        <div class="body  bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                            <Select
                                options={dsetda}
                                placeholder="Select"
                                value={setda}
                                onChange={actSetPimpinanSetda}
                                isSearchable={true}
                            /><br/>
                        </div>
                    </div> 
                </div>
            </div> 
        );
    } 
    const pimpinanSKPD=()=>{
        return(
            <div className="Mcontainer2Form">
                <div className="right-1" >
                    <FormVerifikasiPimpinan
                        dt={{...(Object.keys(dinas).length > 3 ? dinas:{...realDOpd[dinas.value],...dinas }), start:true}}
                        saved={isiManualForm}  
                    ></FormVerifikasiPimpinan>
                </div>
                <div className="left ">
                    <div class="FM1 ">
                        <div class="header bwhite">
                            <div class="cdark flexR">
                                <button className="btn bnone">
                                    <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                                </button>
                                <h2 className="  pl0 aiE fBebasNeue">
                                    <b>Pilih Pimpinan {`( PEMOHON SURAT TUGAS )`}</b> 
                                </h2>
                            </div>  
                        </div>
                        <div class="body  bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                            <Select
                                options={dopd}
                                placeholder="Select"
                                value={dinas}
                                onChange={actSetPimpinanDinas}
                                isSearchable={true}
                            /><br/>
                        </div>
                    </div> 
                </div>
            </div> 
        ); 
    }
    return (
        <>
            {pimpinan()}
            {pimpinanSKPD()}
        </>
    ); 
}
FormPilihPimpinan.propTypes = {
    dt : PropTypes.object.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    dwork : PropTypes.object.isRequired
}
export default FormPilihPimpinan;
