import React from "react";
import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { colDataDukug } from '../../../states/jenisP/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import Select from "react-select"; 
import sfLib from "../../mfc/sfLib";
import sfHtml from "../../mfc/sfHtml"; 
import { setAll, modalClose } from '../../../states/sfHtml/action';

function FormJenisPendukung({ dt, ind, changeJenis, actFormJenisDukungan, modalC }) {
    const dispatch = useDispatch(); 
    const [search, setSearch] = useInput(''); 

    const [selectedOptions, setSelectedOptions] = useState({value:ind,label:dt[ind].nmJPJ});

    const [onOff, setOnOff] = useState(1); 
    const [ins, setIns] = useState(1);   
 
    function mclose(){
        dispatch(modalClose());
    }

    const [ kdDP, setkdDP] = useState();
    const [ index, setIndex] = useState();
    const [ nmDP, setnmDP] = useInput(); 
    const coll = [
        ...colDataDukug,
        {
            cell:(v,i) =>
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
    ]
    const dukung =dt[ind].dukung;

    function reset(tutupForm = false){
        setIndex(-1);
        setkdDP(-1);
        setnmDP({target:{value:''}});
        if(tutupForm){
            close();
        }
    }

    const close = () =>{
        setOnOff(1);
    }
    const add = () =>{
        setIns(1);
        setOnOff(0);
    }
    const added = () =>{ 
        actFormJenisDukungan({ 
            nmDP,
            act:"add"
        });
        reset();
    }
    const del = (v) =>{ 
        const i =dukung.findIndex((val)=> val.kdDP === v.kdDP );
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
            setAll({
                modal : true,
            })
        );
    }
    const xdeled = (ind) =>{  
        actFormJenisDukungan({
            kdDP:dukung[ind].kdDP,
            index: ind,
        });
        mclose();
    }
    const upd = (v) =>{   
        const i =dukung.findIndex((val)=> val.kdDP === v.kdDP );
        setIns(0);
        setOnOff(0);
        setIndex(i);
        setkdDP(dukung[i].kdDP);
        setnmDP({target:{value:dukung[i].nmDP}});
    }
    const upded = () =>{
        actFormJenisDukungan({
            kdDP,
            nmDP, 
            index,
            act:"upd"
        });
        reset(true);
    }

    function selectJenis(data) {   
        setSelectedOptions(data); 
        changeJenis({ kdJPJ : dt[data.value].kdJPJ, ind : data.value});
        reset(true);
    } 

    
    return (
        <div className={(onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
            <div className="form1 bwhite boxShadow1px ">
                <div className="header bprimary clight">
                    <div className="icon">
                        <span className="mdi mdi-office-building-marker fz25 "></span>
                        <h3>Data Jenis Pendukung</h3>
                    </div>
                    <button className="btn2 blight cmuted" onClick={add}>Entri</button>
                </div>
                <div className="body">  
                    <div className="justifyEnd mtb10px">
                        <div className="w30p ">
                            <Select
                                options={sfLib.coptionSelect({
                                    dt:dt,
                                    row:{label:'nmJPJ'},
                                    xind:true
                                })}
                                placeholder="Select Jenis "
                                value={selectedOptions}
                                onChange={selectJenis}
                                isSearchable={true}
                            />
                        </div>
                    </div>
                    {
                        (
                            dt[ind].dukung!==undefined &&
                            <Tabel1
                                search={search}
                                oncSearch={setSearch}
                                columns={coll}
                                // onOffSearch={false}
                                data={dt[ind].dukung.filter((item) => {
                                            if (search === "") {
                                                return item;
                                            } else if (
                                                item.nmDP.toLowerCase().includes(search.toLowerCase())
                                            ) {
                                                return item;
                                            }
                                        }
                                    )}
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
                        <h3 className="">Entri Sub Jenis</h3>
                    </div>       
                    <button className="btn2 blight cmuted" onClick={close}>Close</button>        
                </div>
                <div className="w95p m0auto ptb10px">
                    <div className="iconInput2">
                        <input className="borderR10px" type="text" value={nmDP} onChange={setnmDP} placeholder="Nama Sub Jenis" />
                        <span className={`mdi mdi-cloud-search ${(ins?'cprimary':'cwarning')} `}></span>
                    </div>
                </div>
                <div className="footer posEnd">
                    <div className="btnGroup"> 
                        <button className="btn2"  onClick={close}>Close</button>
                        <button className={`btn2 ${(ins?'bprimary':'bwarning')}`}  onClick={(ins?added:upded)}>{(ins?'Entri':'Perbarui')}</button>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default FormJenisPendukung;