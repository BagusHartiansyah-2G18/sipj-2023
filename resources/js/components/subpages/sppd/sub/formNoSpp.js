import React from "react";
import { useInput } from '../../../../hooks/useInput';
import PropTypes from "prop-types";

function FormNoSppd( { updNomorSppd, ind, dt, start } ){ 
    const [noSppd, setnoSppd] = useInput();
    if(start.start){
        start.start=false; 
        setnoSppd({target:{
            value:(dt.noSPPD !=undefined && dt.noSPPD !=null ? dt.noSPPD:'') 
        }})
        
    }

    return (
        <div className="ptb10px">
            <div className="flexR jcSB">
                <button className="btn7">
                    <span className="mdi mdi-login binfo clight fziconS"></span>
                    <h2 className="cdark">Nomor SPPD</h2>
                </button>
            </div>
            <div className="ptb10px">
                <div className="body w95p m0auto bdashed1">
                    <div className="flexR jcSB aiC">
                        <div className="labelInput2">
                            <label><span className={`mdi mdi-cloud-search cprimary `}></span>Nomor</label>
                            <input className="borderR10px" type="text" value={noSppd} onChange={setnoSppd} placeholder="Nomor" />
                        </div>
                        <button className="btn2 bsuccess"
                            title="Simpan"
                            onClick={()=>updNomorSppd({ind,noSppd})}>
                            <span className="mdi  mdi-check-circle clight fzXl" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
FormNoSppd.propTypes = {
    dt : PropTypes.object.isRequired,
    updNomorSppd : PropTypes.func.isRequired,
    ind : PropTypes.number.isRequired
}
export default FormNoSppd;
