import React, { useEffect } from "react";
import { useDispatch, useSelector } from 'react-redux';
import { setLeftBar } from '../../states/sfHtml/action';
import {Link} from "react-router-dom";
import { changeMenuSub } from '../../states/sfHtml/action';

function Navbar() {
    const { _html } = useSelector((state) => state);
    const dispatch = useDispatch();
    const sess = _html.sess;
    function selectMenuSub({menuSub}){
        dispatch(changeMenuSub({menuSub}))
    }
    return (
        <div className={`w20p ${_html.leftBar && 'dnone'} `}>
            <div className="leftBar2" id="liftBar2">
                <div className="icon">
                    <img src={`${_html.url}/logo/boy.png`}/>
                    <h2 className="">Bagus Hartiansyah</h2>
                    <span className="">Staff PPID</span>
                </div>
                <ul>
                    {
                        (
                            _html.indMenu === 0 &&
                            <>
                                <li>
                                    <Link to={`/home/dashboard`} onClick={()=> selectMenuSub({menuSub:'dashboard'})}>
                                        <label className={actSubMenu('dashboard',_html.menuSub)}>Dashboard</label>
                                        <span className="mdi mdi-calendar cdark fz25"></span>
                                    </Link>
                                </li>
                                { (sess.kdJaba !== '3' &&
                                    <>
                                        <li>
                                            <Link to={`/home/member`}>
                                                <label>Member</label>
                                                <span className="mdi mdi-account cdark fz25"></span>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link to={`/home/dinas`} onClick={()=> selectMenuSub({menuSub:'dinas'})}>
                                                <label className={actSubMenu('dinas',_html.menuSub)}>Dinas</label>
                                                <span className="mdi mdi-office-building-marker fz25 cdark"></span>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link to={`/home/rekeningBelanja`} onClick={()=> selectMenuSub({menuSub:'rekeningBelanja'})}>
                                                <label className={actSubMenu('rekeningBelanja',_html.menuSub)}>Rekening Belanja</label>
                                                <span className="mdi mdi-account cdark fz25"></span>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link to={`/home/jenisP`} onClick={()=> selectMenuSub({menuSub:'jenisP'})}>
                                                <label className={actSubMenu('jenisP',_html.menuSub)}>Jenis PJ</label>
                                                <span className="mdi mdi-chart-bar cdark fz25"></span>
                                            </Link>
                                        </li>
                                    </>
                                )}
                                <li>
                                    <Link to={`/home/subkegiatan`} onClick={()=> selectMenuSub({menuSub:'subkegiatan'})}>
                                        <label className={actSubMenu('subkegiatan',_html.menuSub)}>Sub Kegiatan</label>
                                        <span className="mdi mdi-office-building-cog-outline fz25 cdark"></span>
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
                                    <Link to={`/home/work/subBidang`} onClick={()=> selectMenuSub({menuSub:'subBidang'})}>
                                        <label className={actSubMenu('subBidang',_html.menuSub)}>Sub Bidang</label>
                                        <span className="mdi mdi-account cdark fz25"></span>
                                    </Link>
                                </li>
                                <li>
                                    <Link to={`/home/work/rincianBelanja`} onClick={()=> selectMenuSub({menuSub:'rincianBelanja'})}>
                                        <label className={actSubMenu('rincianBelanja',_html.menuSub)}>Rincian Belanja</label>
                                        <span className="mdi mdi-account cdark fz25"></span>
                                    </Link>
                                </li>
                                <li>
                                    <Link to={`/home/work/fitur`} onClick={()=> selectMenuSub({menuSub:'fitur'})}>
                                        <label className={actSubMenu('fitur',_html.menuSub)}>Fitur</label>
                                        <span className="mdi mdi-account cdark fz25"></span>
                                    </Link>
                                </li>
                                {/* {
                                    (
                                        sess.kdJaba === '3' &&
                                        _html.menu[_html.indMenu].menu.map((v,i) => {
                                            const xnm = String(v.nmJPJ).toLowerCase().replace(/\s/g, '');
                                            return (
                                                <li key={`subMenu`+i} onClick={()=> selectMenuSub({menuSub:xnm})}>
                                                    <Link to={`/home/work/`+xnm}>
                                                        <label className={actSubMenu(xnm,_html.menuSub)}>{v.nmJPJ}</label>
                                                        <span className={`mdi ${ getIcon(xnm)} cdark fz25`}></span>
                                                    </Link>
                                                </li>
                                            )
                                        })
                                    )
                                } */}
                            </>
                        )
                    }


                </ul>
            </div>
        </div>
    );
};

export default Navbar;


function actSubMenu(menu,menuAct){
    // const pathname = window.location.pathname;
    if(menuAct === menu){
        return 'cprimary fbold';
    }
    return '';
}

function getIcon(xnm){
    switch (xnm) {
        case 'sppd':
            return `mdi-chart-bar`
        default:
            return `mdi-chart-bar`
    }
}
