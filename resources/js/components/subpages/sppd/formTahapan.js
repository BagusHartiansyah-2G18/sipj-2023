import React from "react";
import PropTypes from "prop-types";


function FormTahapan({ dt, setview }) {
    return (
        <div className="form0 bwhite">
            <div className="ribbon ribbon-center ribbon-success">
                <span className="bsuccess fbold">Informasi Perjalanan Dinas</span>
            </div>
            <div className="">
                {/* style={{listStyle:"none"}} */}
                <div className="flexR3 pwrap">
                    <ul>
                        <li className="ptb10px">
                            <label className="fbold">No SPPD</label><br></br>
                            <span>{dt.no}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Tujuan</label><br></br>
                            <span>{dt.tempatE}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Tanggal</label><br></br>
                            <span>{dt.date} - {dt.dateE}</span>
                        </li>
                    </ul>
                    <ul>
                        <li className="ptb10px">
                            <label className="fbold">Maksud Perjalanan</label><br></br>
                            <span>{dt.maksud}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Lokasi</label><br></br>
                            <span>{dt.lokasi}</span>
                        </li>
                        <li className="ptb10px">
                            <label className="fbold">Anggaran</label><br></br>
                            <span>{dt.anggaran}</span>
                        </li>
                    </ul>
                </div>

                {/* <div className="flexR justifySA ptb10px">
                    <button className="btn6 bwarning cdark">
                        <span className="mdi mdi-office-building-marker  fziconM "></span>
                        <label className="">Nomor <br/> {dt.no}</label>
                    </button>
                    <button className="btn6 bprimary cwhite">
                        <span className="mdi mdi-office-building-marker fziconM "></span>
                        <label className="">Tujuan <br/> {dt.tujuan}</label>
                    </button>
                    <button className="btn6 binfo cdark ">
                        <span className="mdi mdi-office-building-marker cwarning fziconM "></span>
                        <label className="clight">Tanggal <br/> {dt.date}</label>
                    </button>
                </div> */}
                <div className="pwrap binfo borderR10px">
                    <div className="mh50p"></div>
                    <div className="galeryList bwhite">
                        <div className="item blight unselect borderpurpleT5px">
                            <span className="mdi mdi-circle-slice-2 cdark binfo fziconS"></span>
                            <h2 className="judul">Dasar SPPD</h2>
                            <button className="btn2 binfo clight justifyC fz20 mw150px" onClick={()=>setview(1)} >
                                {
                                    ( dt.dasar!='' && dt.fileD!='' ? 'Finish':'view')
                                }
                            </button>
                        </div>
                        <div className="item blight select borderpurpleB5px">
                            <span className="mdi mdi-circle-slice-4 cdark binfo fziconS"></span>
                            <h2 className="judul">Pilih Pegawai</h2>
                            <button className="btn2 binfo clight justifyC fz20 mw150px" onClick={()=>setview(2)}>
                                {
                                    (
                                        dt.anggota != undefined &&
                                        dt.anggota.filter(v=>v.xind!=undefined).length>0 ?
                                        'Finish':'view'
                                    )
                                }

                            </button>
                        </div>
                        <div className="item blight borderpurpleT5px borderpurpleB5px">
                            <span className="mdi mdi-circle-slice-5 cdark binfo fziconS"></span>
                            <h2 className="judul">Kwitansi</h2>
                            <button className="btn2 binfo clight justifyC fz20 mw150px" onClick={()=>setview(3)}>view</button>
                        </div>
                        <div className="item blight unselect borderpurpleT5px">
                            <span className="mdi mdi-circle-slice-7 cdark binfo fziconS"></span>
                            <h2 className="judul">Progres Dokumen</h2>
                            <button className="btn2 binfo clight justifyC fz20 mw150px" onClick={()=>setview(4)}>view</button>
                        </div>
                        <div className="item blight select borderpurpleB5px">
                            <span className="mdi mdi-circle-slice-8 cdark binfo fziconS"></span>
                            <h2 className="judul">Finish</h2>
                            <button className="btn2 binfo clight justifyC fz20 mw150px" onClick={()=>setview(5)}>view</button>
                        </div>
                    </div>
                    <div className="mh50p"></div>
                </div>
            </div>
        </div>
    );
}

FormTahapan.propTypes = {
    dt : PropTypes.object.isRequired,
    setview: PropTypes.func.isRequired
}
export default FormTahapan;
