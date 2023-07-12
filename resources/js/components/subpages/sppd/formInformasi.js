import React from "react";
import { useDispatch, useSelector } from 'react-redux';

import { colJenis } from '../../../states/jenisP/action';
import { useInput } from '../../../hooks/useInput';
import { useState } from 'react';
import HeaderPage1 from '../../../components/dashboard/HeaderPage1';

import Tabel1 from "../../tabel/tabel1";
import sfHtml from "../../mfc/sfHtml"; 
import sfLib from "../../mfc/sfLib"; 
import { setAll, modalClose } from '../../../states/sfHtml/action';

function FormInformasi({dt}) {
    return (
        <div className="form1 bwhite boxShadow1px ">
                <div className="header bwarning">
                    <div className="icon">
                        <span className="mdi mdi-office-building-marker fz25 "></span>
                        <h3>Informasi</h3>
                    </div> 
                </div>
                <div className="body">
                    <ul>
                        <li className="ptb10px">
                            <label className="fbold">Sub Kegiatan</label><br></br>
                            <span>{dt.nmSub}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Uraian Belanja</label><br></br>
                            <span>{dt.nama}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Pagu</label><br></br>
                            <div className="flexR justifySE">
                                <div>
                                    <label className="fbold">Alokasi</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.total)}</small></span>
                                </div>
                                <div>
                                    <label className="fbold">Realisasi</label><br></br>
                                    <span>Rp.<small>0</small></span>
                                </div>
                                <div>
                                    <label className="fbold">Sisa</label><br></br>
                                    <span>Rp.<small>0</small></span>
                                </div>
                            </div>
                            
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Pagu Triwulan</label><br></br>
                            <div className="flexR justifySE">
                                <div>
                                    <label className="fbold">TW 1</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.tw1)}</small></span>
                                </div>
                                <div>
                                    <label className="fbold">TW 2</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.tw2)}</small></span>
                                </div>
                                <div>
                                    <label className="fbold">TW 3</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.tw3)}</small></span>
                                </div>
                                <div>
                                    <label className="fbold">TW 3</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.tw4)}</small></span>
                                </div>
                            </div>
                        </li> 
                    </ul>
                </div>
                {/* <div className="footer"></div> */}
            </div>
    );
}
export default FormInformasi;