/* eslint-disable react/no-children-prop */
import React, { useEffect } from "react";

import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import Modal1 from '../components/Modal/modal1';

import FormBelanja from "../components/subpages/BidangEntri/Belanja";

import { getrincianDinas, getDataBidang, __listKDRekening,actGenerateAutoRekening } from '../states/dinas/action';

function BidangEntriBelanja(){
    const { _dinas } = useSelector((state) => state);
    const dispatch = useDispatch();

    const [ind, setInd] = useState(0);
    const [modalC, setmodalC] = useState('');
    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getrincianDinas());
        dispatch(__listKDRekening({kdDF:'894670f302d1a5e91437de1d32e7d35d'}));

    }, [dispatch]);
    const updDataBidang = (v) =>{
        dispatch(getDataBidang(v));
        setInd(v.ind);
    }

    if(_dinas.length===0 || _dinas[0].bidang.length === 0 || _dinas[0].bidang[0].sub == undefined){
        return <></>;
    } 
    const generateAuto=()=>{
        dispatch(
            actGenerateAutoRekening({data:btoa(JSON.stringify(_dinas[0].listRekening))})
        );
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
                    page={'Fitur Rincian Belanja'}
                    pageKet={'Memdaftarkan Jenis SPJ, Pembagian 3 Bulanan dan Entri Rincian'}
                    icon={'mdi-office-building-marker '}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800"> 
                    <FormBelanja
                        dt={_dinas}
                        modalC={setmodalC}
                        ind={ind}
                        updDataBidang={updDataBidang}
                        generateAuto={generateAuto}
                    ></FormBelanja>
                    <Modal1
                        children ={modalC}
                    ></Modal1>
                </div>
            </div> 
        </div>
    );   
}
export default BidangEntriBelanja;
