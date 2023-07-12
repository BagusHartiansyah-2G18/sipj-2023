import React, { useEffect }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { getDT, getDBidang, getDAnggota } from '../states/dinas/action';
import { useState } from 'react';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormDinas from "../components/subpages/dinas/formDinas";
import FormBidang from "../components/subpages/dinas/formBidang";
import FormAnggota from "../components/subpages/dinas/formAnggota";
import Modal1 from '../components/Modal/modal1';


function Dinas() {
    const { _dinas, _html } = useSelector((state) => state);
    const [ind, setInd] = useState(0);
    const [index, setIndex] = useState(0);
    const dispatch = useDispatch();
    const [modalC, setmodalC] = useState(''); 

    const changeDinas=({kdDinas,ind})=>{
        dispatch(getDBidang({kdDinas,ind}));
        setInd(ind);
        setIndex(0);
    }
    const changeBidang=(v)=>{ 
        dispatch(getDAnggota(v));
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
                pageKet={'daftar dinas diKSB'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <FormDinas 
                dt={_dinas}
                modalC={setContentModal}
            ></FormDinas>
            <FormBidang 
                dt={_dinas}
                changeDinas={changeDinas}
                modalC={setContentModal}
                ind={ind}
            ></FormBidang>
            {
                (
                    (Object.keys(_dinas[ind]).length>0 && _dinas[ind].bidang!=undefined && _dinas[ind].bidang.length>0) &&
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
            <Modal1
                children ={modalC}
            ></Modal1>
        </>
    );
}
export default Dinas;