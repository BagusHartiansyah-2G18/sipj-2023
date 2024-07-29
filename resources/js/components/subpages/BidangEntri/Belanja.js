import React from "react";
import { useState } from 'react';
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
import sfHtml from "../../mfc/sfHtml";
import sfLib from "../../mfc/sfLib";

import Select from "react-select";

import { colRincian, actRincian, actTriwulan, getDataSubBidang, getDataUraianSub } from '../../../states/dinas/action';

import Tabel1 from "../../tabel/tabel1";
import { setHtml, setLeftBar, modalClose } from '../../../states/sfHtml/action';
import { toast } from "react-toastify";
import { openFormEntri } from '../../../states/sfHtml/action';

import PropTypes from "prop-types";

function FormBelanja({ dt, modalC, ind, updDataBidang, generateAuto }) {
    const [search, setSearch] = useInput('');
    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);

    const [index, setindex] = useState(0);
    const [index_1, setindex_1] = useState(0);
    const [index_2, setindex_2] = useState(0);
    const [selDinas, setselDinas] = useState({ label: dt[ind].nmDinas, value: dt[ind].kdDinas });
    const [selBidang, setselBidang] = useState({ label: dt[ind].bidang[index].nmBidang, value: dt[ind].bidang[index].kdDBidang });
    const [selSub, setselSub] = useState({
        label: (dt[ind].bidang[index].sub != undefined && dt[ind].bidang[index].sub[index_1].nmSub),
        value: (dt[ind].bidang[index].sub != undefined && dt[ind].bidang[index].sub[index_1].kdSub)
    });
    const [selJenis, setselJenis] = useState({ label: dt[ind].jenis[0].nmJPJ, value: dt[ind].jenis[0].kdJPJ });
    const [selApbd, setselApbd] = useState({ label: dt[ind].apbd[0].nmApbd6, value: dt[ind].apbd[0].kdApbd6 });


    const [ kdJudul, setkdJudul] = useState('1');
    const [ nama, setnama] = useInput();
    const [ total, settotal] = useInput();

    const [ triwulan, settriwulan] = useState({});
    const [ tw1, settw1 ] = useInput('0');
    const [ tw2, settw2 ] = useInput('0');
    const [ tw3, settw3 ] = useInput('0');
    const [ tw4, settw4 ] = useInput('0');

    function selectDinas(data) {
        const i =dt.findIndex((val)=> val.kdDinas === data.value);
        setselDinas(data);
        setindex(0);
        setindex_1(0);
        updDataBidang({
            ind : i,
            kdDinas: data.value
        });
    }
    function selectBidang(data) {
        const i =dt[ind].bidang.findIndex((val)=> val.kdDBidang === data.value);
        setselBidang(data);
        setindex(i);
        setindex_1(0);
        dispatch(getDataSubBidang({
            ind,
            index:i,
            kdDinas:dt[ind].kdDinas,
            kdBidang:data.value
        }));
    }
    function selectSub(data) {
        const i =dt[ind].bidang[index].sub.findIndex((val)=> val.kdSub === data.value);
        setselSub(data);
        setindex_1(i);
        dispatch(getDataUraianSub({
            ind,
            index,
            index_1:i,
            kdDinas:dt[ind].kdDinas,
            kdBidang:dt[ind].bidang[index].kdDBidang,
            kdSub:data.value,
            act: 'added'
        }));
    }
    function goTriwulan(v) {
        const rincian =dt[ind].bidang[index].sub[index_1].rincian;
        const i =rincian.findIndex((val)=> val.kdJudul === v.kdJudul );
        setindex_2(i);
        settw1({target:{value:(v.tw1==null?'':v.tw1)}});
        settw2({target:{value:(v.tw2==null?'':v.tw2)}});
        settw3({target:{value:(v.tw3==null?'':v.tw3)}});
        settw4({target:{value:(v.tw4==null?'':v.tw4)}});
        settriwulan({
            ...v,
            kdDinas: selDinas.value,
            kdBidang: selBidang.value,
            kdSub:  selSub.value,
            index_2: i
        });
    }
    function closeTriwulan(){
        settriwulan({});
    }

    function reset(){
        setkdJudul(1);
        setnama({target:{value:''}});
        settotal({target:{value:''}});
    }

    const coll = [...colRincian,
        {
            cell:(v) =>
                <div className="btnGroup">
                    {/* {tambahan} */}
                    <button className="btn2 cprimary" title="triwulan" onClick={()=>goTriwulan(v)}>triwulan</button>
                    <button className="btn2" title="Perbarui" onClick={()=>upd(v)}><span className="mdi mdi-pencil-box cwarning fz25" /></button>
                    <button className="btn2" title="Hapus"  onClick={()=>del(v)}><span className="mdi mdi-delete-forever cdanger fz25" /></button>
                </div>
            ,
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            width: '250px'
        }
    ];

    function mclose(){
        dispatch(modalClose());
    }

    const close = () =>{
        setOnOff(1);
        dispatch(setLeftBar(0));
    }
    const add = () =>{
        dispatch(setLeftBar(1));
        setIns(1);
        setOnOff(0);
        reset();
    }
    const xadded = () =>{
        try {
            dispatch(actRincian({
                kdDinas: selDinas.value,
                kdBidang: selBidang.value,
                kdSub:  selSub.value,
                kdApbd6: selApbd.value,
                nama,
                total,
                kdJenis : selJenis.value,
                ind,
                index,
                index_1,
                act: 'added'
            }))
            reset()
        } catch (error) {
            toast.error("Gagal Menambahkan Data !!!");
        }
    }
    const del = (v) =>{
        const rincian =dt[ind].bidang[index].sub[index_1].rincian;
        const i =rincian.findIndex((val)=> val.kdJudul === v.kdJudul );
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
        )
    }
    const xdeled = (i) =>{
        const rincian =dt[ind].bidang[index].sub[index_1].rincian;
        try {
            dispatch(actRincian({
                kdDinas: selDinas.value,
                kdBidang: selBidang.value,
                kdSub:  selSub.value,
                kdApbd6: selApbd.value,
                ind,
                index,
                index_1,
                index_2: i,
                act: 'deled',
                kdJudul: rincian[i].kdJudul
            }))
            reset()
            setOnOff(1);
            mclose();
        } catch (error) {
            toast.error("Gagal Menghapus Data !!!");
        }
    }
    const upd = (v) =>{
        dispatch(setLeftBar(1));
        const rincian =dt[ind].bidang[index].sub[index_1].rincian;
        const i =rincian.findIndex((val)=> val.kdJudul === v.kdJudul );
        setIns(0);
        setOnOff(0);
        setindex_2(i);
        setnama({target:{value:rincian[i].nama}});
        settotal({target:{value:rincian[i].total}});
        setselApbd({label:rincian[i].nmApbd6,value:rincian[i].kdApbd6});
        setselJenis({label:rincian[i].nmJPJ,value:rincian[i].kdJenis});
        setkdJudul(rincian[i].kdJudul);

    }
    const xupded = () =>{
        try {
            dispatch(actRincian({
                kdDinas: selDinas.value,
                kdBidang: selBidang.value,
                kdSub:  selSub.value,
                kdApbd6: selApbd.value,
                nmApbd6: selApbd.label,
                nama,
                total,
                kdJenis : selJenis.value,
                nmJPJ : selJenis.label,
                ind,
                index,
                index_1,
                index_2,
                act: 'upded',
                kdJudul
            }))
            reset()
            setOnOff(1);
            mclose();
        } catch (error) {
            toast.error("Gagal Memperbarui Data !!!");
        }
    }

    const saveTriwulan = () =>{
        const xtotal = Number(tw1)+Number(tw2)+Number(tw3)+Number(tw4);
        if(xtotal>Number(dt[ind].bidang[index].sub[index_1].rincian[index_2].total)){
            return toast.error('Pembagian melebihi jumlah Pagu')
        }
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>Apa benar ingin memperbarui data triwulan ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xupded:()=>saveTriwulaned()
                    })
                )
            })
        );
        dispatch(
            setHtml({
                modal : true,
            })
        )
    }

    const saveTriwulaned = () =>{
        dispatch(actTriwulan({
            ...triwulan,
            tw1: (tw1 == null ? '0' : tw1),
            tw2: (tw2 == null ? '0' : tw2),
            tw3: (tw3 == null ? '0' : tw3),
            tw4: (tw4 == null ? '0' : tw4),
            act:(triwulan.ada == undefined? 'addedTriwulan':'updedTriwulan'),
            ind,index,
            index_1,index_2
        }));
        mclose();
    }
    // console.log(dt);

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
                                <b>Entri Uraian Belanja</b> 
                            </h2>
                        </div> 
                        <button className="btn2 blight cmuted" onClick={close}>Close</button>
                    </div>
                    <div class="body bdark  pwrap-5 flexC jcSA" style={{width:"unset", minHeight:"300px" }}><br/>
                        <div className="labelInput2 ptb10px ">
                            <label className="mw100px ">Rekening</label>
                            <Select
                                className="cdark"
                                options={sfLib.coptionSelect({
                                    dt: dt[ind].apbd,
                                    row:{label:'nmApbd6',value:'kdApbd6'},
                                    // xind:true
                                })}
                                placeholder="Select Rekening"
                                value={selApbd}
                                onChange={setselApbd}
                                isSearchable={true}
                            />
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nama} onChange={setnama} placeholder="Uraian" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="number" value={total} onChange={settotal} placeholder="Total" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="labelInput2">
                            <label className="mw100px">Jenis</label>
                            <Select
                                className="cdark"
                                options={sfLib.coptionSelect({
                                    dt : dt[0].jenis,
                                    row:{label:'nmJPJ',value:'kdJPJ'},
                                    // xind:true
                                })}
                                placeholder="Select Jenis"
                                value={selJenis}
                                onChange={setselJenis}
                                isSearchable={true}
                            />
                        </div>
                        <div className="list jcE">
                            <div className="btnGroup">
                                <button className="btn2"  onClick={close}>Close</button>
                                <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?xadded:xupded)}>{(ins?'Entri':'Perbarui')}</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div className="left ">
                <div class="FM1 ">
                    <div class="header">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Rincian Belanja - Triwulan </b> 
                            </h2>
                        </div> 
                        <div className="btnGroup">
                            <button className="btn2 blight blight" onClick={()=>openFormEntri('eyJrZE1lbWJlciI6Ik13PT0iLCJrZE5vdGUiOiIxNk1GQzEjMiIsInRpbmdrYXQiOiIyIiwia2RGb3JtIjoiMyJ9')}>Form Catatan Rekening</button>
                            <button className="btn2 blight bsuccess" onClick={()=>generateAuto()}>generate AUTO</button>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                        <div className="jcE pwrap-10">
                            <div className="w45p labelInput2">
                                <label className="mw100px">Dinas</label>
                                <Select
                                    className="cdark"
                                    options={sfLib.coptionSelect({
                                        dt,
                                        row:{label:'nmDinas',value:'kdDinas'},
                                        // xind:true
                                    })}
                                    placeholder="Select Dinas"
                                    value={selDinas}
                                    onChange={selectDinas}
                                    isSearchable={true}
                                />
                            </div>
                        </div>
                        <div className="jcE pwrap-10">
                            <div className="w45p labelInput2">
                                <label className="mw100px">Bidang</label>
                                <Select
                                    className="cdark"
                                    options={sfLib.coptionSelect({
                                        dt : dt[ind].bidang,
                                        row:{label:'nmBidang',value:'kdDBidang'},
                                        // xind:true
                                    })}
                                    placeholder="Select Bidang"
                                    value={selBidang}
                                    onChange={selectBidang}
                                    isSearchable={true}
                                />
                            </div>
                        </div>
                        {
                            ( dt[ind].bidang[index].sub != undefined &&
                                <div className="jcE pwrap-10">
                                    <div className="w45p labelInput2">
                                        <label className="mw100px">Sub Kegiatan</label>
                                        <Select
                                            className="cdark"
                                            options={sfLib.coptionSelect({
                                                dt : dt[ind].bidang[index].sub,
                                                row:{label:'nmSub',value:'kdSub'},
                                                // xind:true
                                            })}
                                            placeholder="Select Sub Kegiatan"
                                            value={selSub}
                                            onChange={selectSub}
                                            isSearchable={true}
                                        />
                                    </div>
                                </div>
                            )
                        }
                        <hr className="opa2"></hr>
                        {
                            (   dt[ind].bidang[index].sub != undefined &&
                                dt[ind].bidang[index].sub[index_1].rincian !== undefined &&
                                <Tabel1
                                    search={search}
                                    oncSearch={setSearch}
                                    columns={coll}
                                    data={dt[ind].bidang[index].sub[index_1].rincian}
                                    btnAction={
                                        (
                                            Object.keys(triwulan).length===0?
                                            <></>:
                                            <>
                                                <div className="grid-col3">
                                                    <div className="doubleInput ptb10px">
                                                        <label>triwulan 1</label>
                                                        <div className="iconInput2">
                                                            <input className="borderR10px" type="text" value={tw1} onChange={settw1} placeholder="triwulan 1" />
                                                            <span className={`mdi mdi-cloud-search cwarning `}></span>
                                                        </div>
                                                    </div>
                                                    <div className="doubleInput ptb10px">
                                                        <label>triwulan 2</label>
                                                        <div className="iconInput2 ">
                                                            <input className="borderR10px" type="text" value={tw2} onChange={settw2} placeholder="triwulan 2" />
                                                            <span className={`mdi mdi-cloud-search cwarning `}></span>
                                                        </div>
                                                    </div>
                                                    <div className="doubleInput ptb10px">
                                                        <label>triwulan 3</label>
                                                        <div className="iconInput2 ">
                                                            <input className="borderR10px" type="text" value={tw3} onChange={settw3} placeholder="triwulan 3" />
                                                            <span className={`mdi mdi-cloud-search cwarning `}></span>
                                                        </div>
                                                    </div>
                                                    <div className="doubleInput ptb10px">
                                                        <label>triwulan 4</label>
                                                        <div className="iconInput2">
                                                            <input className="borderR10px" type="text" value={tw4} onChange={settw4} placeholder="triwulan 4" />
                                                            <span className={`mdi mdi-cloud-search cwarning `}></span>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div className="list jcE">
                                                    <div className="btnGroup justifyEnd">
                                                        <button className="btn2"  onClick={closeTriwulan}>Close</button>
                                                        <button className={`btn2 bwarning`}  onClick={saveTriwulan}>Perbarui</button>
                                                    </div>
                                                </div> 
                                                <hr className="opa2"></hr> 
                                            </>
                                        )
                                    }
                                ></Tabel1>
                            )
                        }

                    </div>
                </div>
            </div>
        </div>
    );   
}

FormBelanja.propTypes = {
    dt : PropTypes.array.isRequired,
    modalC : PropTypes.func.isRequired,
    ind : PropTypes.number.isRequired,
    updDataBidang : PropTypes.func.isRequired
}
export default FormBelanja;

