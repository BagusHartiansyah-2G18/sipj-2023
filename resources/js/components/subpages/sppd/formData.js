import React from "react";
import { useDispatch } from 'react-redux';

import { coldata, added, upded, deled, actType, nextStep } from '../../../states/sppd/action';
import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';

import Tabel1 from "../../tabel/tabel1";
import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import {Link} from "react-router-dom";
import PropTypes from "prop-types";

function FormData({ dt, modalC, param, dataEntri }) {
    const dispatch = useDispatch();
    const [search, setSearch] = useInput('');
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);
    const [ ind, setind] = useState();

    function mclose(){
        dispatch(modalClose());
    }
    const coll = [...coldata,{
            cell:(v) =>{
                switch (v.status) {
                    case actType.nextStep.start:
                        return (
                            <div className="btnGroup">
                                {/* {tambahan} */}
                                <button className="btn2 bwarning" title="Perbarui" onClick={()=>upd(v)}><span className="mdi mdi-pencil-box cdark fz25" /></button>
                                <button className="btn2 bdanger" title="Hapus"  onClick={()=>del(v)}><span className="mdi mdi-delete-forever clight fz25" /></button>
                                {/* <button className="btn2 bsuccess clight" title="Hapus"  onClick={()=>xnextStep(v)}>Next Step</button> */}
                                <button className="btn2 bprimary clight" title="Open Form" onClick={()=>dataEntri(v)}>Open Form</button>
                            </div>
                        );
                    case actType.nextStep.step1:
                        return (
                            <div className="btnGroup">
                                <button className="btn2 bprimary clight" title="Open Form" onClick={()=>dataEntri(v)}>Open Form</button>
                                <Link
                                    to={`/pdf/sppd/${btoa(JSON.stringify(
                                        {
                                            ...param,
                                            no:v.no,
                                            tujuan: v.tujuan,
                                        }
                                    ))}`}
                                    className="btn2 bsuccess clight ptb0"
                                    target="_blank">
                                    Document
                                </Link>
                            </div>
                        );
                    case actType.nextStep.step3:
                        return (
                            <Link
                                to={`/storage/${v.file}`}
                                className="btn2 bsuccess clight ptb0"
                                target="_blank">
                                Document
                            </Link>
                        );
                }
            }
            ,
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            width: '250px'
        }
    ];
    // const [ no, setno] = useInput();
    const [ lokasi, setlokasi] = useInput();
    const [ date, setdate] = useInput();
    const [ dateE, setdateE] = useInput();
    const [ maksud, setmaksud] = useInput();
    const [ angkut, setangkut] = useInput();
    const [ tempatS, settempatS] = useInput('Taliwang');
    const [ tempatE, settempatE] = useInput();
    const [ anggaran, setanggaran] = useInput();


    function reset(){
        // setno({target:{value:''}});
        setdate({target:{value:''}});
        setlokasi({target:{value:''}});
        setdateE({target:{value:''}});

        setmaksud({target:{value:''}});

        setangkut({target:{value:''}});
        settempatS({target:{value:'Taliwang'}});
        settempatE({target:{value:''}});
        setanggaran({target:{value:''}});
    }

    const close = () =>{
        setOnOff(1);
    }
    const add = () =>{
        reset();
        setIns(1);
        setOnOff(0);
    }
    const xadded = () =>{
        dispatch(added({
            // no,
            lokasi,
            date,
            dateE,
            maksud,
            angkut,
            tempatS,
            tempatE,
            anggaran,
            ...param
        }))
        reset();
    }
    const del = (v) =>{
        const i =dt.findIndex((val)=> val.no === v.no );
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>Apa benar ingin Mengapus data ini ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xdeled:()=>xdeled(i)
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
    const xdeled = (i) =>{
        dispatch(deled({
            ...param,
            ind:i,
            noOld: dt[i].no
        }))
        mclose();
    }
    const xnextStep = (v) =>{
        const i =dt.findIndex((val)=> val.no === v.no );
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>
                        Apa benar ingin melanjutkan pada tahapan berikutnya ?<br></br>
                        aksi ini akan mengunci data ini sehingga tidak dapat disesuaikan kembali
                    </p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        btn:{
                            cls: 'bsuccess clight',
                            onClick:()=>nextSteped(i),
                            text: 'Next Step'
                        }
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
    const nextSteped = (i) =>{
        dispatch(nextStep({
            ...param,
            ind:i,
            no: dt[i].no,
            status: actType.nextStep.step1
        }))
        mclose();
    }
    const upd = (v) =>{
        const i =dt.findIndex((val)=> val.no === v.no );
        setind(i);
        setIns(0);
        setOnOff(0);
        // setno({target:{value:v.no}});
        setdate({target:{value:v.date}});

        setlokasi({target:{value:v.lokasi}});
        setdateE({target:{value:v.dateE}});

        setmaksud({target:{value:v.maksud}});

        setangkut({target:{value:v.angkut}});
        settempatS({target:{value:v.tempatS}});
        settempatE({target:{value:v.tempatE}});
        setanggaran({target:{value:v.anggaran}});
    }
    const xupded = () =>{
        dispatch(upded({
            // no,
            lokasi,
            date,
            dateE,
            maksud,
            angkut,
            tempatS,
            tempatE,
            anggaran,
            ...param,
            ind,
            noOld: dt[ind].no
        }))
        close();
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
                        <h3>Form Data Perjalanan Dinas</h3>
                    </div>
                    <button className="btn2 blight cmuted" onClick={add}>Entri</button>
                </div>
                <div className="body">
                    <Tabel1
                        search={search}
                        oncSearch={setSearch}
                        columns={coll}
                        data={dt.filter((item) => {
                                    if (search === "") {
                                        return item;
                                    } else if (
                                        item.no.toLowerCase().includes(search.toLowerCase())
                                    ) {
                                        return item;
                                    }
                                }
                            )}
                    ></Tabel1>
                </div>
                {/* <div className="footer"></div> */}
            </div>
            <div className={`form2 hmax bwhite updGrid2to1 ${(onOff && 'dnone')}`} id="itemFormLeft">
                <div className={`header ${(ins?'bprimary':'bwarning')} clight`}>
                    <div className="icon">
                        <span className="mdi mdi-clock-edit-outline fz25"></span>
                        <h3 className="">{(ins?'Entri':'Perbarui')} Data</h3>
                    </div>
                    <button className="btn2 blight cmuted" onClick={close}>Close</button>
                </div>
                <div className="w95p m0auto ">
                    {/* <div className="doubleInput ptb10px borderB">
                        <label>No SPPD</label>
                        <div className="iconInput2 ">
                            <input className="borderR10px" type="text" value={no} onChange={setno} placeholder="Nomor SPPD" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                    </div> */}
                    <div className="doubleInput ptb10px borderB">
                        <label>Maksud Perjalanan</label>
                        <div className="iconInput2 ">
                        {/* <input className="borderR10px mh50p" type="area" value={maksud} onChange={setmaksud} placeholder="Maksud Perjalanan" /> */}
                            <textarea rows={3} className="borderR10px pwrap w100p" value={maksud} onChange={setmaksud}></textarea>
                            {/* <div
                                className={`contentEditable borderR10px pwrap w100p mh50p`}
                                // data-placeholder={plac}
                                contentEditable
                                value={maksud}
                                onInput={setmaksud}
                            /> */}
                        </div>
                    </div>
                    <div className="doubleInput borderB">
                        <label>Tempat</label>
                        <div className="double">
                            <div className="labelInput1 w45p">
                                <label>Berangkat</label>
                                <div className="iconInput2 ptb10px">
                                    <input className="borderR10px" type="text" value={tempatS} onChange={settempatS} placeholder="Berangkat" />
                                    <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                                </div>
                            </div>
                            <div className="labelInput1 w45p">
                                <label>Tujuan</label>
                                <div className="iconInput2 ptb10px">
                                    <input className="borderR10px w80p" type="text" value={tempatE} onChange={settempatE} placeholder="Tujuan" />
                                    <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="doubleInput ptb10px borderB">
                        <label>Tempat Kegiatan</label>
                        <div className="iconInput2 ">
                            <input className="borderR10px" type="text" value={lokasi} onChange={setlokasi} placeholder="Tempat Kegiatan" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                    </div>
                    <div className="doubleInput ptb10px borderB">
                        <label>Alat Angkut</label>
                        <div className="iconInput2 ">
                            <input className="borderR10px" type="text" value={angkut} onChange={setangkut} placeholder="Alat Angkut" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                    </div>
                    <div className="doubleInput borderB">
                        <label>Tanggal</label>
                        <div className="double">
                            <div className="labelInput1">
                                <label>Berangkat</label>
                                <input className="borderR10px" type="date" value={date} onChange={setdate} placeholder="Tanggal SPPD" />
                            </div>
                            <div className="labelInput1">
                                <label>Kembali</label>
                                <input className="borderR10px" type="date" value={dateE} onChange={setdateE} placeholder="Tanggal SPPD" />
                            </div>
                        </div>
                    </div>

                    <div className="doubleInput ptb10px borderB">
                        <label>Anggaran</label>
                        <div className="iconInput2 ">
                            <input className="borderR10px" type="text" value={anggaran} onChange={setanggaran} placeholder="Anggaran" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                    </div>
                </div>
                <div className="footer posEnd">
                    <div className="btnGroup">
                        <button className="btn2"  onClick={close}>Close</button>
                        <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?xadded:xupded)}>{(ins?'Entri':'Perbarui')}</button>
                    </div>
                </div>
            </div>
        </div>
    );
}
FormData.propTypes = {
    dt : PropTypes.array.isRequired,
    param : PropTypes.object.isRequired,
    modalC : PropTypes.func.isRequired,
    dataEntri : PropTypes.func.isRequired
}
export default FormData;
