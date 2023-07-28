import React, {useRef} from "react";
import { useDispatch, useSelector } from 'react-redux';
import { useForm } from "react-hook-form";

import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';
import {  Step3 } from '../../../states/sppd/action';

import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import { toast } from 'react-toastify';

import sfLib from '../../mfc/sfLib';

function FormFinishSppd({ dt, modalC, param, indWork }) {
    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);

    const [files, setfiles] = useState(dt.file);
    const [noBuku, setnoBuku] = useInput(dt.noBuku);
    const [tglBuku, settglBuku] = useInput(dt.tglBuku);

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
        <div className={(onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
            <div className="form1 bwhite boxShadow1px ">
                <div className="header bprimary clight">
                    <div className="icon">
                        <span className="mdi mdi-office-building-marker fz25 "></span>
                        <h3><b>3. Form Pengarsipan & Penguncian Data</b></h3>
                    </div>
                    <div>
                        <button className="btn2 bsuccess clight" onClick={()=>saved()}>
                            <span className="mdi mdi-check-circle  fz25" /> Save
                        </button>
                    </div>
                 </div>
                <div className="body">

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
                                {/* <input type="file" {...register("file")} className="borderR10px" /> */}


                                {/* <FilesUpload
                                    onFileSelectSuccess={(file) => setfiles(file)}
                                    onFileSelectError={({ error }) => toast.error(error)}
                                    ></FilesUpload> */}
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
                </div>
            </div>
        </div>
    );
}
export default FormFinishSppd;
