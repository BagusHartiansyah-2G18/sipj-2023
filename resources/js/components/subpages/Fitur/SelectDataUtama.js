import React from "react";
import { useState } from 'react';
import { useDispatch } from 'react-redux';

import { useInput } from '../../../hooks/useInput';
import sfLib from "../../mfc/sfLib";

import Select from "react-select";

import { colSub, colRincianTw, getDataSubBidang, getDataUraianSub } from '../../../states/dinas/action';
import Tabel1 from "../../tabel/tabel1";
import {Link} from "react-router-dom";
import PropTypes from "prop-types";

function SelectDataUtama({ dt, ind, updDataBidang }) {
    const dispatch = useDispatch();
    const [search, setSearch] = useInput('');
    const [index, setindex] = useState(0);

    const [selDinas, setselDinas] = useState({ label: dt[ind].nmDinas, value: dt[ind].kdDinas });
    const [selBidang, setselBidang] = useState({
        label: (dt[ind].bidang!=undefined && dt[ind].bidang.length>0 && dt[ind].bidang[index].nmBidang),
        value: (dt[ind].bidang!=undefined && dt[ind].bidang.length>0 && dt[ind].bidang[index].kdBidang)
    });

    function selectDinas(data) {
        const i =dt.findIndex((val)=> val.kdDinas === data.value);
        setselDinas(data);
        updDataBidang({
            ind : i,
            kdDinas: data.value
        });
    }
    function selectBidang(data) {
        const i =dt[ind].bidang.findIndex((val)=> val.kdDBidang === data.value);
        setselBidang(data);
        setindex(i);
        // setindex_1(0);
        dispatch(getDataSubBidang({
            ind,
            index:i,
            kdDinas:dt[ind].kdDinas,
            kdBidang:data.value
        }));
    }
    function selectSub(kdSub) {
        const i =dt[ind].bidang[index].sub.findIndex((val)=> val.kdSub === kdSub);
        dispatch(getDataUraianSub({
            ind,
            index,
            index_1:i,
            kdDinas:dt[ind].kdDinas,
            kdBidang:dt[ind].bidang[index].kdDBidang,
            kdSub,
            act: 'added'
        }));
        return (<></>);
    }
    const coll = [...colRincianTw,
        {
            cell:(v) =>getLink(v),
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            width: '150px'
        }
    ];
    const getLink=(v)=>{ 
        switch (v.kdJenis) {
            case 'jp-1':
                return (
                    <Link to={`/home/work/sppd/${btoa(JSON.stringify({
                        kdDinas: v.kdDinas,
                        kdBidang: v.kdBidang,
                        kdSub: v.kdSub,
                        kdJudul: v.kdJudul
                    }))}`} >
                        <button className="btn2 cprimary" title="SPPD">Realisasikan</button>
                    </Link>
                );
            case 'jp-3':
                return (
                    <Link to={`/home/work/ta/${btoa(JSON.stringify({
                        kdDinas: v.kdDinas,
                        kdBidang: v.kdBidang,
                        kdSub: v.kdSub,
                        kdJudul: v.kdJudul
                    }))}`} >
                        <button className="btn2 cprimary" title="Tenaga Ahli">Realisasikan</button>
                    </Link>
                );
            default:
                break;
        }
    }
    return (
        <div class="FM1 ">
            <div class="header">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Rincian Belanja SPJ</b> 
                    </h2>
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px" }}><br/>
                <div className="jcE pwrap-10">
                    <div className="w45p labelInput2">
                        <label className="mw100px">Dinas</label>
                        <Select
                            className="cdark"
                            options={sfLib.coptionSelect({
                                dt,
                                row:{label:'nmDinas',value:'kdDinas'},
                                // xind:true
                            })}
                            placeholder="Select Dinas"
                            value={selDinas}
                            onChange={selectDinas}
                            isSearchable={true}
                        />
                    </div>
                </div>
                <div className="jcE pwrap-10">
                    <div className="w45p labelInput2">
                            <label className="mw100px">Bidang</label>
                            <Select
                                className="cdark"
                                options={sfLib.coptionSelect({
                                    dt : dt[ind].bidang,
                                    row:{label:'nmBidang',value:'kdDBidang'},
                                    // xind:true
                                })}
                                placeholder="Select Bidang"
                                value={selBidang}
                                onChange={selectBidang}
                                isSearchable={true}
                            />
                        </div>
                    </div>
                    <hr className="opa2"></hr>
                    {
                        (
                            dt[ind].bidang[index].sub !== undefined &&
                            <Tabel1
                                search={search}
                                oncSearch={setSearch}
                                columns={colSub}
                                data={dt[ind].bidang[index].sub.filter((item) => {
                                        if (search === "") {
                                            return item;
                                        } else if (
                                            item.nmSub.toLowerCase().includes(search.toLowerCase())
                                        ) {
                                            return item;
                                        }
                                    })}
                                ExpandedComponent={({ data })=>{
                                    return (
                                        (
                                            data.rincian === undefined  || data.rincian.length==0?
                                            (
                                                data.rincian === undefined ?
                                                selectSub(data.kdSub) :
                                                <div className="jcC pwrap-10">
                                                    <b>Sub ini tidak memiliki rincian belanja</b>
                                                </div>
                                            ) :
                                            <div className="mtb10px">
                                                <div className="w90p m0auto">
                                                    <Tabel1
                                                        columns={coll}
                                                        data={data.rincian.map(v=>{
                                                            return {
                                                                ...v,
                                                                kdDinas: data.kdDinas,
                                                                kdBidang: data.kdBidang,
                                                                kdSub: data.kdSub,
                                                            }
                                                        })}
                                                    ></Tabel1>
                                                </div>
                                            </div>
                                        )
                                    )
                                }}
                            ></Tabel1>
                        )
                    } 
            </div>
        </div>
    );  
}

SelectDataUtama.propTypes = {
    dt : PropTypes.array.isRequired,
    ind : PropTypes.number.isRequired,
    updDataBidang : PropTypes.func.isRequired
}
export default SelectDataUtama;

