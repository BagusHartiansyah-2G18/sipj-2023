import React,{ useState } from "react";
import { useDispatch, useSelector } from 'react-redux';
import {Link} from "react-router-dom";
import { changeMenuSub } from '../../states/sfHtml/action';

function Navbar() {
    const { _html } = useSelector((state) => state);
    const dispatch = useDispatch();
    const sess = _html.sess;
    const [on,_on] = useState(0);
    function selectMenuSub({menuSub}){ 
        dispatch(changeMenuSub({menuSub}))
    }
    const logs=(v)=>{
       _on(!on);
    } 
    return (
        <div>
            <button  id="keyOnOffed" className={(on?'OnBtn':'')} onClick={logs}><span className="arrow"></span></button>
            <input type="checkbox" id="keyOnOff" aria-hidden="true" checked={on} style={{display:"none"}}></input>  
            <div id="MDCnav" className="bdark ">  
                <div className="content">
                    <div className="user">
                        <img src={`${_html.url}/logo/boy.png`}/>
                        <div className="flexC asC ">
                            <label>Bagus Hartiansyah</label>
                            <span className="fpacifico">Staff PPID</span>
                        </div>
                    </div> 
                    <ul className="ul-menu1 jcS " style={{flexDirection:"column"}}> 
                        {
                            (
                                _html.indMenu === 0 &&
                                <>
                                    <li>
                                        <Link to={`/home/dashboard`} className={actSubMenu('dashboard',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'dashboard'})}> 
                                            <span className="mdi mdi-calendar fzXl"></span>
                                            <label >Dashboard</label>
                                        </Link>
                                    </li>
                                    { (sess.kdJaba !== '1' &&
                                        <>
                                            <li>
                                                <Link to={`/home/member`} className={actSubMenu('member',_html.menuSub)}> 
                                                    <span className="mdi mdi-account fzXl"></span>
                                                    <label>Member</label>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link to={`/home/dinas`} className={actSubMenu('dinas',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'dinas'})}> 
                                                    <span className="mdi mdi-office-building-marker fzXl"></span>
                                                    <label >Dinas</label>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link to={`/home/rekeningBelanja`} className={actSubMenu('rekeningBelanja',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'rekeningBelanja'})}>
                                                    <span className="mdi mdi-account fzXl"></span>
                                                    <label >Rekening Belanja</label>
                                                </Link>
                                            </li>
                                            <li>
                                                <Link to={`/home/jenisP`} className={actSubMenu('jenisP',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'jenisP'})}>
                                                    <span className="mdi mdi-chart-bar fzXl"></span>
                                                    <label >Jenis PJ</label>
                                                </Link>
                                            </li>
                                        </>
                                    )}
                                    <li>
                                        <Link to={`/home/subkegiatan`} className={actSubMenu('subkegiatan',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'subkegiatan'})}>
                                            <span className="mdi mdi-office-building-cog-outline fzXl "></span>
                                            <label >Sub Kegiatan</label>
                                        </Link>
                                    </li>
                                </>
                            )
                        }
                        {

                            (
                                _html.indMenu === 1 &&
                                <>
                                    <li>
                                        <Link to={`/home/work/subBidang`} className={actSubMenu('subBidang',_html.menuSub)}onClick={()=> selectMenuSub({menuSub:'subBidang'})}>
                                            <span className="mdi mdi-account fzXl"></span>
                                            <label >Sub Bidang</label>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to={`/home/work/rincianBelanja`} className={actSubMenu('rincianBelanja',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'rincianBelanja'})}>
                                            <span className="mdi mdi-account fzXl"></span>
                                            <label >Rincian Belanja</label>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to={`/home/work/fitur`} className={actSubMenu('fitur',_html.menuSub)} onClick={()=> selectMenuSub({menuSub:'fitur'})}>
                                            <span className="mdi mdi-account fzXl"></span>
                                            <label >SPJ</label>
                                        </Link>
                                    </li> 
                                </>
                            )
                        }


                    </ul>
                </div>
            </div>
           
        </div>
       
    );
}

export default Navbar;


function actSubMenu(menu,menuAct){
    // const pathname = window.location.pathname;
    if(menuAct === menu){
        return 'cwhite fbold ';
    }
    return 'csuccess';
}


