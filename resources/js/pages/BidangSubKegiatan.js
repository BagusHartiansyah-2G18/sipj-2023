/* eslint-disable react/no-children-prop */
import React, { useEffect } from "react";
import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import Modal1 from '../components/Modal/modal1';

import FormListSubKegiatan from "../components/subpages/BidangKegiatan/formListKegiatan";

import { getDinasBidang, getDataBidangSub } from '../states/dinas/action';



function BidangSubKegiatan(){
    const { _dinas } = useSelector((state) => state);
    const dispatch = useDispatch();

    const [ind, setInd] = useState(0);
    const [modalC, setmodalC] = useState('');
    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getDinasBidang());

    }, [dispatch]);
    if(_dinas.length===0){
        return (<></>)        ;
    }

    const updDataBidang = (v) =>{
        dispatch(getDataBidangSub(v));
        setInd(v.ind);
    }
    const menus=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Pemilihan Sub</b></button>
            </div> 
        ); 
    }
    
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Pemilihan Sub Kegiatan'}
                    pageKet={'menyesuaikan dengan bidang terkait'}
                    icon={'mdi-office-building-marker '}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800"> 
                    {
                        (
                            Object.keys(_dinas[ind]).length != 0 &&
                            // _dinas[ind].bidang.length>0 &&
                            <FormListSubKegiatan
                                ind={ind}
                                dt={_dinas}
                                modalC={setmodalC}
                                updDataBidang={updDataBidang}
                            ></FormListSubKegiatan>
                        )
                    }
                    <Modal1
                        children ={modalC}
                    ></Modal1>
                </div>
            </div> 
        </div>
    );  
}
export default BidangSubKegiatan;
