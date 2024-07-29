import React from "react";

import { colSub } from '../../../states/subKegiatan/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import PropTypes from "prop-types";

function FormSub({ dt, selectSub }) {
    const [search, setSearch] = useInput('');
    return (
        <div class="FM1 ">
            <div class="header ">
                <div class="cdark flexR">
                    <button className="btn bnone">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>Data Kegiatan</b> 
                    </h2>
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1" style={{width:"unset", borderRadius:"0px" }}><br/>
                <Tabel1
                    search={search}
                    oncSearch={setSearch}
                    columns={colSub}
                    selectData={selectSub}
                    data={dt.filter((item) => {
                            if (search === "") {
                                return item;
                            } else if (
                                item.nmSub.toLowerCase().includes(search.toLowerCase())
                            ) {
                                return item;
                            }
                        })}
                ></Tabel1>
            </div>
        </div> 
         
    );
}
FormSub.propTypes = {
    dt : PropTypes.object.isRequired,
    selectSub : PropTypes.func.isRequired,
}
export default FormSub;
