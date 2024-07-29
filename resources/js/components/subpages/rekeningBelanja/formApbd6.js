import React from "react";

import { colAbpd6 } from '../../../states/rekeningB/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import PropTypes from "prop-types";

function FormApbd6({ dt, selectSub }) {
    const [search, setSearch] = useInput('');
    return (
        <div class="FM1 ">
            <div class="header bwhite">
                <div class="cdark flexR">
                    <button className="btn bdark">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>List Rekening</b> 
                    </h2>
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1 " style={{width:"unset",borderRadius:"0px" }}><br/>
                <div className=" ">
                    <Tabel1
                        search={search}
                        oncSearch={setSearch}
                        columns={colAbpd6}
                        selectData={selectSub}
                        data={dt.filter((item) => {
                                    if (search === "") {
                                        return item;
                                    } else if (
                                        item.nmApbd6.toLowerCase().includes(search.toLowerCase())
                                    ) {
                                        return item;
                                    }
                                }
                            )}
                    ></Tabel1>
                </div>
            </div>
        </div>
         
    );
}
FormApbd6.propTypes = {
    dt : PropTypes.object.isRequired,
    selectSub: PropTypes.func.isRequired
}
export default FormApbd6;
