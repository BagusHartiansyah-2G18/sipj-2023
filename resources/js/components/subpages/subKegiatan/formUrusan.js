import React from "react";

import { colUrusan } from '../../../states/subKegiatan/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import sfLib from '../../mfc/sfLib';

function FormUrusan({dt}) {
    const [search, setSearch] = useInput(''); 
    return (
        <div className="form1 bwhite boxShadow1px">
            <div className="header bprimary clight">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3>Data Urusan Pemerintahan</h3>
                </div>
                <button className="btn2 blight cmuted">Entri</button>
            </div>
            <div className="body">  
                <Tabel1
                    search={search}
                    oncSearch={setSearch}
                    columns={colUrusan}
                    data={sfLib.objToCB({
                                dt,
                                label : ['nmUrusan','nmBidang','nmProg','nmKeg','nmSub'],
                                value :['kdUrusan','kdBidang','kdProg','kdKeg','kdSub']
                            }
                        ).filter((item) => {
                                if (search === "") {
                                    return item;
                                } else if (
                                    item.nmSub.toLowerCase().includes(search.toLowerCase())
                                ) {
                                    return item;
                                }
                            }
                        )}
                ></Tabel1>
            </div>
            {/* <div className="footer"></div> */}
        </div>
    );
}
export default FormUrusan;