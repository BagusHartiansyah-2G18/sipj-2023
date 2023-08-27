import React from "react";
import { useDispatch } from 'react-redux';
import { useState } from 'react';
import { useInput } from '../../../hooks/useInput';

import { setPimpinan } from '../../../states/sppd/action';
import sfLib from "../../mfc/sfLib";
import PropTypes from "prop-types";
import Select from "react-select";
import {Link} from "react-router-dom";

function FormDokumen({ dt, param, indWork, dwork }) {
    const dispatch = useDispatch();

    const [ dinas, setdinas] = useState();
    const [ setda, setsetda] = useState();
    const [ bupati, setbupati] = useState();

    const date = new Date().setDate(new Date().getDate());
    const [ tglCetak, settglCetak] = useInput(new Date(date).toISOString().split('T')[0]);


    if (dt.length===0) {
        return <></>;
    }

    const dopd      = sfLib.coptionSelect({
                        dt:dt.dinas.concat(dt.plhdinas).concat(dt.plhdinas1),
                        row:{label:'nmAnggota', value:'value'},
                    });
    const dbupati   = sfLib.coptionSelect({
                        dt:dt.bupati.concat(dt.plhbupati),
                        row:{label:'nmAnggota', value:'value'},
                    });
    const dsetda    = sfLib.coptionSelect({
                        dt:dt.setda.concat(dt.plhsetda),
                        row:{label:'nmAnggota', value:'value'},
                    });
    if(dinas === undefined && dwork.pimOpd!==undefined){
        const i =dopd.findIndex((val)=> val.value === dwork.pimOpd );
        setdinas({
            ...dopd[i]
        })
    }
    if(bupati === undefined && dwork.pimBupati!==undefined){
        const i =dbupati.findIndex((val)=> val.value === dwork.pimBupati );
        setbupati({
            ...dbupati[i]
        })
    }
    if(setda === undefined && dwork.pimSetda!==undefined){
        const i =dsetda.findIndex((val)=> val.value === dwork.pimSetda );
        setsetda({
            ...dsetda[i]
        })
    }

    const actSetPimpinanDinas = (v) =>{
        setdinas(v);
        dispatch(
            setPimpinan({
                col: "pimOpd",
                value: v.value,
                ...param,
                ind : indWork
            })
        );
    }

    const actSetPimpinanBupati = (v) =>{
        setbupati(v);
        dispatch(
            setPimpinan({
                col: "pimBupati",
                value: v.value,
                ...param,
                ind : indWork
            })
        );
    }

    const actSetPimpinanSetda = (v) =>{
        setsetda(v);
        dispatch(
            setPimpinan({
                col: "pimSetda",
                value: v.value,
                ...param,
                ind : indWork
            })
        );
    }

    return (
        <div className="form1 bwhite boxShadow1px ">
            <div className="header binfo cwhite">
                <div className="icon">
                    <span className="mdi mdi-circle-slice-7 fz25 "></span>
                    <h3><b>4. Progres Dokumen</b></h3>
                </div>
            </div>
            <div className=" w95p m0auto ptb10px">
                <div className="ptb10px">
                    <div className="doubleInput ptb10px">
                        <label>Tanggal Cetak</label>
                        <div className="iconInput2">
                            <input className="borderR10px" type="date" value={tglCetak} onChange={settglCetak} placeholder="Nama Anggota" />
                            <span className={`mdi mdi-calendar cprimary `}></span>
                        </div>
                    </div>

                </div>
                <div className="form1 bwhite">
                    <div className="header">
                        <h3>1. Surat Tugas - Permohonan SPD</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/SuratTugasSppd/${btoa(JSON.stringify({...param,tglCetak}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <div className="ptb10px">
                            <label className="fbold">Pimpinan</label><br></br>
                            <Select
                                options={dopd}
                                placeholder="Select"
                                value={dinas}
                                onChange={actSetPimpinanDinas}
                                isSearchable={true}
                            />
                        </div>
                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>2. Surat Perjalanan Dinas (BUPATI)</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/sppdBupati/${btoa(JSON.stringify({...param,tglCetak}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body ">
                        <div className="ptb10px">
                            <label className="fbold">Pimpinan</label><br></br>
                            <Select
                                options={dbupati}
                                placeholder="Select"
                                value={bupati}
                                onChange={actSetPimpinanBupati}
                                isSearchable={true}
                            />
                        </div>

                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>3. Surat Perjalanan Dinas (SETDA)</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/sppdSetda/${btoa(JSON.stringify({...param,tglCetak}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <div className="ptb10px">
                            <label className="fbold">Pimpinan</label><br></br>
                            <Select
                                options={dsetda}
                                placeholder="Select"
                                value={setda}
                                onChange={actSetPimpinanSetda}
                                isSearchable={true}
                            />
                        </div>
                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>4. Kwitansi</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify(param))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                    </div>
                </div>
            </div>
            {/* <div className="footer"></div> */}
        </div>
    );
}
FormDokumen.propTypes = {
    dt : PropTypes.object.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    dwork : PropTypes.object.isRequired
}
export default FormDokumen;
