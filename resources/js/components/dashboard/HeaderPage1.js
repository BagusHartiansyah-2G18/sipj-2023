import React from "react";
import PropTypes from "prop-types";

function HeaderPage1({page,pageKet,icon, menu=''}){
    return (
        <div className="box2C bdark">
            <div className="left aiC">
                <span className={`mdi  ${icon}  fzL4`}></span>
                <div className="">
                    <h2 className="pm0">{page}</h2>
                    <span>{pageKet}</span>
                </div>
            </div>
            {menu}
        </div>
    )
}
HeaderPage1.propTypes ={
    page : PropTypes.string.isRequired,
    pageKet : PropTypes.string.isRequired,
    icon : PropTypes.string.isRequired,
}
export default HeaderPage1;
