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
import FormInformasi from "./formInformasi";
import { checkForm } from "../../../states/sfHtml/action";
import { toast } from "react-toastify";

function FormData({ dt, di, modalC, param, dataEntri }) {
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
                                {/* <button className="btn2 bdanger" title="Hapus"  onClick={()=>del(v)}><span className="mdi mdi-delete-forever clight fz25" /></button> */}
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
                                to={`/viewArsip/${v.file}`}
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
        const {cf,msg,ind} = checkForm([
            {type:"text",minLength:10,value:maksud, name:"Maksud Perjalanan"},
            {type:"text",minLength:5,value:tempatS, name:"Tempat Berangkat"},
            {type:"text",minLength:5,value:tempatE, name:"Tempat Tujuan"},
            {type:"text",minLength:5,value:lokasi, name:"Tempat Kegiatan "},

            {type:"text",minLength:5,value:date, name:"Alat Angkut"},
            {type:"text",minLength:5,value:dateE, name:"Tanggal Berangkat"},
            {type:"text",minLength:3,value:angkut, name:"Tanggal Kembali"},
            {type:"text",minLength:3,value:anggaran, name:"Anggaran"},
        ]);
        if(!cf)return toast.error(msg);

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
        <div className="Mcontainer2Form">
            <div className="right-1" >
                <div class="FM1 ">
                    <div class="header ">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>{(ins?'Entri':'Perbarui')} Data</b> 
                            </h2>
                        </div> 
                        <button className="btn2 blight cmuted" onClick={add}>Entri</button>
                    </div>
                    <div class="body pwrap_5 bdark flexC jcSA" style={{width:"unset", minHeight:"350px" }}><br/>
                        <div className="doubleInput pwrap__10 bdahedB1">
                            <label>Maksud Perjalanan</label>
                            <div className="iconInput2 ">
                                <textarea rows={3} className="borderR10px pwrap w100p" value={maksud} onChange={setmaksud}></textarea>
                            </div>
                        </div>
                        <div className="doubleInput bdahedB1">
                            <label>Tempat</label>
                            <div className="double">
                                <div className="labelInput1 mw45p">
                                    <label>Berangkat</label>
                                    <div className="iconInput2 pwrap__10">
                                        <input className="borderR10px" type="text" value={tempatS} onChange={settempatS} placeholder="Berangkat" />
                                        <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                                    </div>
                                </div>
                                <div className="labelInput1 mw45p">
                                    <label>Tujuan</label>
                                    <div className="iconInput2 pwrap__10">
                                        <input className="borderR10px w80p" type="text" value={tempatE} onChange={settempatE} placeholder="Tujuan" />
                                        <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="doubleInput pwrap__10 bdahedB1">
                            <label>Tempat Kegiatan</label>
                            <div className="iconInput2 ">
                                <input className="borderR10px" type="text" value={lokasi} onChange={setlokasi} placeholder="Tempat Kegiatan" />
                                <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                            </div>
                        </div>
                        <div className="doubleInput pwrap__10 bdahedB1">
                            <label>Alat Angkut</label>
                            <div className="iconInput2 ">
                                <input className="borderR10px" type="text" value={angkut} onChange={setangkut} placeholder="Alat Angkut" />
                                <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                            </div>
                        </div>
                        <div className="doubleInput bdahedB1">
                            <label>Tanggal</label>
                            <div className="double">
                                <div className="labelInput1 mw45p">
                                    <label>Berangkat</label>
                                    <input className="wunset" type="date" value={date} onChange={setdate} placeholder="Tanggal SPPD" />
                                </div>
                                <div className="labelInput1 mw45p">
                                    <label>Kembali</label>
                                    <input className="  wunset" type="date" value={dateE} onChange={setdateE} placeholder="Tanggal SPPD" />
                                </div>
                            </div>
                        </div>

                        <div className="doubleInput pwrap__10 bdahedB1">
                            <label>Anggaran</label>
                            <div className="iconInput2 ">
                                <input className="borderR10px" type="text" value={anggaran} onChange={setanggaran} placeholder="Anggaran" />
                                <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                            </div>
                        </div>
                        <br/>
                        <div className="list jcE">
                            <div className="btnGroup">
                                <button className="btn2"  onClick={close}>Close</button>
                                <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?xadded:xupded)}>{(ins?'Entri':'Perbarui')}</button>
                            </div>
                        </div> 
                        <br/>
                    </div>
                </div>
            </div>
            <div className="left ">
                <FormInformasi
                    dt={di}
                ></FormInformasi>
                <div class="FM1 ">
                    <div class="header">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>List Perjalanan Dinas </b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
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
