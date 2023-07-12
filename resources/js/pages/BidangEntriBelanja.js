import React, { useEffect } from "react";

import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import Modal1 from '../components/Modal/modal1';

import FormBelanja from "../components/subpages/BidangEntri/Belanja";

import { getrincianDinas, getDataBidang } from '../states/dinas/action';

function BidangEntriBelanja(){
    const { _dinas, _html } = useSelector((state) => state);
    const dispatch = useDispatch();

    const [ind, setInd] = useState(0);
    const [modalC, setmodalC] = useState('');

    useEffect(() => {
        dispatch(getrincianDinas());

    }, [dispatch]);
    const updDataBidang = (v) =>{
        dispatch(getDataBidang(v));
        setInd(v.ind);
    }

    if(_dinas.length===0 || _dinas[0].bidang.length === 0 || _dinas[0].bidang[0].sub == undefined){
        return <></>;
    }
    return (
        <>
            <HeaderPage1
                page={'Belanja Bidang'}
                pageKet={'Daftar Belanja Bidang'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <FormBelanja
                dt={_dinas}
                modalC={setmodalC}
                ind={ind}
                updDataBidang={updDataBidang}
            ></FormBelanja>
            <Modal1
                children ={modalC}
            ></Modal1>
        </>
    );
}
export default BidangEntriBelanja;
