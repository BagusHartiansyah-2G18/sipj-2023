import React, { useEffect, useState }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { getDT } from '../states/rekeningB/action';
 
import HeaderPage1 from '../components/dashboard/HeaderPage1';
import FormApbd from "../components/subpages/rekeningBelanja/formApbd";
import FormApbd6 from "../components/subpages/rekeningBelanja/formApbd6";

function RekeningBelanja() {
    const { _rek } = useSelector((state) => state);
    const [ind, setInd] = useState(0);
    const dispatch = useDispatch();

    const [view, setview] = useState(0);

    useEffect(() => {
        dispatch(getDT());
    }, [dispatch]);
    if(_rek.length===0){
        return (<></>)        ;
    }

    const selectSub=(v)=>{
        const i =_rek.findIndex((val)=> val.kdApbd6 === v.kdApbd6 );
        setInd(i);
    }
    const menus=()=>{ 
        return(
            <div class="acC grid-col3 ">
                <button class={"btn2  "+ (view ==0 ? 'bsuccess3':'')} onClick={()=>setview(0)}><b>Rekening</b></button>
                {/* <button class={"btn blight "+ (view ==1 ? 'borderTInfo-5':'')} onClick={()=>setview(1)}><b>Bidang</b></button>
                <button class={"btn blight "+ (view ==2 ? 'borderTInfo-5':'')} onClick={()=>setview(2)}><b>Anggota Bidang</b></button> */}
             </div> 
        ); 
    }
    return (
        <div className="Mcontainer">
            <div className="body"> 
                <HeaderPage1
                    page={'Informasi Rekening Belanja'}
                    pageKet={'untuk Rincian Belanja SKPD'}
                    icon={'mdi-office-building-marker '}
                    menu={menus()}
                ></HeaderPage1>
                <div className="bodyFlexRow800"> 
                    <div className="Mcontainer2Form">
                        <div className="right" >
                            <FormApbd
                                className=" w40p"
                                dt={_rek[ind]}
                            ></FormApbd>
                        </div>
                        <div className="left">
                        <FormApbd6
                            dt={_rek}
                            selectSub={selectSub}
                        ></FormApbd6>
                        </div>
                    </div>  
                </div>
            </div> 
        </div>
    );  
}
export default RekeningBelanja;
