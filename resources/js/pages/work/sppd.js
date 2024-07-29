/* eslint-disable react/no-children-prop */
import React, { useEffect, useState }  from "react"; 
import { useDispatch, useSelector } from 'react-redux';
import { useParams } from 'react-router-dom';

import HeaderPage1 from '../../components/dashboard/HeaderPage1';
import { getDT, workSetAnggota  } from '../../states/sppd/action';

import FormAnggotaSppd from "../../components/subpages/sppd/formAnggota";
import FormData from "../../components/subpages/sppd/formData";
import Modal1 from '../../components/Modal/modal1';

import FormEntriBiaya from "../../components/subpages/sppd/formEntriBiaya";

import { toast } from "react-toastify";
import FormFinishSppd from "../../components/subpages/sppd/formFinishSppd";
import FormTahapan from "../../components/subpages/sppd/formTahapan";
import FormDasar from "../../components/subpages/sppd/formDasar";
import FormPilihPimpinan from "../../components/subpages/sppd/formPillihPimpinan";

function SPPD(){
    const { _sppd } = useSelector((state) => state);
    const { value } = useParams();
    const param = JSON.parse(atob(value));

    // const { basic:[] , anggota:[], dwork:[] } = _sppd;

    const dispatch = useDispatch();
    const [viewInduk, _viewInduk] = useState(0); 
    const [view, setview] = useState(1);
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
        _viewInduk(1);
        setview(1);
    }
    // if(indWork<0){
    //     stepSetAnggota({
    //         "no": "1",
    //         "date": "2024-07-17",
    //         "status": "berproses",
    //         "kdBAnggota": "",
    //         "kdBidang": "1",
    //         "kdDBidang": "1",
    //         "tujuan": "-",
    //         "noBuku": "-",
    //         "tglBuku": "-",
    //         "file": "-",
    //         "maksud": "percobaan pembuatan sistem, untuk memstikan bentuk datanya",
    //         "angkut": "Darat",
    //         "tempatS": "Taliwang",
    //         "tempatE": "Sumbawa",
    //         "dateE": "2024-07-10",
    //         "anggaran": "DPA Bappeda",
    //         "keterangan": "",
    //         "lokasi": "Sumbawa",
    //         "fileD": "",
    //         "dasar": "",
    //         "pimOpd": null,
    //         "pimBupati": null,
    //         "pimSetda": null,
    //         "tdOPD": null,
    //         "tdBUPATI": null,
    //         "tdSETDA": null,
    //         "noSPPD": null,
    //         "total": null
    //     });
    //     // console.log(_sppd.dwork[indWork].anggota);
    // } 
    const menuInduk=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (viewInduk ==0 ? 'bsuccess3':'')} onClick={()=>_viewInduk(0)}><b>Data SPPD</b></button>
                <button class={"btn2  "+ (viewInduk ==1 ? 'bsuccess3':'')} ><b>Execute SPPD</b></button>
            </div> 
        ); 
    }   
    const executeSPPD=()=>{
        return (
            <div class="FM1 ">
                <div class="header bdark">
                    <div class=" flexR">
                        <button className="btn bnone">
                            <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                        </button>
                        <h2 className="  pl0 aiE fBebasNeue">
                            <b>{_sppd.dwork[indWork].maksud}{`( Informasi )`}</b> 
                        </h2>
                    </div> 
                    <div class="btnGroup">
                        <button class={"btn2  "+ (view ==1 ? 'bsuccess3':'')} onClick={()=>setview(1)}><b>Dasar SPPD</b></button>
                        <button class={"btn2  "+ (view ==2 ? 'bsuccess3':'')} onClick={()=>setview(2)}><b>Pemilihan Pegawai</b></button>
                        <button class={"btn2  "+ (view ==3 ? 'bsuccess3':'')} onClick={()=>setview(3)}><b>Verifikasi Data</b></button>
                        <button class={"btn2  "+ (view ==4 ? 'bsuccess3':'')} onClick={()=>setview(4)}><b>Pemilihan Pimpinan</b></button>
                        <button class={"btn2  "+ (view ==5 ? 'bsuccess3':'')} onClick={()=>setview(5)}><b>Cetak Dokumen</b></button> 
                    </div> 
                </div>
                <div class="body blight pm0 bsolid1" style={{width:"unset"}}><br/>
                <>
                        {(
                            indWork>=0 && _sppd.dwork[indWork].anggota != undefined &&
                            <> 
                                <div className="mh50p"></div>
                                {
                                    (
                                        view===1 &&
                                        <FormDasar
                                            dt={_sppd.dwork[indWork]}
                                            indWork={indWork}
                                            modalC={setmodalC}
                                            param={{...param, no:_sppd.dwork[indWork].no}}
                                            setview={setview} >
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
                                            next={setview}
                                        ></FormAnggotaSppd>
                                    )
                                }
                            </>
                        )}

                        { (
                            indWork>=0 &&
                            _sppd.dwork[indWork].anggota != undefined &&
                            _sppd.dwork[indWork].anggota.filter(v=>v.xind!=undefined).length>0 ?
                            <>
                                {
                                    (
                                        view===3 &&
                                        <FormEntriBiaya
                                            dt={_sppd.dwork[indWork].anggota.filter(v=>v.xind!=undefined)}
                                            param={{ ...param, no :_sppd.dwork[indWork].no, noSppd :_sppd.dwork[indWork].noSppd }}
                                            modalC={setmodalC}
                                            indWork={indWork}
                                        ></FormEntriBiaya>
                                    )
                                }
                                {
                                    (
                                        view===4 &&
                                        <FormPilihPimpinan
                                            dt={_sppd.pimpinan}
                                            param={{ ...param, no :_sppd.dwork[indWork].no }}
                                            dwork={_sppd.dwork[indWork]}
                                            indWork={indWork}
                                        ></FormPilihPimpinan>
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
                            <>
                                {(
                                    view>3 && indWork>=0 &&
                                    <div className="flexR bwarning jcC">
                                        <b className="pwrap-10  ">Mohon untuk menambahkan data pewagai yang ditugaskan !!!</b>
                                        <br/>
                                        <br/>
                                        <br/>
                                    </div>
                                )}
                            </>
                        ) }  
                    </>
                    {/* <div className="Mcontainer2Form">
                        <div className="right-1" >
                            <div class="FM1 "> 
                                <div class="body bdark pwrap_5 flexC jcSA" style={{width:"unset", minHeight:"350px" }}><br/>
                                      
                                </div>
                            </div>
                        </div>
                        <div className="left ">
                            <div class="FM1 "> 
                                <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                                     
                                </div>
                            </div>
                        </div>
                    </div> 
                     */}
                </div>
            </div>  
        )
    };
    return (
        <div className="Mcontainer">
            <div className="body pm0"> 
                <HeaderPage1
                    page={'Pembuatan SPJ SPPD'}
                    pageKet={'Data Agenda dan Fitur SPPD'}
                    icon={'mdi-office-building-marker '} 
                    menu={menuInduk()}
                ></HeaderPage1>  
                {(
                    viewInduk == 0 ?
                    <FormData
                        dt={_sppd.dwork}
                        di={_sppd.basic[0]}
                        modalC={setmodalC}
                        param={param}
                        dataEntri={stepSetAnggota}
                    ></FormData>
                    :executeSPPD()
                )}
                
                <Modal1
                    children={modalC}
                ></Modal1>      
            </div>
        </div>
    ); 
}
export default SPPD;
