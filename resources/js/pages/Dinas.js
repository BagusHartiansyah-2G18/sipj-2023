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
    const [view, setview] = useState(0);
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
    const menus=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Dinas</b></button>
                <button class={"btn2  "+ (view ==1 ? 'bsuccess3':'')} onClick={()=>setview(1)}><b>Bidang</b></button>
                <button class={"btn2  "+ (view ==2 ? 'bsuccess3':'')} onClick={()=>setview(2)}><b>Anggota Bidang</b></button>
                {/* <button class={"btn blight "+ (view ==4 ? 'borderTInfo-5':'')}><b>User Sistem</b></button> */}
            </div> 
        ); 
    }
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Pengisian data SKPD'}
                    pageKet={'Informasi SKPD, Bidang dan Pegawai / Staf'}
                    icon={'mdi-office-building-marker '}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800"> 
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
                </div>
            </div> 
        </div>
    ); 
}
export default Dinas;
