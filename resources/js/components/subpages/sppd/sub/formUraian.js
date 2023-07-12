import React from "react";
import { Form } from "react-router-dom";
import { useState } from 'react';
import { useInput } from '../../../../hooks/useInput'; 
import sfLib from "../../../mfc/sfLib"; 

function FormUraian( { dt , onUpded, onDeled, value } ){ 
    const [uraian, seturaian] = useInput((dt.uraian === '-' ? '' : dt.uraian));  
    const [volume, setvolume] = useInput(dt.volume);  
    const [satuan, setsatuan] = useInput((dt.satuan === '-' ? '' : dt.satuan));
    const [nilai, setnilai] = useInput(dt.nilai);
    const [total, settotal] = useState((dt.nilai === 0 || dt.volume === 0 ? 0 : dt.nilai*dt.volume ));

    const upded = () =>{
        console.log('sses');
        try {
            const hitung = (Number(volume)* Number(nilai))
            settotal(hitung);
        } catch (error) {
            
        }
    }

    return (
        <div className="ptb10px">
            <div className="body w95p m0auto  borderR10px">
                <div className="flexR justifySB">
                    <div className="flexC w80p">
                        <div className="iconInput2 ptb10px">
                            <input className="borderR10px" type="text" value={uraian} onChange={seturaian} placeholder="uraian" />
                            <span className={`mdi mdi-cloud-search cprimary `}></span>
                        </div>
                        <div className="flexR justifySB">
                            <div className="iconInput2 ptb10px">
                                <input className="borderR10px" type="number" value={volume} onChange={setvolume} onKeyUp={upded} placeholder="Volume" />
                                <span className={`mdi mdi-cloud-search cprimary `}></span>
                            </div>
                            <div className="iconInput2 ptb10px">
                                <input className="borderR10px" type="text" value={satuan} onChange={setsatuan} placeholder="Satuan" />
                                <span className={`mdi mdi-cloud-search cprimary `}></span>
                            </div>
                            <div className="iconInput2 ptb10px">
                                <input className="borderR10px" type="number" value={nilai} onChange={setnilai} onKeyUp={upded} placeholder="Nilai" />
                                <span className={`mdi mdi-cloud-search cprimary `}></span>
                            </div>
                        </div>
                    </div>        
                    <div className="flexC w20p ptb10px ">
                        <label className="pwrap">Total = Rp. <small>{sfLib._$(total)}</small></label>
                        <div className="btnGroup pwrap posEnd">
                            <button className="btn2 bsuccess" 
                                title="Simpan"
                                onClick={()=>{onUpded({
                                    ...value,
                                    uraian,
                                    volume,
                                    satuan,
                                    nilai 
                                })}}
                                >
                                <span className="mdi  mdi-check-circle clight fz25" />
                            </button> 
                            <button className="btn2 bdanger clight" 
                                title="Hapus"
                                onClick={()=>{onDeled(value)}}> 
                                <span className="mdi mdi-delete-forever clight fz25" />
                            </button> 
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    );
}
export default FormUraian;