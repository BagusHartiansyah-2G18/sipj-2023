import React from "react";
import sfLib from "../../mfc/sfLib";
import PropTypes from "prop-types";

function FormInformasi({dt}) {
    return (
        <div className="form1 bwhite boxShadow1px ">
                <div className="header bwarning">
                    <div className="icon">
                        <span className="mdi mdi-office-building-marker fz25 "></span>
                        <h3>Informasi</h3>
                    </div>
                </div>
                <div className="body">
                    <div className="flexR3">
                        <div>
                            <ul style={{listStyle:"none"}}>
                                <li className="ptb10px">
                                    <label className="fbold">Sub Kegiatan</label><br></br>
                                    <span>{dt.nmSub}</span>
                                </li>
                                <li className="ptb10px">
                                    <label className="fbold">Uraian Belanja</label><br></br>
                                    <span>{dt.nama}</span>
                                </li>
                                <li>
                                    <div className="flexR algI">
                                        <div className=" boxShadow1px bprimary justifyC  wkotakS algI">
                                            <span className="mdi mdi-cart cwhite  fziconS "></span>
                                        </div>
                                        <h3 className="pa">
                                            <label className="fbold">Sisa</label><br></br>
                                            <span>Rp.<small>{sfLib._$(dt.total-dt.realisasi)}</small></span>
                                        </h3>
                                    </div>

                                </li>
                                {/* <li className="ptb10px">
                                    <label className="fbold">Pagu Triwulan</label><br></br>
                                    <div className="flexR justifySE">
                                        <div>
                                            <label className="fbold">TW 1</label><br></br>
                                            <span>Rp.<small>{sfLib._$(dt.tw1)}</small></span>
                                        </div>
                                        <div>
                                            <label className="fbold">TW 2</label><br></br>
                                            <span>Rp.<small>{sfLib._$(dt.tw2)}</small></span>
                                        </div>
                                        <div>
                                            <label className="fbold">TW 3</label><br></br>
                                            <span>Rp.<small>{sfLib._$(dt.tw3)}</small></span>
                                        </div>
                                        <div>
                                            <label className="fbold">TW 3</label><br></br>
                                            <span>Rp.<small>{sfLib._$(dt.tw4)}</small></span>
                                        </div>
                                    </div>
                                </li> */}
                            </ul>
                        </div>
                        <div className="flexC justifySE">
                            <div className="flexR algI">
                                <div className=" boxShadow1px bsuccess justifyC rotasi45 wkotakS algI">
                                    <span className="mdi mdi-currency-usd cwhite rotasiM45 fziconS "></span>
                                </div>
                                <h3 className="pa">
                                    <label className="fbold">Alokasi</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.total)}</small></span>
                                </h3>
                            </div>
                            <div className="flexR algI">
                                <div className=" boxShadow1px bdanger justifyC rotasi45 wkotakS algI">
                                    <span className="mdi mdi-currency-usd-off cwhite rotasiM45 fziconS "></span>
                                </div>
                                <h3 className="pa">
                                    <label className="fbold">Realisasi</label><br></br>
                                    <span>Rp.<small>{sfLib._$(dt.realisasi)}</small></span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                {/* <div className="footer"></div> */}
            </div>
    );
}
FormInformasi.propTypes = {
    dt : PropTypes.object.isRequired,
}
export default FormInformasi;
