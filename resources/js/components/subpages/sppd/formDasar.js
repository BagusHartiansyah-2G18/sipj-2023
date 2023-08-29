import React from "react";
import { useDispatch } from 'react-redux';

import { useState } from 'react';
import {  uploadDasar, cbDasar } from '../../../states/sppd/action';

import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import { toast } from 'react-toastify';

import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";
import Select from "react-select";

function FormDasar({ dt, modalC, param, indWork, setview }) {
    const dispatch = useDispatch();
    const [onOff] = useState(1);

    const [files, setfiles] = useState({ nama:dt.fileD});
    const [ dasar, setdasar] = useState({value:cbDasar[0].value,label:cbDasar[0].label});


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
                        perbarui data Dasar Kegiatan ?
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
        dispatch(uploadDasar({
            ...param,
            ind:indWork,
            files,
            dasar:dasar.value,
        }));
        mclose();
        setview(1);
    }
    if (dt === undefined || dt === null) {
        return <></>;
    }
    return (
        <div className={(onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
            <div className="form1 bwhite boxShadow1px ">
                <div className="header binfo cwhite">
                    <div className="icon">
                        <span className="mdi mdi-circle-slice-2 fz25 "></span>
                        <h3><b>1. Upload Dasar Kegiatan Perjalanan Dinas</b></h3>
                    </div>
                    <div>
                        <button className="btn2 bprimary clight" onClick={()=>saved()}>
                            <span className="mdi mdi-check-circle  fz25" /> Save
                        </button>
                    </div>
                 </div>
                <div className="body">
                    <div className="flexC w80p">
                        <div className="flexR justifySB">
                            <div className="labelInput2  ptb10px">
                                <label className="mw100px"><span className={`mdi mdi-file-send cprimary fziconS`}></span>Dasar</label>
                                <Select
                                    options={cbDasar}
                                    placeholder="Select Dasar"
                                    value={dasar}
                                    onChange={setdasar}
                                    isSearchable={true}
                                />
                            </div>
                        </div>
                        <div className="flexR justifySB">
                            <div className="labelInput2 ptb10px">
                                <label className="mw100px"><span className={`mdi mdi-file-upload cprimary fziconS`}></span>Dokumen</label>
                                <input className="borderR10px" type="file" value=''
                                    onChange={(e)=>sfLib.readFile(e.target,setfiles)} />
                            </div>
                            <div>
                                {
                                    (
                                        files!='' &&
                                        <div className="pwrap boxShadow1px borderR10px">
                                            <span className={`mdi mdi-cloud-upload cprimary fziconS justifyC`}></span>
                                            <h5><b>{dt.dasar}</b>-{files.nama}</h5>
                                        </div>
                                    )
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
FormDasar.propTypes = {
    dt : PropTypes.object.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    modalC : PropTypes.func.isRequired
}
export default FormDasar;
