import React, { useEffect } from "react";

import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import Modal1 from '../components/Modal/modal1';

import SelectDataUtama from "../components/subpages/Fitur/SelectDataUtama";

import { getrincianDinas, getDataBidangSub } from '../states/dinas/action';

function Fitur() {
    const { _dinas, _html } = useSelector((state) => state);
    const dispatch = useDispatch();

    const [ind, setInd] = useState(0);
    const [modalC, setmodalC] = useState('');

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
    return (
        <>
            <HeaderPage1
                page={'Pertanggung Jawaban'}
                pageKet={'Daftar sub kegiatan Dan uraian Belanja'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>

            {/* <div className="form0 bwhite">
                <div className="ribbon ribbon-center ribbon-success">
                    <span className="bsuccess">DAFTAR FITUR Jenis Pertanggung Jawaban</span>
                </div>
                <div className="w95p m0auto">
                    <div className="flexR3 mwrap">
                        <button className="btn7 " to={`/home/work/sppd`}>
                            <span className="mdi mdi-login bprimary clight fziconS"></span>
                            <h2 className="cdark">Perjalanan Dinas</h2>
                        </button>
                        <button className="btn7 " to={`/home/work/makanMinum`}>
                            <span className="mdi mdi-login bwarning clight fziconS"></span>
                            <h2 className="cdark">Makan Minum</h2>
                        </button>
                        <button className="btn7 " to={`/home/work/kontrak`}>
                            <span className="mdi mdi-login bsuccess clight fziconS"></span>
                            <h2 className="cdark">Kontrak</h2>
                        </button>
                    </div>
                </div>
            </div> */}
            <SelectDataUtama
                dt={_dinas}
                modalC={setmodalC}
                ind={ind}
                updDataBidang={updDataBidang}
            ></SelectDataUtama>

        </>
    );
}
export default Fitur;
