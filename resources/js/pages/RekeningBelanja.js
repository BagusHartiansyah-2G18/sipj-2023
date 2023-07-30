import React, { useEffect }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { getDT } from '../states/rekeningB/action';
import { useState } from 'react';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormApbd from "../components/subpages/rekeningBelanja/formApbd";
import FormApbd6 from "../components/subpages/rekeningBelanja/formApbd6";
;

function RekeningBelanja() {
    const { _rek } = useSelector((state) => state);
    const [ind, setInd] = useState(0);
    const dispatch = useDispatch();


    useEffect(() => {
        dispatch(getDT());
    }, [dispatch]);
    if(_rek.length===0){
        return (<></>)        ;
    }
    const selectSub=(v)=>{
        const i =_rek.findIndex((val)=> val.kdApbd6 === v.kdApbd6 );
        setInd(i);
    }
    return (
        <>
            <HeaderPage1
                page={'Rekening Belanja'}
                pageKet={'daftar Rekening Belanja OPD'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <div className="flexR justifySB">
                <FormApbd6
                    dt={_rek}
                    selectSub={selectSub}
                ></FormApbd6>
                <FormApbd
                    className=" w40p"
                    dt={_rek[ind]}
                ></FormApbd>

            </div>

        </>
    );
}
export default RekeningBelanja;
