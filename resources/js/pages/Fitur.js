import React, { useEffect } from "react";

import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import HeaderPage1 from '../components/dashboard/HeaderPage1';

import SelectDataUtama from "../components/subpages/Fitur/SelectDataUtama";

import { getrincianDinas, getDataBidangSub } from '../states/dinas/action';

function Fitur() {
    const { _dinas } = useSelector((state) => state);
    const dispatch = useDispatch();

    const [ind, setInd] = useState(0);
    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getrincianDinas());

    }, [dispatch]);

    const updDataBidang = (v) =>{
        dispatch(getDataBidangSub(v));
        setInd(v.ind);
    }

    if(_dinas.length===0 || _dinas[0].bidang.length === 0 || _dinas[0].bidang[0].sub == undefined){
        return <></>;
    }
    const menus=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Rincian Belanja</b></button>
            </div> 
        ); 
    }
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Rincian Sub Kegiatan'}
                    pageKet={'Pemilihan rincian belanja untuk pembuatan SPJ'}
                    icon={'mdi-office-building-marker '}
                    menu={menus()}
                ></HeaderPage1>
                <SelectDataUtama
                    dt={_dinas}
                    ind={ind}
                    updDataBidang={updDataBidang}
                ></SelectDataUtama> 
            </div> 
        </div>
    );  
}
export default Fitur;
