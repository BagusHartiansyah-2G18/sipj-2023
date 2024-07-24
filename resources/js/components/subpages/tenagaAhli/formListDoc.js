import React, { useEffect, useState } from "react";
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
 
import { _sjp,__tahapan  } from'../../../states/tenagaAhli/action';
import {newTab } from '../../../states/sfHtml/action';

import Tabel1 from "../../tabel/tabel1"; 
function TAformListDoc({ ddoc,dselect, checkListForm }){
    const dispatch = useDispatch();
    const [search, _search] = useInput('');
    const [form, _form] = useState({
        onOff:1,ins:1,ind:-1
    }); 
    const __param=()=>{ 
        const {
            kdDinas,
            kdBidang,
            kdSub,
            kdJudul,
            no,
            taSPJ,
        }=dselect.row;
        return {
            kdDinas,
            kdBidang,
            kdSub,
            kdJudul,
            no,
            taSPJ,
        };
    }
    __param()
    const __dokumen=({ row,i })=>{   
        switch (row[0].dt[2]) {
            case 'jd-1':return newTab('dspj/kwitansi/'+btoa(JSON.stringify(__param())));
            case 'jd-2':return newTab('dspj/tandaTerima/'+btoa(JSON.stringify(__param())));
            case 'jd-3':return newTab('dspj/daftarNominatif/'+btoa(JSON.stringify(__param())));
            case 'jd-5':return newTab('dspj/pindahBukuanPajak/'+btoa(JSON.stringify(__param())));
            case 'jd-6':return newTab('dspj/pindahBukuanRekening/'+btoa(JSON.stringify(__param()))); 
            case 'jd-7': return checkListForm(); 
            default:return newTab('kwitansi/');
        }
        
    }
    const coll = [{
            name: 'No',
            selector: (row,i) => (i+1),
            width : '50px'
        },{
            name: 'Nama Dokumen',
            selector: row =><label><b>{row[0].label}</b><br/>{row[0].dt[1]}</label>,
        },{
            cell:(row,i) =>{
                if(parseInt(row[1].value)){
                    return (
                        <div className="btnGroup"> 
                             <button className="btn2 bsuccess clight" title="Open Form" onClick={()=>__dokumen({row,i})}>view Dokumen</button>
                        </div>
                    );
                }
                return "Belum tersedia";
                
            },
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            width: '250px'
        }
    ];

     
    if(Object.keys(form).length==0){
        return <></>;
    }  
    return(
        <div className="form1 bwhite boxShadow1px ">
            <div className="header bprimary clight">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3>Dokumen Keperluan SPJ</h3>
                </div> 
            </div>
            <div className="body">
                <Tabel1
                    search={search}
                    oncSearch={_search}
                    columns={coll}
                    data={ddoc.filter((item) => {
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
    )
}
export default TAformListDoc;