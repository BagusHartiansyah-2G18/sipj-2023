import React from "react";
import { useState } from 'react';
import { useDispatch } from 'react-redux';

import { colAnggota, cbStatus, addedAnggota, updedAnggota, deledAnggota } from '../../../states/dinas/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import Select from "react-select";
import sfHtml from "../../mfc/sfHtml";
import { setAll, modalClose } from '../../../states/sfHtml/action';
import sfLib from "../../mfc/sfLib";
import PropTypes from "prop-types";

function FormMember({ dt, kdDinas, ind ,index, changeBidang, modalC }) {
    const [search, setSearch] = useInput('');
    const [selectedOptions, setSelectedOptions] = useState({value:index,label:dt[index].nmBidang});

    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);

    const coll = [...colAnggota,{
        cell:(v) =>
            <div className="btnGroup">
                {/* {tambahan} */}
                <button className="btn2" title="Perbarui" onClick={()=>upd(v)}><span className="mdi mdi-pencil-box cwarning fz25" /></button>
                <button className="btn2" title="Hapus"  onClick={()=>del(v)}><span className="mdi mdi-delete-forever cdanger fz25" /></button>
            </div>
        ,
        ignoreRowClick: true,
        allowOverflow: true,
        button: true,
        width: '150px'
    }];

    function mclose(){
        dispatch(modalClose());
    }

    const kdDBidang= dt[index].kdDBidang;
    const [ index1, setindex1] = useState(-1);
    const [ kdBAnggota, setBAnggota] = useState('1');
    const [ selStatus, setselStatus] = useState({value:cbStatus[0].value,label:cbStatus[0].label});
    const [ nmAnggota, setnmAnggota] = useInput();
    const [ nmJabatan, setnmJabatan] = useInput();
    const [ nip, setnip] = useInput();

    const anggota =dt[index].anggota;

    function reset(){
        setBAnggota('ba-1');
        setnmAnggota({target:{value:''}});
        setnmJabatan({target:{value:''}});
        setnip({target:{value:''}});
        setselStatus({value:cbStatus[0].value,label:cbStatus[0].label});
    }

    const close = () =>{
        setOnOff(1);
        // dispatch(setLeftBar(0));
    }
    const add = () =>{
        // dispatch(setLeftBar(1));
        setIns(1);
        setOnOff(0);
        reset();
    }
    const xadded = () =>{
        dispatch(addedAnggota({
            kdDinas,
            kdDBidang,
            nmAnggota,
            nmJabatan,
            nip,
            selStatus: selStatus.value,
            ind, index
        }))
        reset();
    }
    const del = (v) =>{
        const i =anggota.findIndex((val)=> val.kdBAnggota === v.kdBAnggota );
        setindex1(i);
        setBAnggota(anggota[i].kdBAnggota);
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
                        xdeled
                    })
                )
            })
        );
        dispatch(
            setAll({
                modal : true,
            })
        )
    }
    const xdeled = () =>{
        dispatch(
            deledAnggota({
                kdDinas, kdDBidang, kdBAnggota,
                ind, index, index1
        }));
        mclose();
    }
    const upd = (v) =>{
        const i =anggota.findIndex((val)=> val.kdBAnggota === v.kdBAnggota );
        setIns(0);
        setOnOff(0);
        setindex1(i);
        setBAnggota(anggota[i].kdBAnggota);
        setnmAnggota({target:{value:anggota[i].nmAnggota}});
        setnmJabatan({target:{value:anggota[i].nmJabatan}});
        setnip({target:{value:anggota[i].nip}});
        const i1 =cbStatus.findIndex((val)=> val.value == anggota[i].status );
        setselStatus({value:cbStatus[i1].value,label:cbStatus[i1].label})
        // dispatch(setLeftBar(1));
    }
    const xupded = () =>{
        dispatch(updedAnggota({
            kdDinas,
            kdDBidang,
            kdBAnggota,
            nmAnggota,
            nmJabatan,
            nip,
            selStatus: selStatus.value,
            ind, index, index1
        }));
        reset();
        setOnOff(1);
        mclose();
    }
    function selectBidang(data) {
        changeBidang({
            kdDinas,
            kdDBidang: dt[data.value].kdDBidang,
            ind,
            index: data.value
        })
        // changeBidang({ kdDinas : dt[data.value].kdDinas, ind : data.value})
        setSelectedOptions(data);
    }
    return (
        <>
            <div className={(onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
                <div className="form1 bwhite boxShadow1px">
                    <div className="header bprimary clight">
                        <div className="icon">
                            <span className="mdi mdi-office-building-marker fz25 "></span>
                            <h3>Data Anggota Bidang</h3>
                        </div>
                        <button className="btn2 blight cmuted" onClick={add}>Entri</button>
                    </div>
                    <div className="body">
                        <div className="justifyEnd mtb10px">
                            <div className="w30p ">
                                <Select
                                    options={sfLib.coptionSelect({
                                        dt:dt,
                                        row:{label:'nmBidang'},
                                        xind:true
                                    })}
                                    placeholder="Select Bidang"
                                    value={selectedOptions}
                                    onChange={selectBidang}
                                    isSearchable={true}
                                />
                            </div>
                        </div>
                        {
                            (
                            (Object.keys(dt[index]).length!==0 && dt[index].anggota!==undefined) &&
                                <Tabel1
                                    search={search}
                                    oncSearch={setSearch}
                                    columns={coll}
                                    data={dt[index].anggota.filter((item) => {
                                            if (search === "") {
                                                return item;
                                            } else if (
                                                item.nmAnggota.toLowerCase().includes(search.toLowerCase())
                                            ) {
                                                return item;
                                            }
                                        })}
                                ></Tabel1>
                            )
                        }

                    </div>
                    {/* <div className="footer"></div> */}
                </div>
                <div className={`form2 hmax bwhite updGrid2to1 ${(onOff && 'dnone')}`} id="itemFormLeft">
                    <div className="header bprimary clight">
                        <div className="icon">
                            <span className="mdi mdi-clock-edit-outline fz25"></span>
                            <h3 className="">{(ins?'Entri':'Perbarui')} Dinas</h3>
                        </div>
                        <button className="btn2 blight cmuted" onClick={close}>Close</button>
                    </div>
                    <div className="w95p m0auto">
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nmAnggota} onChange={setnmAnggota} placeholder="Nama Anggota" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nmJabatan} onChange={setnmJabatan} placeholder="Jabatan" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nip} onChange={setnip} placeholder="NIP" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="doubleInput borderB">
                            <label>Status</label>
                            <Select
                                options={cbStatus}
                                placeholder="Select Status"
                                value={selStatus}
                                onChange={setselStatus}
                                isSearchable={true}
                            />
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
        </>
    );
}
FormMember.propTypes = {
    dt : PropTypes.array.isRequired,
    kdDinas : PropTypes.string.isRequired,
    ind : PropTypes.number.isRequired,
    index : PropTypes.number.isRequired,
    modalC : PropTypes.func.isRequired,
    changeBidang : PropTypes.func.isRequired
}
export default FormMember;
