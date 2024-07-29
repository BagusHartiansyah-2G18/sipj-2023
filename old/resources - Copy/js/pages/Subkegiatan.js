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
    return (
        <>
            <HeaderPage1
                page={'SUB KEGIATAN'}
                pageKet={'daftar Urusan, Bidang, Program, Kegiatan, Sub Kegiatan'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <FormUrusan
                dt={_sub[ind]}
            ></FormUrusan>
            <FormSub 
                dt={_sub}
                selectSub ={ selectSub }
            ></FormSub> 
            
        </>
    );
}
export default Subkegiatan;