import React from "react";
import { useDispatch } from 'react-redux';

import { workDelAnggota, addWorkUraian, updWorkUraian, delWorkUraian, updWorkAnggota } from '../../../states/sppd/action';
import sfHtml from "../../mfc/sfHtml";
import { setHtml, modalClose } from '../../../states/sfHtml/action';

import FormUraian from "./sub/formUraian";
import FormNoSppd from "./sub/formNoSpp";

import PropTypes from "prop-types";

function FormEntriBiaya({ dt, param, modalC, indWork }) {
    const dispatch = useDispatch();
    function mclose(){
        dispatch(modalClose());
    }

    // delete nama staf
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
        dispatch(addWorkUraian({
            ...param,
            uraian: '',
            volume: '',
            satuan: '',
            nilai:'',
            kdBidang:dt[ianggota].kdBidang,
            kdBAnggota:dt[ianggota].kdBAnggota,
            kdJPJ: dt[ianggota].ddukung[idukung].kdJPJ,
            kdDP: dt[ianggota].ddukung[idukung].kdDP,
            ind : indWork,
            index: dt[ianggota].xind,
            index_1: idukung,
        }))
    }
    const updDPendukung = ({ iuraian, ianggota, idukung, kdUraian, uraian, volume, satuan, nilai  }) =>{
        dispatch(updWorkUraian({
            ...param,
            kdBidang:dt[ianggota].kdBidang,
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
        // console.log(dt[ind]);
        dispatch(updWorkAnggota({
            kdBAnggota:dt[ind].kdBAnggota,
            kdBidang: dt[ind].kdBidang,
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
    return (
        <div className="form1 bwhite boxShadow1px ">
            <div className="header binfo cwhite">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3><b>3. Form Rincian Biaya (KWITANSI)</b></h3>
                </div>
            </div>
            <div className=" w95p m0auto ptb10px">
                {
                    dt.map((v,i)=>{
                        return (
                            <div className="form1 bwhite" key={'user'+i}>
                                <div className="header">
                                    <h3>{v.nmAnggota}</h3>
                                    <div className="btnGroup">
                                        <button className="btn2 bdanger clight" onClick={()=>del(i)}><span className="mdi mdi-delete-forever clight fz25" /> Hapus</button>
                                    </div>
                                </div>
                                <div className="body">
                                    {
                                        <FormNoSppd
                                            key={"nosppd"+i}
                                            ind ={i}
                                            updNomorSppd={updNomorSppd}
                                            dt={v}>
                                        </FormNoSppd>
                                    }
                                    {
                                        v.ddukung.map((v1,i1)=>{
                                            return (
                                                <div className="ptb10px" key={'dukung'+i1}>
                                                    <div className=" flexR justifySB">
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
                                                                        dt={v2}
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
                        );
                    })
                }
            </div>
            {/* <div className="footer"></div> */}
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
