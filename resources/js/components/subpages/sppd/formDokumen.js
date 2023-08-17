import React from "react";
import { useDispatch } from 'react-redux';
import { useState } from 'react';

import { workDelAnggota, addWorkUraian, updWorkUraian, delWorkUraian } from '../../../states/sppd/action';
import sfHtml from "../../mfc/sfHtml";
import sfLib from "../../mfc/sfLib";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import PropTypes from "prop-types";
import Select from "react-select";
import {Link} from "react-router-dom";

function FormDokumen({ dt, param, modalC, indWork }) {
    const dispatch = useDispatch();

    const [ plhSetda, setplhSetda] = useState();

    if (dt.length===0) {
        return <></>;
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
                <div className="form1 bwhite">
                    <div className="header">
                        <h3>1. Surat Tugas - Permohonan SPD</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/SuratTugasSppd/${btoa(JSON.stringify(param))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <ul className="justifySA">
                            <li className="ptb10px">
                                <label className="fbold">Pimpinan</label><br></br>
                                <span>{dt.dinas[0].nmAnggota}</span>
                            </li>
                            <li className="ptb10px">
                                <label className="fbold">Plh (1)</label><br></br>
                                <span>{dt.plhdinas[0].nmAnggota}</span>
                            </li>
                            {/* <li className="ptb10px">
                                <label className="fbold">Plh (2)</label><br></br>
                                <Select
                                    options={sfLib.coptionSelect({
                                        dt:dt.plhdinas,
                                        row:{label:'nmAnggota'},
                                        xind:true
                                    })}
                                    placeholder="Select Bidang"
                                    value={selectedOptions}
                                    onChange={selectBidang}
                                    isSearchable={true}
                                />
                            </li> */}
                        </ul>
                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>2. Surat Perjalanan Dinas (BUPATI)</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/sppdBupati/${btoa(JSON.stringify(param))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <ul className="justifySA">
                            <li className="ptb10px">
                                <label className="fbold">BUPATI</label><br></br>
                                <span>{dt.bupati[0].nmAnggota}</span>
                            </li>
                            <li className="ptb10px">
                                <label className="fbold">Plh (1)</label><br></br>
                                <span>{dt.plhbupati[0].nmAnggota}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div className="form1 bwhite">
                    <div className="header">
                        <h3>3. Surat Perjalanan Dinas (SETDA)</h3>
                        <div className="btnGroup">
                            <Link
                                to={`/pdf/sppdSetda/${btoa(JSON.stringify(param))}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                <span className="mdi mdi-file-pdf-box clight fz25" /> Dokumen
                            </Link>
                        </div>
                    </div>
                    <div className="body">
                        <ul className="justifySA">
                            <li className="ptb10px">
                                <label className="fbold">Pimpinan</label><br></br>
                                <span>{dt.setda[0].nmAnggota}</span>
                            </li>
                            <li className="ptb10px">
                                <label className="fbold">Plh</label><br></br>
                                <Select
                                    options={sfLib.coptionSelect({
                                        dt:dt.plhsetda,
                                        row:{label:'nmAnggota'},
                                        xind:true
                                    })}
                                    placeholder="Select PLH"
                                    value={plhSetda}
                                    onChange={setplhSetda}
                                    isSearchable={true}
                                />
                            </li>
                            {/* <li className="ptb10px">
                                <label className="fbold">Total Pegawai</label><br></br>
                                <span>{dt.date} - {dt.dateE}</span>
                            </li> */}
                        </ul>
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
    modalC : PropTypes.func.isRequired
}
export default FormDokumen;
