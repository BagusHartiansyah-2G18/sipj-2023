import React from "react";

import { colUrusan } from '../../../states/subKegiatan/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";

function FormUrusan({dt}) {
    const [search, setSearch] = useInput('');
    return (
        <div class="FM1 ">
            <div class="header ">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Data Urusan Pemerintahan</b> 
                    </h2>
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1" style={{width:"unset", borderRadius:"0px" }}><br/>
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
        </div> 
    );
}
FormUrusan.propTypes = {
    dt : PropTypes.object.isRequired,
}
export default FormUrusan;
