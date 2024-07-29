import React,{useState} from "react";

import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
 import {  Step3 } from '../../../states/sppd/action';

import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import { toast } from 'react-toastify';

import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";
import { Link } from "react-router-dom";

function FormFinishSppd({ dt, modalC, param, indWork }) {
    const dispatch = useDispatch();
    const [onOff] = useState(1);

    const { no } =dt;
    const [files, setfiles] = useState(dt.file);
    const [noBuku, setnoBuku] = useInput(dt.noBuku);
    const [tglBuku, settglBuku] = useInput(dt.tglBuku);

    const date = new Date().setDate(new Date().getDate());
    const [ tglCetak, settglCetak] = useInput(new Date(date).toISOString().split('T')[0]);  
    function mclose(){
        dispatch(modalClose());
    }


    const saved = () =>{
        if(files ==='-'){
            return toast.error('Mohon untuk menambahkan dokumen !!!');
        }
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                clsH: " bwarning",
                children : (
                    <p>
                        aksi ini akan mengakhiri tahapan pembuatan dokumen,
                        Apa benar ingin mengunci dan mengarsipkan data ini ?
                    </p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xupded
                    })
                )
            })
        );
        dispatch(
            setHtml({
                modal : true,
            })
        );
    }
    const xupded = () =>{
        dispatch(Step3({
            ...param,
            no: dt.no,
            ind:indWork,
            status: 'final',
            noBuku,
            tglBuku,
            files,
        }));
        mclose();
    }

    if (dt === undefined || dt === null) {
        return <></>;
    }

    return (
        <div className="Mcontainer2Form">
            <div className="right-1" >
                <div class="FM1 ">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Cetak Dokumen</b> 
                            </h2>
                        </div>  
                    </div>
                    <div className="body bdark" style={{width:"unset",padding:"10px"}}>
                        <div className="ptb10px ">
                            <div className="doubleInput ptb10px">
                                <label>Tanggal Cetak</label>
                                <div className="iconInput2">
                                    <input className="borderR10px" type="date" value={tglCetak} onChange={settglCetak} placeholder="Nama Anggota" />
                                    <span className={`mdi mdi-calendar cprimary `}></span>
                                </div>
                            </div> 
                        </div>
                        <div className="doubleInput ">
                            <label>Dokumen Surat Tugas - Permohonan</label> 
                            <div className="Flex-b250 double" style={{ gap:"10px", }}>
                                <Link
                                    to={`/pdf/SuratTugasSppdx/${btoa(JSON.stringify({...param,tglCetak,no}))}`}
                                    className="list bprimary1 radius-10"
                                    target="_blank">
                                    <div class="btn-inline  aiC jcC ">
                                        <span className="mdi mdi-file-pdf-box clight fzL6" /> 
                                        <label style={{lineHeight:"20px"}}>Luar Daerah<br/>{`( SKPD - SEKDA )`}</label>
                                    </div>
                                </Link>
                                <Link
                                    to={`/pdf/SuratTugasSppd/${btoa(JSON.stringify({...param,tglCetak,no}))}`}
                                    className="list bprimary1 radius-10"
                                    target="_blank">
                                    <div class="btn-inline  aiC jcC ">
                                        <span className="mdi mdi-file-pdf-box clight fzL6" /> 
                                        <label style={{lineHeight:"20px"}}>Luar Daerah<br/>{`( SKPD - Plh. SEKDA, Asisten )`}</label>
                                    </div> 
                                </Link>
                                <Link
                                    to={`/pdf/SuratTugasSppdDaerah/${btoa(JSON.stringify({...param,tglCetak,no}))}`}
                                    className="list bprimary1 radius-10"
                                    target="_blank">
                                    <div class="btn-inline  aiC jcC ">
                                        <span className="mdi mdi-file-pdf-box clight fzL6" /> 
                                        <label style={{lineHeight:"20px"}}>Dalam Daerah<br/>{`( SKPD - Asisten  )`}</label>
                                    </div>  
                                </Link>
                            </div>
                        </div>
                        <div className="doubleInput ">
                            <label>Dokumen Lainnya</label> 
                            <div className="Flex-b250 double" style={{ gap:"10px", }}>
                                <Link
                                    to={`/pdf/sppdSetda/${btoa(JSON.stringify({...param,tglCetak,no,sppdDaerah:0}))}`}
                                    className="list bprimary1 radius-10"
                                    target="_blank">
                                    <div class="btn-inline  aiC jcC ">
                                        <span className="mdi mdi-file-pdf-box clight fzL6" /> 
                                        <label style={{lineHeight:"20px"}}>{`( SPD )`} <br/>Surat Perjalanan Dinas </label>
                                    </div>
                                </Link> 
                                <Link
                                    to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({...param,tglCetak,no}))}`}
                                    className="list bprimary1 radius-10"
                                    target="_blank">
                                    <div class="btn-inline  aiC jcC ">
                                        <span className="mdi mdi-file-pdf-box clight fzL6" /> 
                                        <label style={{lineHeight:"20px"}}>Kwitansi</label>
                                    </div>
                                </Link>
                            </div>
                        </div> 
                        {/*
                            <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({...param,}))}`}
                                class="list bsuccess"
                                target="_blank">
                                <div class="btn-inline aiC jcC">
                                    <span className="mdi mdi-file-pdf-box cdark fzL3" /> 
                                    Surat Tugas - Permohonan
                                </div> 
                            </Link> 
                            <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({noSPPD:''}))}`}
                                class=" list bsuccess "
                                target="_blank">
                                <div class="btn-inline aiC jcC">
                                    <span className="mdi mdi-file-pdf-box cdark fzL3" /> 
                                    Surat Perjalanan Dinas {`( SPD )`}
                                </div> 
                            </Link> 
                             <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({...param,tglCetak,noSPPD}))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                            <Link
                                to={`/pdf/kwitansiSppd/${btoa(JSON.stringify({noSPPD:''}))}`}
                                class="list bsuccess"
                                target="_blank">
                                <div class="btn-inline aiC jcC">
                                    <span className="mdi mdi-file-pdf-box cdark fzL3" /> 
                                    Kwitansi
                                </div> 
                            </Link>   */}
                        <br/>
                    </div> 
                </div>
            </div>
            <div className="left ">
                <div class="FM1 ">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Arsip dan Penguncian Data</b> 
                            </h2>
                        </div>  
                        <button className="btn2 bsuccess clight" onClick={()=>saved()}>
                            <span className="mdi mdi-check-circle  fz25" /> Save
                        </button>
                    </div>
                    <div class="body  bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                        <div className="flexC w80p">
                            <div className="flexR justifySB">
                                <div className="labelInput2 ptb10px">
                                    <label className="mw100px"><span className={`mdi mdi-cloud-search cprimary `}></span>No Buku</label>
                                    <input className="borderR10px" type="text" value={noBuku} onChange={setnoBuku} placeholder="No Buku" />
                                </div>
                                <div className="labelInput2 ptb10px">
                                    <label className="mw200px"><span className={`mdi mdi-cloud-search cprimary `}></span>Tanggal Buku</label>
                                    <input className="borderR10px" type="text" value={tglBuku} onChange={settglBuku} placeholder="Tanggal diBukukan" />
                                </div>
                            </div>
                            <div className="flexR justifySB">
                                <div className="labelInput2 ptb10px">
                                    <label className="mw100px"><span className={`mdi mdi-cloud-search cprimary `}></span>Dokumen</label>
                                    <input className="borderR10px" type="file" value=''
                                        onChange={(e)=>sfLib.readFile(e.target,setfiles)}
                                        placeholder="uraian"
                                        />
                                </div>
                                <div>
                                    {
                                        (
                                            files!='-' &&
                                            <div className="pwrap boxShadow1px borderR10px">
                                                <span className={`mdi mdi-cloud-search cprimary fziconS justifyC`}></span>
                                                <h5>{files.nama}</h5>
                                            </div>
                                        )
                                    }
                                </div>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div> 
            </div>
        </div>  
    );
}
FormFinishSppd.propTypes = {
    dt : PropTypes.object.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    modalC : PropTypes.func.isRequired
}
export default FormFinishSppd;
