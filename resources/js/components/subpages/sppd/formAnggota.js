import React from "react";
import { useDispatch, useSelector } from 'react-redux';
import { toast } from 'react-toastify';

import { colAnggota, addedWorkStaf } from '../../../states/sppd/action';
import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';

import Tabel1 from "../../tabel/tabel1";
import sfHtml from "../../mfc/sfHtml";
import { setAll, modalClose } from '../../../states/sfHtml/action';
import DataTable from 'react-data-table-component';


function FormAnggotaSppd({ dt, param, indWork }) {
    const dispatch = useDispatch();
    const [search, setSearch] = useInput('');

    const [countDtX, setcountDtX] = useState(0);
    const [dataTamX, setdataTamX] = useState(0);

    const setAnggota = ({ selectedCount, selectedRows }) =>{
        setcountDtX(selectedCount);
        setdataTamX(selectedRows);
    }
    const createFormEntriStaf = () =>{
        dispatch(addedWorkStaf({
            ind: indWork,
            param:{
                ...param,
                no: dt.no,
                date: dt.date
            },
            dt : dataTamX
        }));
    }
    return (
        <div className="form0 bwhite">
            <div className="ribbon ribbon-center ribbon-success">
                <span className="bsuccess">Form Entri </span>
            </div>
            <div className="">
                <div className="flexR justifySA ptb10px">
                    <button className="btn6 bwarning cdark">
                        <span className="mdi mdi-office-building-marker  fziconM "></span>
                        <label className="">Nomor <br/> {dt.no}</label>
                    </button>
                    <button className="btn6 bprimary cwhite">
                        <span className="mdi mdi-office-building-marker fziconM "></span>
                        <label className="">Tujuan <br/> {dt.tujuan}</label>
                    </button>
                    <button className="btn6 binfo cdark ">
                        <span className="mdi mdi-office-building-marker cwarning fziconM "></span>
                        <label className="clight">Tanggal <br/> {dt.date}</label>
                    </button>

                </div>
                <div className="form1 bwhite boxShadow1px ">
                    <div className="header binfo clight">
                        <div className="icon">
                            <span className="mdi mdi-office-building-marker fz25 "></span>
                            <h3>Entri Staf</h3>
                        </div>
                    </div>
                    <div className="body">
                        <Tabel1
                            search={search}
                            oncSearch={setSearch}
                            columns={colAnggota}
                            checkboxSelection={setAnggota}
                            data={dt.anggota.filter((item) => {
                                        if (search === "" && item.xind==undefined) {
                                            return item;
                                        } else if (
                                            item.nmAnggota.toLowerCase().includes(search.toLowerCase()) && item.xind==undefined
                                        ) {
                                            return item;
                                        }
                                    }
                                )}
                            btnAction={
                                (countDtX !== 0 &&
                                    <>
                                        <hr></hr>
                                        <div className="flexR justifySB algI">
                                            <h2>{countDtX+ ` pegawai terpilih`} </h2>
                                            <div className="btnGroup">
                                                <button className="btn2 bprimary clight" onClick={createFormEntriStaf}>Buat Form Rincian Biaya</button>
                                            </div>
                                        </div>
                                        <hr></hr>
                                    </>
                                )
                            }
                        ></Tabel1>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default FormAnggotaSppd;
