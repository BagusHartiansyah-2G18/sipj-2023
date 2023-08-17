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
    return (
        <>
            <HeaderPage1
                page={'Sub Kegiatan Bidang'}
                pageKet={'daftar Sub Kegiatan Bidang'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
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
        </>
    );
}
export default BidangSubKegiatan;
