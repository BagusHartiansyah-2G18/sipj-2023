import React, { useEffect }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { getDT } from '../states/subKegiatan/action';
import { useState } from 'react';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormSub from "../components/subpages/subKegiatan/formSub";
import FormUrusan from "../components/subpages/subKegiatan/formUrusan";

function Subkegiatan() {
    const { _sub } = useSelector((state) => state);
    const [ind, setInd] = useState(0); 
    const dispatch = useDispatch();

    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getDT());
    }, [dispatch]);  
    if(_sub.length===0){
        return (<></>)        ;
    }
    const selectSub=(v)=>{
        const i =_sub.findIndex((val)=> val.kdSub === v.kdSub );  
        setInd(i);
    }   
    const menus=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Program - Sub Kegiatan</b></button>
             </div> 
        ); 
    }
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Informasi Kegiatan'}
                    pageKet={'meliputi data Urusan, Bidang, Program, Kegiatan, Sub Kegiatan'}
                    icon={'mdi-office-building-marker cdark'}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800">
                    <div className="Mcontainer2Form">
                        <div className="right-1" >
                            <FormUrusan
                                dt={_sub[ind]}
                            ></FormUrusan>
                        </div>
                        <div className="left ">
                            <FormSub 
                                dt={_sub}
                                selectSub ={ selectSub }
                            ></FormSub> 
                        </div>
                    </div>
                </div>  
            </div>
        </div> 
    ); 
}
export default Subkegiatan;