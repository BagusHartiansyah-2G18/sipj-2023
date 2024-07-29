import React from "react";
import { useState } from 'react';
import { useDispatch } from 'react-redux';

import { colBidang, addedBidang, updedBidang, deledBidang } from '../../../states/dinas/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import Select from "react-select";

import sfLib from "../../mfc/sfLib";
import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import PropTypes from "prop-types";

function FormBidang({dt,changeDinas,ind, modalC}) {
    const [search, setSearch] = useInput('');
    const [selectedOptions, setSelectedOptions] = useState({value:ind,label:dt[ind].nmDinas});

    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);
    const [index, setIndex] = useState(1);

    const coll = [...colBidang,{
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
    const [ kdDinas, setkdDinas] = useState(dt[ind].kdDinas);
    const [ kdDBidang, setkdDBidang] = useState('-1');
    const [ nmBidang, setnmBidang] = useInput();
    const [ asBidang, setasBidang] = useInput();

    const bidang =dt[ind].bidang;

    function reset(){
        setkdDBidang('-1');
        setnmBidang({target:{value:''}});
        setasBidang({target:{value:''}});
    }

    const close = () =>{
        setOnOff(1);
    }
    const add = () =>{
        // dispatch(setLeftBar(1));
        setIns(1);
        setOnOff(0);
        reset();
    }
    const xadded = () =>{
        dispatch(addedBidang({ kdDinas, nmBidang, asBidang, ind }))
        reset();
    }
    const del = (v) =>{
        const i =bidang.findIndex((val)=> val.kdDBidang === v.kdDBidang );
        setIndex(i);
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
            setHtml({
                modal : true,
            })
        )
    }
    const xdeled = () =>{
        setkdDBidang({target:{value:bidang[index].kdDBidang}});
        dispatch(deledBidang({ kdDinas, kdDBidang: bidang[index].kdDBidang, ind, index }));
        mclose();
    }
    const upd = (v) =>{
        const i =bidang.findIndex((val)=> val.kdDBidang === v.kdDBidang );
        setIns(0);
        setOnOff(0);
        setIndex(i);
        setkdDBidang({target:{value:bidang[i].kdDBidang}});
        setnmBidang({target:{value:bidang[i].nmBidang}});
        setasBidang({target:{value:bidang[i].asBidang}});
        // dispatch(setLeftBar(1));
    }
    const xupded = () =>{
        dispatch(updedBidang({ kdDinas, kdDBidang, nmBidang, asBidang, ind, index }));
        reset();
        setOnOff(1);
    }

    function selectDinas(data) {
        const i =dt.findIndex((val)=> val.kdDinas === data.value );
        setkdDinas(dt[i].kdDinas);
        changeDinas({ kdDinas : dt[i].kdDinas, indx : i});
        setSelectedOptions(data);
    }
    return (
        <div className="Mcontainer2Form ">
            <div className="right-1" >
                <div class="FM1">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bdark">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Form Entri Bidang</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pwrap_5 flexC jcSA" style={{width:"unset", minHeight:"200px"  }}><br/>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nmBidang} onChange={setnmBidang} placeholder="Nama Bidang" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={asBidang} onChange={setasBidang} placeholder="Bidang Alias" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        
                        <div className="list jcE">
                            <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?xadded:xupded)}>{(ins?'Entri':'Perbarui')}</button>
                        </div> 
                    </div>
                </div>
            </div>
            <div className="left">
                <div class="FM1">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bdark">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Data Bidang</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1" style={{width:"unset", borderRadius:"0px"  }}><br/>
                        <div className="jcE pwrap-10 cdark">
                            <div className="w40p ">
                                <Select
                                    options={sfLib.coptionSelect({
                                        dt,
                                        row:{label:'nmDinas',value:'kdDinas'},
                                        // xind:true
                                    })}
                                    placeholder="Select Dinas"
                                    value={selectedOptions}
                                    onChange={selectDinas}
                                    isSearchable={true}
                                />
                            </div>
                        </div>
                            
                        <div className=" ">
                            {
                                (
                                    dt[ind].bidang!==undefined &&
                                    <Tabel1
                                        search={search}
                                        oncSearch={setSearch}
                                        columns={coll}
                                        data={dt[ind].bidang.filter((item) => {
                                                if (search === "") {
                                                    return item;
                                                } else if (
                                                    item.nmBidang.toLowerCase().includes(search.toLowerCase())
                                                ) {
                                                    return item;
                                                }
                                            })}
                                    ></Tabel1>
                                )
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );  
}
FormBidang.propTypes = {
    dt : PropTypes.array.isRequired,
    ind : PropTypes.number.isRequired,
    changeDinas : PropTypes.func.isRequired,
    modalC : PropTypes.func.isRequired,
}
export default FormBidang;
