/* eslint-disable react/no-children-prop */
import React, { useEffect }  from "react";
import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useParams } from 'react-router-dom';

import HeaderPage1 from '../../components/dashboard/HeaderPage1';
import { getDT, workSetAnggota  } from '../../states/sppd/action';

import FormInformasi from "../../components/subpages/sppd/formInformasi";
import FormAnggotaSppd from "../../components/subpages/sppd/formAnggota";
import FormData from "../../components/subpages/sppd/formData";
import Modal1 from '../../components/Modal/modal1';

import FormEntriBiaya from "../../components/subpages/sppd/formEntriBiaya";

import { toast } from "react-toastify";
import FormFinishSppd from "../../components/subpages/sppd/formFinishSppd";
import FormTahapan from "../../components/subpages/sppd/formTahapan";
import FormDasar from "../../components/subpages/sppd/formDasar";
import FormDokumen from "../../components/subpages/sppd/formDokumen";


function SPPD(){
    const { _sppd } = useSelector((state) => state);
    const { value } = useParams();
    const param = JSON.parse(atob(value));

    // const { basic:[] , anggota:[], dwork:[] } = _sppd;

    const dispatch = useDispatch();

    const [view, setview] = useState(0);
    const [indWork, setindWork] = useState(-1);
    const [modalC, setmodalC] = useState('');


    useEffect(() => {
        dispatch(getDT(value));
    }, [dispatch]);
    if(Object.keys(_sppd).length===0){
        return <></>;
    }

    const stepSetAnggota = (v) =>{
        if(_sppd.anggota==undefined || _sppd.anggota.length==0){
            return toast.error('Bidang ini tidak memiliki daftar Staf');
        }
        const i =_sppd.dwork.findIndex((val)=> val.no === v.no );

        dispatch(workSetAnggota({ ind: i, param:{ ...param, no: _sppd.dwork[i].no } }));
        setindWork(i);
    }
    // if(indWork<0){
    //     stepSetAnggota({no:'000.1.2.3'});
    // }
    // const listAnggota = _sppd.anggota.filter(v=>v.aktif);
    // console.log(view);
    return (
        <>
            <HeaderPage1
                page={'Perjalanan Dinas'}
                pageKet={'Pemberkasan administrasi perjalanan dinas'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>
            <FormInformasi
                dt={_sppd.basic[0]}
            ></FormInformasi>
            <FormData
                dt={_sppd.dwork}
                modalC={setmodalC}
                param={param}
                dataEntri={stepSetAnggota}
            ></FormData>
            {
                (
                    indWork>=0 && _sppd.dwork[indWork].anggota != undefined &&
                    <>
                        <FormTahapan
                            dt={_sppd.dwork[indWork]}
                            setview={setview}
                        ></FormTahapan>
                        <div className="mh50p"></div>
                        {
                            (
                                view===1 &&
                                <FormDasar
                                    dt={_sppd.dwork[indWork]}
                                    indWork={indWork}
                                    modalC={setmodalC}
                                    param={{...param, no:_sppd.dwork[indWork].no}}
                                    >
                                </FormDasar>
                            )
                        }
                        {
                            (
                                view===2 &&
                                <FormAnggotaSppd
                                    dt={_sppd.dwork[indWork]}
                                    indWork={indWork}
                                    param={param}
                                ></FormAnggotaSppd>
                            )
                        }
                    </>
                )
            }

            {
                (
                    indWork>=0 &&
                    _sppd.dwork[indWork].anggota != undefined &&
                    _sppd.dwork[indWork].anggota.filter(v=>v.xind!=undefined).length>0 ?
                    <>
                        {
                            (
                                view===3 &&
                                <FormEntriBiaya
                                    dt={_sppd.dwork[indWork].anggota.filter(v=>v.xind!=undefined)}
                                    param={{ ...param, no :_sppd.dwork[indWork].no }}
                                    modalC={setmodalC}
                                    indWork={indWork}
                                ></FormEntriBiaya>
                            )
                        }
                        {
                            (
                                view===4 &&
                                <FormDokumen
                                    dt={_sppd.pimpinan}
                                    param={{ ...param, no :_sppd.dwork[indWork].no }}
                                    dwork={_sppd.dwork[indWork]}
                                    indWork={indWork}
                                ></FormDokumen>
                            )
                        }
                        {
                            (
                                view===5 &&
                                <FormFinishSppd
                                    dt={_sppd.dwork[indWork]}
                                    indWork={indWork}
                                    modalC={setmodalC}
                                    param={param}
                                    >
                                </FormFinishSppd>
                            )
                        }
                    </>:
                    <>{
                        (
                            view>3 && indWork>=0 &&
                            <b className="pwrap bwarning">Mohon untuk menambahkan data pewagai yang ditugaskan !!!</b>
                        )
                    }</>
                )
            }

            <Modal1
                children ={modalC}
            ></Modal1>
        </>
    );
}
export default SPPD;
