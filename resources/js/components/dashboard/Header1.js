import React, { useEffect, version }  from "react";
import { useDispatch, useSelector } from 'react-redux';
import { setLeftBar } from '../../states/sfHtml/action';
import { logout, changeMenu } from '../../states/sfHtml/action';
import {Link} from "react-router-dom";

const icon = [
    {ic : <span className="mdi mdi-database cwarning fz25"></span>, url : ''},
    {ic : <span className="mdi mdi-file-document-edit csuccess fz25"></span>, url : ''},
    {ic : <span className="mdi mdi-file-document csuccess fz25"></span>, url : ''}
]
function HeaderM() {
    icon.forEach
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
    return (
        <header id="mfc2" className="posRelative">
            <div className="header ">
                <div className="flexR algI pwrap">
                    <img src={_html.url+'/logo/ksb.png'} />
                    <div className="flex clight ">
                        <h2>BAPPEDA</h2>
                        <p>Badan Perencanaan Pembangunan Daerah</p>
                        <p>Sumbawa Barat</p>
                    </div>
                </div>
                <div className="algI">
                    {
                        (_html.leftBar?
                            <button className="btn2" id="menu" onClick={()=>onOffLeftBar(0)}><span className="mdi mdi-menu clight fziconS"></span></button>
                            :<button className="btn2" id="menu"  onClick={()=>onOffLeftBar(1)}><span className="mdi mdi-close clight fziconS"></span></button>
                        )
                    }

                </div>
            </div>
            <div className="body w95p">
                <div className="btnGroup">
                    <span className="mdi mdi-web cdark mdi-spin bwarning mdiLeftGroup"></span>
                    <button className="btn2">SIPJ</button>
                </div>
                <div className="navbar updGrid2to3">
                    {
                        _html.menu.map((v,i)=>{
                            return (
                                <Link className="menu" key={`menus${i}`} to={setUrlMenu(i)} onClick={()=>updMenu(setUrlMenu(i))}>
                                    {icon[i].ic}
                                    <span className={` titmenu ${(_html.indMenu === i && 'cprimary fbold')}`}>{v.nm}</span>
                                </Link>
                            )
                        })
                    }
                </div>
                <div className="user">
                    <button className="btn1 cdark" onClick={exeLogout}>
                        <span className="mdi mdi-logout cdanger fz25"></span>
                        Logout
                    </button>
                </div>
            </div>
        </header>
    );
};

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
