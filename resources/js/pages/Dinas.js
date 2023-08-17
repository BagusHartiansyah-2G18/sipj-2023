/* eslint-disable react/no-children-prop */
import React, { useEffect }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { getDT, getDBidang, getDAnggota } from '../states/dinas/action';
import { useState } from 'react';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormDinas from "../components/subpages/dinas/formDinas";
import FormBidang from "../components/subpages/dinas/formBidang";
import FormAnggota from "../components/subpages/dinas/formAnggota";
import Modal1 from '../components/Modal/modal1';
import FormMember from "../components/subpages/dinas/formMember";


function Dinas() {
    const { _dinas } = useSelector((state) => state);


    const [ind, setInd] = useState(0);
    const [index, setIndex] = useState(0);
    const dispatch = useDispatch();
    const [modalC, setmodalC] = useState('');
    const [view, setview] = useState(1);
    const changeDinas=({ kdDinas, indx})=>{
        // console.log(_dinas, indx);
        if(_dinas[indx].bidang === undefined){
            dispatch(getDBidang({kdDinas,ind:indx}));
        }
        setInd(indx);
        setIndex(0);
    }
    const changeBidang=(v)=>{
        dispatch(getDAnggota(v));

        // const i =_dinas.findIndex((val)=> val.kdDBidang === v.kdDBidang );
        setInd(ind);
        setIndex(v.index);
    }

    function setContentModal(v){
        setmodalC(v);
    }

    useEffect(() => {
        dispatch(getDT());
    }, [dispatch]);
    if(_dinas.length===0){
        return (<></>)        ;
    }
    return (
        <>
            <HeaderPage1
                page={'Dinas'}
                pageKet={'Pengelolaan Data Dinas'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <div className="binfo pwrap borderR10px">
                <div className="mh100p"></div>
                <div className="galeryList bwhite">
                    <div className="item blight unselect borderpurpleT5px">
                        <span className="mdi mdi-home-analytics cdark binfo fziconS"></span>
                        <h2 className="judul">Dinas</h2>
                        <button className="btn2 bprimary clight justifyC fz20 mw150px" onClick={()=>setview(0)} >view</button>
                    </div>
                    <div className="item blight select  borderpurpleB5px">
                        <span className="mdi mdi-home-group cdark binfo fziconS"></span>
                        <h2 className="judul">Bidang</h2>
                        <button className="btn2 bprimary clight justifyC fz20 mw150px" onClick={()=>setview(1)}>view</button>
                    </div>
                    <div className="item blight unselect borderpurpleT5px">
                        <span className="mdi mdi-home-assistant cdark binfo fziconS"></span>
                        <h2 className="judul">Anggota Bidang</h2>
                        <button className="btn2 bprimary clight justifyC fz20 mw150px" onClick={()=>setview(2)}>view</button>
                    </div>
                    <div className="item blight select borderpurpleB5px">
                        <span className="mdi mdi-account-school cdark binfo fziconS"></span>
                        <h2 className="judul">User Sistem</h2>
                        <button className="btn2 bprimary clight justifyC fz20 mw150px" onClick={()=>setview(3)}>view</button>
                    </div>
                </div>
            </div>
            <div className="hheader"></div>
            {
                (
                    view === 0 &&
                    <FormDinas
                        dt={_dinas}
                        modalC={setContentModal}
                    ></FormDinas>
                )
            }
            {
                (
                    view === 1 &&
                    <FormBidang
                        dt={_dinas}
                        changeDinas={changeDinas}
                        modalC={setContentModal}
                        ind={ind}
                    ></FormBidang>
                )
            }
            {
                (
                    (Object.keys(_dinas[ind]).length>0 && _dinas[ind].bidang!=undefined && _dinas[ind].bidang.length>0) && view === 2 &&
                    <FormAnggota
                        dt={_dinas[ind].bidang}
                        index={index}
                        ind={ind}
                        kdDinas={_dinas[ind].kdDinas}
                        modalC={setContentModal}
                        changeBidang={changeBidang}
                    ></FormAnggota>
                )
            }
            {
                (
                    (Object.keys(_dinas[ind]).length>0 && _dinas[ind].bidang!=undefined && _dinas[ind].bidang.length>0) && view === 3  &&
                    <FormMember
                        dt={_dinas[ind].bidang}
                        index={index}
                        ind={ind}
                        kdDinas={_dinas[ind].kdDinas}
                        modalC={setContentModal}
                        changeBidang={changeBidang}
                    ></FormMember>
                )
            }
             <Modal1
                children ={modalC}
            ></Modal1>
        </>
    );
}
export default Dinas;
