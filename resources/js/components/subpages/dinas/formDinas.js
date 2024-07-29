import React from "react";
import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { colDinas, added, deled, upded } from '../../../states/dinas/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import { setLeftBar } from '../../../states/sfHtml/action';
import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';
import PropTypes  from "prop-types";

function FormDinas({dt, modalC}) {
    const { _html } = useSelector((state) => state);

    const [search, setSearch] = useInput('');
    const dispatch = useDispatch();
    const [onOff, setOnOff] = useState(1);
    const [ins, setIns] = useState(1);
    const [ind, setInd] = useState(1);
    const coll = [...colDinas,{
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

    const [ kdDinas, setkdDinas] = useInput();
    const [ nmDinas, setnmDinas] = useInput();
    const [ asDinas, setasDinas] = useInput();
    const [ kadis, setkadis] = useInput();
    const [ nip, setnip] = useInput();

    function reset(){
        setkdDinas({target:{value:''}});
        setnmDinas({target:{value:''}});
        setasDinas({target:{value:''}});
        setkadis({target:{value:''}});
        setnip({target:{value:''}});
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
        dispatch(added({ kdDinas, nmDinas, asDinas, kadis, nip }))
        reset();
    }
    const del = (v) =>{
        const i =dt.findIndex((val)=> val.nip === v.nip );
        setInd(i);
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
                        xdeled: ()=>xdeled(i)
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
        setkdDinas({target:{value:dt[i].kdDinas}});
        dispatch(deled({ kdDinas: dt[i].kdDinas, ind}));
        mclose();
    }
    const upd = (v) =>{
        const i =dt.findIndex((val)=> val.nip === v.nip );
        setIns(0);
        setOnOff(0);
        setInd(i);
        setkdDinas({target:{value:dt[i].kdDinas}});
        setnmDinas({target:{value:dt[i].nmDinas}});
        setasDinas({target:{value:dt[i].asDinas}});
        setkadis({target:{value:dt[i].kadis}});
        setnip({target:{value:dt[i].nip}});
        dispatch(setLeftBar(1));
    }
    const xupded = () =>{
        dispatch(upded({ kdDinas, nmDinas, asDinas, kadis, nip, ind }));
        close(1);
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
                                <b>Form Entri</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pwrap_5 flexC jcSA" style={{width:"unset", minHeight:"350px" }}><br/>
                        {
                            (
                                ins ?
                                <div className="iconInput2 ptb10px">
                                    <input className="borderR10px" type="text" value={kdDinas} onChange={setkdDinas} placeholder="Kode Dinas" />
                                    <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                                </div>:''
                            )
                        }
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nmDinas} onChange={setnmDinas} placeholder="Nama Dinas" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={asDinas} onChange={setasDinas} placeholder="Dinas Alias" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={kadis} onChange={setkadis} placeholder="Pimpinan" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={nip} onChange={setnip} placeholder="NIP" />
                            <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                        </div>
                        
                        <div className="list jcE">
                            <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?xadded:xupded)}>{(ins?'Entri':'Perbarui')}</button>
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
                                <b>Data Dinas </b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                        <div className="">
                            <Tabel1
                                search={search}
                                oncSearch={setSearch}
                                columns={coll}
                                data={dt.filter((item) => {
                                        if (search === "") {
                                            return item;
                                        } else if (
                                            item.nmDinas.toLowerCase().includes(search.toLowerCase())
                                        ) {
                                            return item;
                                        }
                                    })}
                            ></Tabel1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ); 
}
FormDinas.propTypes = {
    dt : PropTypes.array.isRequired,
    modalC : PropTypes.func.isRequired,
}
export default FormDinas;
