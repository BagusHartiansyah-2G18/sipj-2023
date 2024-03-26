import React from "react";
import { useDispatch } from 'react-redux';

import { colAnggota, addedWorkStaf } from '../../../states/sppd/action';
import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';

import Tabel1 from "../../tabel/tabel1";
import PropTypes from "prop-types";


function FormAnggotaSppd({ dt, param, indWork, next}) {
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
        setcountDtX(0); 
    }
    return (
        <div className="form0 bwhite">
            <div className="">
                <div className="form1 bwhite boxShadow1px ">
                    <div className="header binfo clight">
                        <div className="icon">
                            <span className="mdi mdi-office-building-marker fz25 "></span>
                            <h3><b>2. Penentuan Pegawai yang ditugaskan</b></h3>
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
                                                <button className="btn2 bprimary clight" onClick={createFormEntriStaf}>Buatkan Dokumen</button>
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

FormAnggotaSppd.propTypes = {
    dt : PropTypes.object.isRequired,
    param : PropTypes.object.isRequired,
    indWork : PropTypes.number.isRequired,
    next: PropTypes.func.isRequired
}
export default FormAnggotaSppd;
