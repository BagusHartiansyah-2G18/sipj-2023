import React, { useEffect, useState } from "react";
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
 
import { _sjp,__tahapan,updSjp  } from'../../../states/tenagaAhli/action';

import Tabel1 from "../../tabel/tabel1";
import TAFEdata from "./feData";
import sfLib from "../../mfc/sfLib";
import { openFormEntri } from '../../../states/sfHtml/action';

function TAformData({ data, duser, param, formProses}){
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
        <div className={(form.onOff?'formActionLeft':'formActionLeftAct')} id="formActionLeft">
            <div className="form1 bwhite boxShadow1px ">
                <div className="header bprimary clight">
                    <div className="icon">
                        <span className="mdi mdi-office-building-marker fz25 "></span>
                        <h3>FR Tenaga Ahli</h3>
                    </div>
                    <div className="btnGroup">
                        <button className="btn2 blight bsuccess" onClick={()=>openFormEntri('eyJrZE1lbWJlciI6Ik13PT0iLCJrZE5vdGUiOiIxNk1GQzEjMSIsInRpbmdrYXQiOiIyIiwia2RGb3JtIjoiMSJ9')}>Form Entri Staf</button>
                        <button className="btn2 blight blight cprimary" onClick={add}>Entri</button>
                    </div>
                </div>
                <div className="body">
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
                {/* <div className="footer"></div> */}
            </div>
            <div className={`form2 hmax bwhite updGrid2to1 ${(form.onOff && 'dnone')}`} id="itemFormLeft">
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
    )
}
export default TAformData;