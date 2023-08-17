import React from "react";
import PropTypes from "prop-types";

function Footer1({text, cbg ='hheader w100p bdark', cicon='bdanger cwhite'}){
    return (
        <footer className="w100p ">
            <div  id="copyRight">
                <div className="judulProject">
                    <span className={`mdi mdi-alpha-c-circle-outline ${cicon} `}></span>
                    <h2 className="bdanger clight">{text}</h2>
                </div>
            </div>
            <div className={cbg}></div>
        </footer>
    );
}

Footer1.propTypes = {
    text : PropTypes.string.isRequired,
    cbg : PropTypes.string.isRequired,
    cicon : PropTypes.string.isRequired,
}
export default Footer1;
