import React from "react";
import { useDispatch } from 'react-redux';

import { workDelAnggota, addWorkUraian, updWorkUraian, delWorkUraian, updWorkAnggota, uploadDataVerifikasiStaf } from '../../../states/sppd/action';
import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';

import FormUraian from "./sub/formUraian";
import FormNoSppd from "./sub/formNoSpp";
import FormVerifikasiStaf from "./sub/formVerifikasiStaf";

import PropTypes from "prop-types"; 


function FormEntriBiaya({ dt, param, modalC, indWork }) {
    const dispatch = useDispatch();
    function mclose(){
        dispatch(modalClose());
    } 
    const del = (i) =>{
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>Apa benar ingin memhapus data ini ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xdeled:()=>xdeled(i)
                    })
                )
            })
        );
        dispatch(
            setHtml({
                modal : true,
            })
        );
    }
    const xdeled = (ind) =>{
        dispatch(workDelAnggota({
            ind: indWork,
            index:dt[ind].ind,
            param:{
                ...param,
                kdBAnggota:dt[ind].kdBAnggota,
                kdBidang:dt[ind].kdDBidang
            }
        }))
        mclose();
    }

    const addDPendukung = (ianggota,idukung) =>{
        const kdBidang = (dt[ianggota].kdBidang==undefined? dt[ianggota].kdDBidang:dt[ianggota].kdBidang);
        dispatch(addWorkUraian({
            ...param,
            uraian: '',
            volume: '',
            satuan: '',
            nilai:'',
            kdBidang:kdBidang,
            kdBAnggota:dt[ianggota].kdBAnggota,
            kdJPJ: dt[ianggota].ddukung[idukung].kdJPJ,
            kdDP: dt[ianggota].ddukung[idukung].kdDP,
            ind : indWork,
            index: dt[ianggota].xind,
            index_1: idukung,
        }))
    }
    const updDPendukung = ({ iuraian, ianggota, idukung, kdUraian, uraian, volume, satuan, nilai  }) =>{
        const kdBidang = (dt[ianggota].kdBidang==undefined? dt[ianggota].kdDBidang:dt[ianggota].kdBidang);
        dispatch(updWorkUraian({
            ...param,
            kdBidang:kdBidang,
            kdBAnggota:dt[ianggota].kdBAnggota,
            kdJPJ: dt[ianggota].ddukung[idukung].kdJPJ,
            kdDP: dt[ianggota].ddukung[idukung].kdDP,
            ind : indWork,
            index: dt[ianggota].xind,
            index_1: idukung,
            iuraian,
            kdUraian,
            uraian,
            volume,
            satuan,
            nilai
        }))
    }

    const delDPendukung = (v) =>{
        modalC(
            sfHtml.modalForm({
                label : "Konfirmasi",
                mclose,
                children : (
                    <p>Apa benar ingin memhapus data ini ?</p>
                ),
                footer : (
                    sfHtml.modalBtn({
                        mclose,
                        xdeled:()=>xdeledDPendukung(v)
                    })
                )
            })
        );
        dispatch(
            setHtml({
                modal : true,
            })
        );
    }
    const xdeledDPendukung = ({ iuraian, ianggota, idukung, kdUraian }) =>{
        dispatch(delWorkUraian({
            ...param,
            kdBAnggota:dt[ianggota].kdBAnggota,
            kdJPJ: dt[ianggota].ddukung[idukung].kdJPJ,
            kdDP: dt[ianggota].ddukung[idukung].kdDP,
            ind : indWork,
            index: dt[ianggota].xind,
            index_1: idukung,
            iuraian,
            kdUraian,
        }))
        mclose();
    }
    const updNomorSppd = ({ ind, noSppd }) =>{
        const kdBidang = (dt[ind].kdBidang==undefined? dt[ind].kdDBidang:dt[ind].kdBidang);
        dispatch(updWorkAnggota({
            kdBAnggota:dt[ind].kdBAnggota,
            kdBidang: kdBidang,
            no : dt[ind].no,
            kdDinas :dt[ind].kdDinas,
            kdSub : dt[ind].kdSub,
            kdJudul:dt[ind].kdJudul,
            noSppd,
            ind: indWork,
            index:dt[ind].xind
        }))
        // mclose();
    } 
    if (dt.length===0) {
        return <></>;
    }  
    const updManualStaf=(v)=>{   
        const kdBidang = (dt[v.ind].kdBidang==undefined? dt[v.ind].kdDBidang:dt[v.ind].kdBidang); 
        uploadDataVerifikasiStaf({
            fileD:btoa(JSON.stringify(v)),
            ...param, 
            kdBAnggota:dt[v.ind].kdBAnggota,
            kdBidang:kdBidang
        });
    } 
    return (
        <div className="Mcontainer">
            <div className="body">
                <div class="FM1 ">
                    <div class="header bwhite">
                        <div class="cdark flexR">
                            <button className="btn bnone">
                                <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                            </button>
                            <h2 className="  pl0 aiE fBebasNeue">
                                <b>Verifikasi Data - Data Kwitansi</b> 
                            </h2>
                        </div> 
                    </div>
                    <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                        {
                            dt.map((v,i)=>{
                                return (
                                    <div className="Mcontainer2Form">
                                        <div className="right-1" >
                                            <FormVerifikasiStaf
                                                value={{...v, start:true}}
                                                saved={updManualStaf}
                                                ind ={i}
                                            ></FormVerifikasiStaf>
                                        </div>
                                        <div className="left ">
                                            <div class="FM1 ">
                                                <div class="header bwhite">
                                                    <div class="cdark flexR">
                                                        <button className="btn bnone">
                                                            <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                                                        </button>
                                                        <h2 className="  pl0 aiE fBebasNeue">
                                                            <b>{v.nmAnggota}</b> 
                                                        </h2>
                                                    </div> 
                                                    <div className="btnGroup">
                                                        <button className="btn2 bdanger clight" onClick={()=>del(i)}><span className="mdi mdi-delete-forever clight fz25" /> Hapus</button>
                                                    </div>
                                                </div>
                                                <div class="body blight bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                                                    {
                                                        <FormNoSppd
                                                            key={"nosppd"+i}
                                                            ind ={i}
                                                            updNomorSppd={updNomorSppd}
                                                            dt={v}
                                                            start={{start:true}}>
                                                        </FormNoSppd>
                                                    }
                                                    {
                                                        v.ddukung.map((v1,i1)=>{ 
                                                            return (
                                                                <div className="ptb10px" key={'dukung'+i1}>
                                                                    <div className=" flexR jcSB">
                                                                        <button className="btn7 ">
                                                                            <span className="mdi mdi-login binfo clight fziconS"></span>
                                                                            <h2 className="cdark">{v1.nmDP}</h2>
                                                                        </button>
                                                                        <button className="btn2 bprimary clight" onClick={()=>addDPendukung(i,i1)}>Entri</button>
                                                                    </div>
                                                                    {
                                                                        (
                                                                            v1.uraian!= undefined &&
                                                                            v1.uraian.map((v2,i2)=>{

                                                                                return (
                                                                                    <FormUraian
                                                                                        key={'uraian'+i2}
                                                                                        dt={{...v2, nmDP:v1.nmDP}}
                                                                                        onUpded={updDPendukung}
                                                                                        onDeled={delDPendukung}
                                                                                        value={{
                                                                                            iuraian: i2,
                                                                                            ianggota : i,
                                                                                            idukung: i1,
                                                                                            kdUraian: v2.kdUraian
                                                                                        }}
                                                                                    ></FormUraian>
                                                                                );
                                                                            })
                                                                        )
                                                                    }
                                                                </div>
                                                            )
                                                        })
                                                    }
                                                </div>
                                            </div> 
                                        </div>
                                    </div> 
                                );
                            })
                        }
                    </div>
                </div> 
            </div>
        </div> 
    );  
}
FormEntriBiaya.propTypes = {
    dt : PropTypes.array.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    modalC : PropTypes.func.isRequired
}
export default FormEntriBiaya;
