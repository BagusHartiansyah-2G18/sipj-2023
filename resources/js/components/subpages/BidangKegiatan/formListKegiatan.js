import React from "react";
import { useState } from 'react';
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
import sfHtml from "../../mfc/sfHtml";
import sfLib from "../../mfc/sfLib";

import Select from "react-select";


import { colSub, selectSubBidangDinas } from '../../../states/dinas/action';

import Tabel1 from "../../tabel/tabel1";
import { setLeftBar } from '../../../states/sfHtml/action';

import { setHtml, modalClose } from '../../../states/sfHtml/action';

import PropTypes from "prop-types";

function FormListSubKegiatan({ dt, modalC, ind, updDataBidang }) {

    const [search, setSearch] = useInput('');
    const [search1, setSearch1] = useInput('');
    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);

    // console.log(dt);
    const [index, setindex] = useState(0);

    const [selDinas, setselDinas] = useState({ label: dt[ind].nmDinas, value: dt[ind].kdDinas });
    const [selBidang, setselBidang] = useState({
        label: (dt[ind].bidang!=undefined && dt[ind].bidang.length>0 && dt[ind].bidang[index].nmBidang),
        value: (dt[ind].bidang!=undefined && dt[ind].bidang.length>0 && dt[ind].bidang[index].kdBidang)
    });

    if(dt[ind].bidang!=undefined && dt[ind].bidang.length>0 && !selBidang.label){
        setselBidang({
            label: dt[ind].bidang[index].nmBidang,
            value: dt[ind].bidang[index].kdBidang
        });
    }

    const [countDt, setcountDt] = useState(0);
    const [dataTam, setdataTam] = useState(0);

    const [countDtX, setcountDtX] = useState(0);
    const [dataTamX, setdataTamX] = useState(0);

    function selectDinas(data) {
        const i =dt.findIndex((val)=> val.kdDinas === data.value);
        setselDinas(data);
        updDataBidang({
            ind : i,
            kdDinas: data.value
        });
    }
    function selectBidang(data) {
        const i =dt[ind].bidang.findIndex((val)=> val.kdDBidang === data.value);
        setselBidang(data);
        setindex(i);
    }
    function selectDataForm({ selectedCount, selectedRows }) {
        setcountDt(selectedCount);
        setdataTam(selectedRows);
    }
    function selectDataTerpilih({ selectedCount, selectedRows }) {
        setcountDtX(selectedCount);
        setdataTamX(selectedRows);
    }

    const coll = [...colSub,
        // {
        //     cell:(v) =>
        //         <div className="btnGroup">
        //             {/* {tambahan} */}
        //             <button className="btn2" title="Perbarui" onClick={()=>upd(v)}><span className="mdi mdi-pencil-box cwarning fz25" /></button>
        //             <button className="btn2" title="Hapus"  onClick={()=>del(v)}><span className="mdi mdi-delete-forever cdanger fz25" /></button>
        //         </div>
        //     ,
        //     ignoreRowClick: true,
        //     allowOverflow: true,
        //     button: true,
        //     width: '150px'
        // }
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
        setOnOff(0);
    }

    const msgAdd = () =>{
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                clsH : ' bprimary ',
                mclose,
                children : (
                    <p>Apa benar ingin menambahkan data ini ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xadded:()=>xadded()
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
    const xadded = () =>{
        let xdata = [];
        dataTam.forEach((v)=>{
            try {
                const xi =dt[ind].sub.findIndex((val)=> val.kdSub === v.kdSub);
                xdata.push({
                    ind,
                    index : xi,
                    kdBidang : dt[ind].bidang[index].kdDBidang,
                    kdDinas : dt[ind].kdDinas,
                    kdSub : dt[ind].sub[xi].kdSub,
                })
            } catch (error) {
                error;
            }
        });
        dispatch(
            selectSubBidangDinas(xdata)
        )

        selectDataForm({ selectedCount: 0, selectedRows: [] });
        close();
        mclose();
    }

    const msgDel = () =>{
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>Apa benar ingin menghapus data ini ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xdeled:()=>xdeled()
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
    const xdeled = () =>{
        let xdata = [];
        dataTamX.forEach((v)=>{
            try {
                const xi =dt[ind].sub.findIndex((val)=> val.kdSub === v.kdSub);
                xdata.push({
                    ind,
                    index : xi,
                    kdBidang : dt[ind].bidang[index].kdDBidang,
                    kdDinas : dt[ind].kdDinas,
                    kdSub : dt[ind].sub[xi].kdSub,
                })
            } catch (error) {
                error;
            }
        });
        dispatch(
            selectSubBidangDinas(xdata,true)
        )

        selectDataTerpilih({ selectedCount: 0, selectedRows: [] });
        close();
        mclose();
    }
    return (
        <>
            <div className={(onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
                <div className="form1 bwhite boxShadow1px">
                    <div className="header bprimary clight">
                        <div className="icon">
                            <span className="mdi mdi-office-building-marker fz25 "></span>
                            <h3>Data Sub Kegiatan</h3>
                        </div>
                        <button className="btn2 blight cmuted" onClick={add}>Form</button>
                    </div>
                    <div className="body">
                        <div className="justifyEnd mtb10px">
                            <div className="w30p ">
                                <Select
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
                        {
                            (
                                dt[ind].bidang!=undefined && dt[ind].bidang.length>0 &&
                                <div className="justifyEnd mtb10px">
                                    <div className="w30p ">
                                        <Select
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
                            )
                        }
                        {

                            (
                                dt[ind].sub !== undefined && dt[ind].bidang[index]!=undefined &&
                                <Tabel1
                                    search={search}
                                    oncSearch={setSearch}
                                    columns={coll}
                                    checkboxSelection={selectDataTerpilih}
                                    data={getDataViewSubBidang({
                                        dt : dt[ind].sub,
                                        terpilih : 1,
                                        kdDBidang : dt[ind].bidang[index].kdDBidang,
                                        search
                                    })}
                                    btnAction={
                                        (countDtX !== 0 &&
                                            <>
                                                <hr></hr>
                                                <div className="flexR justifySB algI">
                                                    <h2>{countDtX+ ` Sub Kegiatan`} </h2>
                                                    <div className="btnGroup">
                                                        <button className="btn2 bdanger clight" onClick={msgDel}>Hapus Data</button>
                                                    </div>
                                                </div>
                                                <hr></hr>
                                            </>
                                        )
                                    }
                                ></Tabel1>
                            )
                        }

                    </div>
                </div>
                <div className={`form2 hmax bwhite updGrid2to1 ${(onOff && 'dnone')}`} id="itemFormLeft">
                    <div className="header bprimary clight">
                        <div className="icon">
                            <span className="mdi mdi-clock-edit-outline fz25"></span>
                            <h3 className="">Form Pemilihan Sub Kegiatan Bidang</h3>
                        </div>
                        <button className="btn2 blight cmuted" onClick={close}>Close</button>
                    </div>
                    <div className="w95p m0auto">
                        <div className="mtb10px">
                            {
                                (
                                    dt[ind].sub !== undefined && dt[ind].bidang[index]!=undefined &&
                                    <Tabel1
                                        cinput=""
                                        search={search1}
                                        oncSearch={setSearch1}
                                        columns={coll}
                                        selectRow={true}
                                        checkboxSelection={selectDataForm}
                                        data={getDataViewSubBidang({
                                            dt : dt[ind].sub,
                                            terpilih : 0,
                                            kdDBidang : dt[ind].bidang[index].kdDBidang,
                                            search:search1
                                        })}
                                        btnAction={
                                            (countDt !== 0 &&
                                                <>
                                                    <div className="flexR justifySB algI">
                                                        <h2>{countDt+ ` Sub Kegiatan`} </h2>
                                                        <div className="btnGroup">
                                                            <button className="btn2 bprimary clight" onClick={msgAdd}>Tambahkan Data</button>
                                                        </div>
                                                    </div>
                                                    <hr></hr>
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
        </>

    );
}

FormListSubKegiatan.propTypes = {
    dt : PropTypes.object.isRequired,
    modalC : PropTypes.func.isRequired,
    ind : PropTypes.number.isRequired,
    updDataBidang : PropTypes.func.isRequired
}
export default FormListSubKegiatan;


function getDataViewSubBidang({ dt, terpilih, kdDBidang, search }){
     let data = [];
    if(terpilih){
        data = dt.filter((v)=>{
            if(v.kdBidang === kdDBidang){
                return v;
            }
        });
    }else{
        data = dt.filter((v)=>{
            if(v.kdBidang.length === 0){
                return v;
            }
        });
    }
    return data.filter((item) => {
        if (search === "") {
            return item;
        } else if (
            item.nmSub.toLowerCase().includes(search.toLowerCase())
        ) {
            return item;
        }
    })
}
