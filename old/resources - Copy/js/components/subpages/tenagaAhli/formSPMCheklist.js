import React from "react";
import {newTab } from '../../../states/sfHtml/action';
import { useInput } from '../../../hooks/useInput';

function TAformSPMCheckList({ mclose, checkList}){
    const [noSPM, _noSPM] = useInput('');
    const [nilai, _nilai] = useInput('');

    return (
        <div className="form1 bwhite">
            <div className={`header bsuccess`}>
                <h3>Form Cetak Check List SPM</h3>
                <div className="btnGroup">
                    <button className="btn2 bdark clight" onClick={mclose}>Close</button>
                </div>
            </div>
            <div className="body  ptb10px">
                <div className="flexC mlr10px ">
                    <label className=""><span className={`mdi mdi-cloud-search cprimary `}></span>Nomor / TGL SPM</label>
                    <input className="borderR10px w90p" type="text" value={noSPM} onChange={_noSPM} placeholder="52.07/03.0 ..../ 04 Juni 2024" />
                </div>
                <br/>
                <div className="flexC mlr10px ">
                    <label className=""><span className={`mdi mdi-cloud-search cprimary `}></span>Nilai SPM</label>
                    <input className="borderR10px w90p" type="text" value={nilai} onChange={_nilai} placeholder="5.000.000" />
                </div>
                <hr/>
                <div className="flexC w90p ptb10px ">
                        <div className="btnGroup posEnd">
                            <button className="btn2 bsuccess"
                                title="Simpan"
                                onClick={()=>newTab('dspj/checkListSPM/'+btoa(JSON.stringify({ noSPM, nilai,...checkList })))}>
                                Preview Dokumen
                            </button>
                        </div>
                    </div>
            </div>
        </div>
        
    );
}
export default TAformSPMCheckList;