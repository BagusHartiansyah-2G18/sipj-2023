/* eslint-disable react/no-children-prop */
import React, { useEffect }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import {
    getDT, added, upded, deled,
    getDataDukung, addedDukung, updedDukung, deledDukung,
} from '../states/jenisP/action';
import { useState } from 'react';

import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormJenis from "../components/subpages/jenisP/formJenis";
import FormJenisPendukung from "../components/subpages/jenisP/formJenisPendukung";
import Modal1 from '../components/Modal/modal1';

function JenisP() {
    const { _jenis } = useSelector((state) => state);
    const [ind, setInd] = useState(0);
    const dispatch = useDispatch();
    const [modalC, setmodalC] = useState('');

    function setContentModal(v){
        setmodalC(v);
    }
    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getDT());
    }, [dispatch]);
    if(_jenis.length===0){
        return (<></>)        ;
    }
    const changeJenis=({kdJPJ,ind})=>{
        dispatch(getDataDukung({kdJPJ,ind}));
        setInd(ind);
        // setIndex(0);
    }
    const actFormJenis=({kdJPJ=-1,nmJPJ,ind=-1,act="del"})=>{
        switch (act) {
            case "add":
                dispatch(added({nmJPJ}));
            break;
            case "upd":
                dispatch(upded({kdJPJ,nmJPJ,ind}));
            break;
            default:
                dispatch(deled({kdJPJ,ind}));
            break;
        }
    }

    const actFormJenisDukungan=({ kdDP=-1, nmDP, index=-1, act="del" })=>{
        switch (act) {
            case "add":
                dispatch(addedDukung({ kdJPJ:_jenis[ind].kdJPJ, nmDP, ind }));
            break;
            case "upd":
                dispatch(updedDukung({ kdJPJ:_jenis[ind].kdJPJ, kdDP, nmDP, ind, index }));
            break;
            default:
                dispatch(deledDukung({ kdJPJ:_jenis[ind].kdJPJ, kdDP, ind, index}));
            break;
        }
    }
    const menus=()=>{ 
        return(
            <div class="acC grid-col3 ">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Jenis SPJ</b></button>
                <button class={"btn2  "+ (view ==1 ? 'bsuccess3':'')}  onClick={()=>setview(1)}><b>Sub Jenis</b></button>  
             </div> 
        ); 
    }
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Informasi Jenis SPJ'}
                    pageKet={'data dan bagian pendukungnya'}
                    icon={'mdi-office-building-marker cdark'}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800">
                    {(
                        view == 0 ?
                        <FormJenis
                            dt={_jenis}
                            actFormJenis={actFormJenis}
                            modalC={setContentModal}
                        ></FormJenis>
                        :<FormJenisPendukung
                            dt={_jenis}
                            changeJenis={changeJenis}
                            actFormJenisDukungan={actFormJenisDukungan}
                            ind={ind}
                            modalC={setContentModal}
                        ></FormJenisPendukung>
                    )}
                </div>  
                <Modal1
                    children ={modalC}
                ></Modal1>
            </div>
        </div> 
    );
}
export default JenisP;
