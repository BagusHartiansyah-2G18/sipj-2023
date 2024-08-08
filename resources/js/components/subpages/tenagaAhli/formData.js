import React, { useEffect, useState } from "react";
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
 
import { _sjp,__tahapan,updSjp  } from'../../../states/tenagaAhli/action';

import Tabel1 from "../../tabel/tabel1";
import TAFEdata from "./feData";
import sfLib from "../../mfc/sfLib";
import { openFormEntri } from '../../../states/sfHtml/action';
import FormInformasi from "../sppd/formInformasi";

function TAformData({ data, duser, param, formProses, basic}){
    const dispatch = useDispatch();
    const [search, _search] = useInput('');
    const [form, _form] = useState({
        onOff:1,ins:1,ind:-1
    });
    const coll = [{
            name: 'No',
            selector: (row,i) => (i+1),
            width : '50px'
        },{
            name: 'A.N',
            selector: row => row.an,
        },{
            name: 'Keterangan',
            selector: row => row.keterangan,
        },{
            name: 'status',
            selector: row => __tahapan(row.status),
        },{
            cell:(row,i) =>{
                return (
                    <div className="btnGroup"> 
                        <button className="btn2 bwarning" title="Perbarui" onClick={()=>upd({row,i})}><span className="mdi mdi-pencil-box cdark fz25" /></button> 
                        <button className="btn2 bprimary clight" title="Open Form" onClick={()=>formProses({row,i})}>Form Proses SPJ</button>
                    </div>
                );
            },
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            width: '250px'
        }
    ];

    const add = () =>{
        _form({
            ...form,
            ins:1,
            onOff:0
        }) 
    }
    const xadded = ({ user,keterangan,totVol,totSatuan,volume }) =>{  
        dispatch(_sjp({
            ...param,
            data:btoa(JSON.stringify(user)),
            an:user[0][0].label,
            volume:JSON.stringify(volume),
            satuan:totSatuan,
            totSatuan,
            totVol,
            keterangan
        }));
        formClose();
    }
    const upd = ({row,i}) =>{
        _form({
            ...form,
            ins:0,
            onOff:0,
            start:true,
            row,i
        }); 
    }
    const xupded = ({ user,keterangan,totVol,totSatuan,volume }) =>{  
        dispatch(updSjp({
            ...param,
            ...data[form.i],
            data:btoa(JSON.stringify(user)),
            an:user[0][0].label,
            volume:JSON.stringify(volume),
            satuan:totSatuan,
            totSatuan,
            totVol,
            keterangan,
            ind:form.i,
            no:form.row.no
        })); 
        formClose();
    } 
    function formClose(){
        _form({
            ...form,
            ins:1,
            onOff:1
        })
    }
    if(Object.keys(form).length==0){
        return <></>;
    }   
    
    return(
        <div className="Mcontainer2Form">
            <div className="right-1" >
                <div class="FM1 ">
                    <div class="header ">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>{(form.ins?'Entri':'Perbarui')} Data</b> 
                            </h2>
                        </div> 
                        <button className="btn2 blight cmuted" onClick={add}>Entri</button>
                    </div>
                    <div class="body pwrap_5 bdark flexC  " style={{width:"unset"}}><br/>
                        <TAFEdata 
                            form={form}
                            close={formClose}
                            xadded={xadded}
                            xupded={xupded}
                            duser={duser}
                            userOps={sfLib.coptionSelect({
                                dt:duser ,
                                xind:true,
                                row:{label:0},
                            }).map(v=>{ return {...v, label:v.label.label}})}
                        ></TAFEdata> 
                    </div>
                </div> 
            </div>
            <div className="left ">
                <FormInformasi
                    dt={basic}
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
                            oncSearch={_search}
                            columns={coll}
                            data={data.filter((item) => {
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
    )
}
export default TAformData;