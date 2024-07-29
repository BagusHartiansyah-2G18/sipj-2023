import React from "react";
import PropTypes from "prop-types";


function FormTahapan({ dt, view, setview }) { 
    return (
        <div class="FM1 ">
            <div class="header">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Informasi</b> 
                    </h2>
                </div> 
                <div class="btnGroup">
                    <button class={"btn2  "+ (view ==1 ? 'bsuccess3':'')} onClick={()=>setview(1)}><b>Dasar SPPD</b></button>
                    <button class={"btn2  "+ (view ==2 ? 'bsuccess3':'')} onClick={()=>setview(2)}><b>Pemilihan Pegawai</b></button>
                    <button class={"btn2  "+ (view ==3 ? 'bsuccess3':'')} onClick={()=>setview(3)}><b>Verifikasi Data</b></button>
                    <button class={"btn2  "+ (view ==4 ? 'bsuccess3':'')} onClick={()=>setview(4)}><b>Dokumen</b></button> 
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1 grid-col3" style={{width:"unset"}}><br/>
             
            </div>
        </div>  
    );
}

FormTahapan.propTypes = {
    dt : PropTypes.object.isRequired,
    setview: PropTypes.func.isRequired
}
export default FormTahapan;
