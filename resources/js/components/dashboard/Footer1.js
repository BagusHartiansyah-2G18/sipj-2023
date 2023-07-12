import React from "react"
function Footer1({text,cbg ='hheader w100p bdark', cicon='bdanger cwhite'}){
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
export default Footer1;