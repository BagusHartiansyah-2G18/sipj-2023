import React from "react";
import { useDispatch, useSelector } from 'react-redux';
import { setLeftBar } from '../../states/sfHtml/action';
import { logout, changeMenu } from '../../states/sfHtml/action';
import {Link} from "react-router-dom";

const icon = [
    {ic : <span className="mdi mdi-database cwarning fzXl"></span>, url : ''},
    {ic : <span className="mdi mdi-file-document-edit csuccess fz25"></span>, url : ''},
    {ic : <span className="mdi mdi-file-document csuccess fz25"></span>, url : ''}
]
function HeaderM() {
    const { _html } = useSelector((state) => state);
    const dispatch = useDispatch();
    const onOffLeftBar = (v) =>{
        dispatch(setLeftBar(v));
    }
    const exeLogout=()=>{
        dispatch(logout());
    }
    const updMenu = (v) =>{
        dispatch(changeMenu(v))
    }
    // <div className="Info">
        
    //     {
    //         (_html.leftBar?
    //             <button className="btn2" id="menu" onClick={()=>onOffLeftBar(0)}><span className="mdi mdi-menu clight fziconS"></span></button>
    //             :<button className="btn2" id="menu"  onClick={()=>onOffLeftBar(1)}><span className="mdi mdi-close clight fziconS"></span></button>
    //         )
    //     }

    // </div>
    return (
        <header  className="MDheader pwrap_5 bsuccess3 stickyHeader">
            <div className="Iapp">
                <img src={_html.url+'/logo/ksb.png'} /> 
                <div className="fPoppins flexC asC ">
                    <h2 className="pm0 fzJapp ">SIPJ</h2> 
                    <p className="pm0 fzSapp fpacifico">BAPPEDA</p>
                </div> 
            </div>
            <div className="menu">
                {
                    _html.menu.map((v,i)=>{
                        return (
                            <Link  key={`menus${i}`} to={setUrlMenu(i)} onClick={()=>updMenu(setUrlMenu(i))}>
                                {icon[i].ic}
                                <span className={`  ${(_html.indMenu === i ? ' cwhite fbold':' csuccess ')}`}>{v.nm}</span>
                            </Link>
                        )
                    })
                }
            </div>
            <div className="Info"> 
                <div className="btnGroup">
                    {/* <button className="btn bnone cdark" onClick={exeLogout}>
                        <span className="mdi mdi-logout cdanger fz25"></span> 
                    </button> */}
                    <button className="btn bdark" onClick={exeLogout}>
                        <span className="mdi mdi-logout cdanger fzL2"></span>  
                    </button>
                </div>
            </div>
        </header>
    );
}

export default HeaderM;

function setUrlMenu(ind){
    switch (ind) {
        // case 0:
        //     return `/home/dashboard`;
        case 1:
            return `/home/work/subBidang`;
        default:
            return `/home/dashboard`;
    }

}
