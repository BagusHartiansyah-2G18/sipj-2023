import React from "react";
import { useInput } from '../../../../hooks/useInput';
import PropTypes from "prop-types";

function FormNoSppd( { updNomorSppd, ind, dt } ){
    const [noSppd, setnoSppd] = useInput((dt.noSPPD !=undefined ? dt.noSPPD:''));

    return (
        <div className="ptb10px">
            <div className=" flexR justifySB">
                <button className="btn7 ">
                    <span className="mdi mdi-login binfo clight fziconS"></span>
                    <h2 className="cdark">Nomor SPPD</h2>
                </button>
            </div>
            <div className="ptb10px">
                <div className="body w95p m0auto  borderR10px">
                <div className="flexR justifySB">
                    <div className="flexC w80p">
                        <div className="labelInput2 ptb10px">
                            <label className=""><span className={`mdi mdi-cloud-search cprimary `}></span>Nomor</label>
                            <input className="borderR10px" type="text" value={noSppd} onChange={setnoSppd} placeholder="Nomor" />
                        </div>
                    </div>
                    <div className="flexC w20p ptb10px ">
                        <div className="btnGroup posEnd">
                            <button className="btn2 bsuccess"
                                title="Simpan"
                                onClick={()=>updNomorSppd({ind,noSppd})}>
                                <span className="mdi  mdi-check-circle clight fz25" />
                            </button>
                        </div>
                    </div>
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
