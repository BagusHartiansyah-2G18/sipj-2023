import React from "react";
import { useDispatch } from 'react-redux';
import { useState } from 'react';
import { useInput } from '../../../hooks/useInput';

import { setPimpinan, setTandaTanganManual } from '../../../states/sppd/action';
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
    const opsIsiManual = [
        {
            value:'Manual',
            nmAnggota:'Isi Manual',
            label:'Isi Manual'
        }
    ];

    const [ketOPD, setketOPD] = useInput();
    const [namaOPD, setnamaOPD] = useInput();
    const [onOPD, setonOPD] = useState(0);

    const [ketSetda, setketSetda] = useInput();
    const [namaSetda, setnamaSetda] = useInput();
    const [onSetda, setonSetda] = useState(0);

    const [ketBupati, setketBupati] = useInput();
    const [namaBupati, setnamaBupati] = useInput();
    const [onBupati, setonBupati] = useState(0);


    const [noSPPD, setNoSPPD] = useInput(dwork.noSPPD);


    const dopd      = sfLib.coptionSelect({
                        dt:dt.dinas.concat(dt.plhdinas).concat(dt.plhdinas1).concat(opsIsiManual),
                        row:{label:'nmAnggota', value:'value'},
                    });
    const dbupati   = sfLib.coptionSelect({
                        dt:dt.bupati.concat(dt.plhbupati).concat(opsIsiManual),
                        row:{label:'nmAnggota', value:'value'},
                    });
    const dsetda    = sfLib.coptionSelect({
                        dt:dt.setda.concat(dt.plhsetda).concat(opsIsiManual),
                        row:{label:'nmAnggota', value:'value'},
                    });
    if(dinas === undefined && dwork.pimOpd!==undefined){
        if(dwork.pimOpd === 'Manual'){
            setdinas({
                ...opsIsiManual[0]
            })
            isiManualForm({ dari:'OPD', isi: dwork.tdOPD });
        }else{
            const i =dopd.findIndex((val)=> val.value === dwork.pimOpd );
            setdinas({
                ...dopd[i]
            })
        }

    }
    if(bupati === undefined && dwork.pimBupati!==undefined){
        if(dwork.pimBupati === 'Manual'){
            setbupati({
                ...opsIsiManual[0]
            })
            isiManualForm({ dari:'BUPATI', isi: dwork.tdBUPATI });
        }else{
            const i =dbupati.findIndex((val)=> val.value === dwork.pimBupati );
            setbupati({
                ...dbupati[i]
            })
        }

    }
    if(setda === undefined && dwork.pimSetda!==undefined){
        if(dwork.pimSetda === 'Manual'){
            setsetda({
                ...opsIsiManual[0]
            })
            isiManualForm({ dari:'SETDA', isi: dwork.tdSETDA });
        }else{
            const i =dsetda.findIndex((val)=> val.value === dwork.pimSetda );
            setsetda({
                ...dsetda[i]
            })
        }

    }

    const actSetPimpinanDinas = (v) =>{
        if(v.value === 'Manual'){
            isiManualForm({ dari:'OPD', isi: dwork.tdOPD });
        }else{
            setonOPD(0);
        }
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
        if(v.value === 'Manual'){
            isiManualForm({ dari:'BUPATI', isi: dwork.tdBUPATI });
        }else{
            setonBupati(0);
        }
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
        if(v.value === 'Manual'){
            isiManualForm({ dari:'SETDA', isi: dwork.tdSETDA });
        }else{
            setonSetda(0);
        }
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
    function isiManualForm({ dari, isi }){
        let split =[];
        if( isi==null || isi.length<4){
            split.push('','');
        }else{
            split = isi.split('&');
        }
        switch (dari) {
            case 'OPD':
                setonOPD(1);
                setketOPD({target:{value:split[0]}})
                setnamaOPD({target:{value:split[1]}})
            break;
            case 'SETDA':
                setonSetda(1);
                setketSetda({target:{value:split[0]}})
                setnamaSetda({target:{value:split[1]}})
            break;
            default:
                setonBupati(1);
                setketBupati({target:{value:split[0]}})
                setnamaBupati({target:{value:split[1]}})
            break;
        }
    }

    const saveTandaTangan = (dari) =>{
        let col,value;
        switch (dari) {
            case 'OPD':
                col = 'tdOPD';
                value = ketOPD+"&"+namaOPD;
            break;
            case 'SETDA':
                col = 'tdSETDA';
                value = ketSetda+"&"+namaSetda;
            break;
            default:
                col = 'tdBUPATI';
                value = ketBupati+"&"+namaBupati;
            break;
        }
        dispatch(
            setTandaTanganManual({
                col,
                value,
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
                        <div className="flexR w100p justifySA">
                            <div className={`ptb10px ${(onOPD ? 'w45p':'w100p')} `}>
                                <label className="fbold">Pimpinan</label><br></br>
                                <Select
                                    options={dopd}
                                    placeholder="Select"
                                    value={dinas}
                                    onChange={actSetPimpinanDinas}
                                    isSearchable={true}
                                />
                            </div>
                            {
                                (
                                    onOPD ?
                                    <div className="pwrap w45p borderL borderLeftTB10px">
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Keterangan Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea  rows={3} className="borderR10px pwrap w100p" value={ketOPD} onChange={setketOPD}></textarea>
                                            </div>
                                        </div>
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Nama Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea rows={3} className="borderR10px pwrap w100p" value={namaOPD} onChange={setnamaOPD}></textarea>
                                            </div>
                                        </div>
                                        <div className="btnGroup">
                                            <button className="btn2 bwarning"  onClick={()=>saveTandaTangan('OPD')}>perbarui</button>
                                        </div>
                                    </div>
                                    :''
                                )
                            }
                        </div>
                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>2. Surat Perjalanan Dinas (BUPATI)</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/sppdBupatiSetda/${btoa(JSON.stringify({...param,tglCetak}))}`}
                                className="btn2 bwarning ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box fz25" /> Dokumen SETDA
                            </Link>
                            <Link
                                to={`/pdf/sppdBupati/${btoa(JSON.stringify({...param,tglCetak}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body ">
                        <div className="flexR w100p justifySA">
                            <div className={`ptb10px ${(onBupati ? 'w45p':'w100p')} `}>
                                <label className="fbold">Pimpinan</label><br></br>
                                <Select
                                    options={dbupati}
                                    placeholder="Select"
                                    value={bupati}
                                    onChange={actSetPimpinanBupati}
                                    isSearchable={true}
                                />
                            </div>
                            {
                                (
                                    onBupati ?
                                    <div className="pwrap w45p borderL borderLeftTB10px">
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Keterangan Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea rows={3} className="borderR10px pwrap w100p" value={ketBupati} onChange={setketBupati}></textarea>
                                            </div>
                                        </div>
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Nama Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea rows={3} className="borderR10px pwrap w100p" value={namaBupati} onChange={setnamaBupati}></textarea>
                                            </div>
                                        </div>
                                        <div className="btnGroup">
                                            <button className="btn2 bwarning"  onClick={()=>saveTandaTangan('BUPATI')}>perbarui</button>
                                        </div>
                                    </div>
                                    :''
                                )
                            }
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
                        <div className="flexR w100p justifySA">
                            <div className={`ptb10px ${(onSetda ? 'w45p':'w100p')} `}>
                                <label className="fbold">Pimpinan</label><br></br>
                                <Select
                                    options={dsetda}
                                    placeholder="Select"
                                    value={setda}
                                    onChange={actSetPimpinanSetda}
                                    isSearchable={true}
                                />
                            </div>
                            {
                                (
                                    onSetda ?
                                    <div className="pwrap w45p borderL borderLeftTB10px">
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Keterangan Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea rows={3} className="borderR10px pwrap w100p" value={ketSetda} onChange={setketSetda}></textarea>
                                            </div>
                                        </div>
                                        <div className="doubleInput ptb10px borderB">
                                            <label>Nama Penanda Tangan</label>
                                            <div className="iconInput2 ">
                                                <textarea rows={3} className="borderR10px pwrap w100p" value={namaSetda} onChange={setnamaSetda}></textarea>
                                            </div>
                                        </div>
                                        <div className="btnGroup">
                                            <button className="btn2 bwarning"  onClick={()=>saveTandaTangan('SETDA')}>perbarui</button>
                                        </div>
                                    </div>
                                    :''
                                )
                            }
                        </div>

                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>4. Kwitansi</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({...param,tglCetak,noSPPD}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <div className="doubleInput ptb10px borderB">
                            <label>No SPPD</label>
                            <div className="iconInput2 ">
                                <input className="borderR10px" type="text" value={noSPPD} onChange={setNoSPPD} placeholder="000.1.2.3/....." />
                                <span className={`mdi mdi-cloud-search cdark `}></span>
                            </div>
                        </div>
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
