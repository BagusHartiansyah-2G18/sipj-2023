import React from "react";
import { useDispatch } from 'react-redux';

import { useState } from 'react';
import {  uploadDasar, cbDasar } from '../../../states/sppd/action';

import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose, BASE_URL } from '../../../states/sfHtml/action';
import { toast } from 'react-toastify';
import { Link } from "react-router-dom";

import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";
import Select from "react-select";
import FormInfoSpppd from "./formInfoSppd";

function FormDasar({ dt, modalC, param, indWork, setview }) {
    const dispatch = useDispatch();
    const [onOff] = useState(1);

    const [files, setfiles] = useState({ nama:dt.fileD});
    const [ dasar, setdasar] = useState({value:cbDasar[0].value,label:cbDasar[0].label});

    function mclose(){
        dispatch(modalClose());
    } 
    const saved = () =>{  
        if( files.nama==''){
            return toast.error('Mohon untuk menambahkan dokumen !!!');
        }
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                clsH: "bwarning cdark tupper tbold",
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
        dispatch(
                uploadDasar({
                ...param,
                ind:indWork,
                files,
                dasar:dasar.value,
        })).then(resp=>{
            setfiles({nama:resp});
        });
        mclose();
        setview(1);
    }
    if (dt === undefined || dt === null) {
        return <></>;
    }

    return (
        <div className="Mcontainer2Form ">
            <div className="right-1">
                <div class="FM1 "> 
                    <div class="body pwrap_5 " style={{width:"unset" }}><br/>
                        <FormInfoSpppd 
                            dt={dt}
                        ></FormInfoSpppd>
                    </div>
                </div>
            </div>
            <div className="left">
                <div class="FM1 ">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Dasar SPPD</b> 
                            </h2>
                        </div> 
                        <button className="btn2 bprimary clight" onClick={()=>saved()}>
                            <span className="mdi mdi-check-circle  fz25" /> Save
                        </button>
                    </div>
                    <div class="body bdark bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                        <div className="doubleInput cdark ptb10px">
                            <label className="mw100px"><span className={`mdi mdi-file-send cprimary fziconS`}></span>Dasar</label>
                            <Select
                                options={cbDasar}
                                placeholder="Select Dasar"
                                value={dasar}
                                onChange={setdasar}
                                isSearchable={true}
                            />
                        </div>
                        
                        <div className="flexR jcSB aiC">
                                <div className="doubleInput  ptb10px">
                                    <label className="mw100px"><span className={`mdi mdi-file-upload cprimary fziconS`}></span>Dokumen</label>
                                    <input className="borderR10px" type="file" value=''
                                        onChange={(e)=>sfLib.readFile(e.target,setfiles)} />
                                </div> 
                                {
                                    (
                                        files!='' && 
                                        <div className="">
                                             <Link
                                                to={BASE_URL+`viewDasar/`+files.nama}
                                                class="cwhite"
                                                target="_blank">
                                                    <span className={`mdi mdi-cloud-upload cprimary fziconS justifyC`}></span> 
                                                    <b>{dt.dasar}</b>-{files.nama}
                                            </Link>  
                                        </div>
                                    )
                                } 
                        </div>
                        <br/>
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
