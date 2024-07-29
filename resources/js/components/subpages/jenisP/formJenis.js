import React from "react";
import { useDispatch } from 'react-redux';

import { colJenis } from '../../../states/jenisP/action';
import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';

import Tabel1 from "../../tabel/tabel1";
import sfHtml from "../../mfc/sfHtml";
import { setAll, modalClose } from '../../../states/sfHtml/action';
import PropTypes from "prop-types";

function FormJenis({dt, actFormJenis, modalC }) {
    const dispatch = useDispatch();
    const [search, setSearch] = useInput('');
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);
    const [ index, setIndex] = useState();

    function mclose(){
        dispatch(modalClose());
    }

    const coll = [...colJenis,{
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
        }
    ];
    const [ kdJPJ, setkdJPJ] = useState();
    const [ nmJPJ, setnmJPJ] = useInput();


    function reset(){
        setkdJPJ(-1);
        setkdJPJ('');
        setnmJPJ({target:{value:''}});
    }

    const close = () =>{
        setOnOff(1);
    }
    const add = () =>{
        reset();
        setIns(1);
        setOnOff(0);
    }
    const added = () =>{
        actFormJenis({
            nmJPJ,
            act:"add"
        })
        reset();
    }
    const del = (v) =>{
        const i =dt.findIndex((val)=> val.kdJPJ === v.kdJPJ );
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
            setAll({
                modal : true,
            })
        );
    }
    const xdeled = () =>{
        actFormJenis({
            kdJPJ: dt[index].kdJPJ,
            nmJPJ,
            ind : index
        });
        mclose();
    }
    const upd = (v) =>{
        const i =dt.findIndex((val)=> val.kdJPJ === v.kdJPJ );
        setIndex(i);
        setIns(0);
        setOnOff(0);
        setkdJPJ(dt[i].kdJPJ);
        setnmJPJ({target:{value:dt[i].nmJPJ}});
    }
    const upded = () =>{
        actFormJenis({
            kdJPJ,
            nmJPJ,
            ind : index,
            act:"upd"
        });
        close();
    }
    return (
        <div className="Mcontainer2Form ">
            <div className="right" >
                <div class="FM1">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bdark">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Form Entri Jenis</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pwrap_5" style={{width:"unset" }}><br/>
                        <div className="iconInput2">
                            <input className="borderR10px" type="text" value={nmJPJ} onChange={setnmJPJ} placeholder="Nama Jenis" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div> 
                        
                        <div className="list jcE">
                            <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?added:upded)}>{(ins?'Entri':'Perbarui')}</button>
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
                                <b>Daftar Jenis Pertanggung Jawaban</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1" style={{width:"unset",borderRadius:"0px" }}><br/> 
                        <div className=" ">
                            <Tabel1
                                search={search}
                                oncSearch={setSearch}
                                columns={coll}
                                data={dt.filter((item) => {
                                            if (search === "") {
                                                return item;
                                            } else if (
                                                item.nmJPJ.toLowerCase().includes(search.toLowerCase())
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
        </div> 
    );
}
FormJenis.propTypes = {
    dt : PropTypes.object.isRequired,
    modalC : PropTypes.func.isRequired,
    actFormJenis : PropTypes.func.isRequired
}
export default FormJenis;
