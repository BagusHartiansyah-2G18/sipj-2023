import React from "react";
import PropTypes from "prop-types";

function HeaderPage1({page,pageKet,icon}){
    return (
        <div className="headerPage1">
            <div className="title">
                <span className={`mdi ${icon} bwhite fz25`}></span>
                <div className="page">
                    <h2>{page}</h2>
                    <span>{pageKet}</span>
                </div>
            </div>
            {/* <div className="btnGroup">
                <button className="btn2">31 Hari</button>
                <button className="btn2">5 jam</button>
                <button className="btn2">45 menit</button>
            </div> */}
        </div>
    )
}
HeaderPage1.propTypes ={
    page : PropTypes.string.isRequired,
    pageKet : PropTypes.string.isRequired,
    icon : PropTypes.string.isRequired,
}
export default HeaderPage1;
