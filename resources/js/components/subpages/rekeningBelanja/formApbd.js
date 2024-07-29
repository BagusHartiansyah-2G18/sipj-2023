import React from "react";

import { colApbd } from '../../../states/rekeningB/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";

function FormApbd({dt}) {
    const [search, setSearch] = useInput('');
    return (
        <div class="FM1 ">
            <div class="header bwhite">
                <div class="cdark flexR">
                    <button className="btn bdark">
                        <span className="mdi mdi-star-crescent cwarning fzXl"></span>
                    </button>
                    <h2 className="  pl0 aiE fBebasNeue">
                        <b>List Turunan Rekening</b> 
                    </h2>
                </div> 
            </div>
            <div class="body bdark pm0 bsolid1 " style={{width:"unset", borderRadius:"0px"}}><br/>
                <div className=" ">
                    <Tabel1
                        search={search}
                        oncSearch={setSearch}
                        columns={colApbd}
                        onOffSearch={false}
                        data={sfLib.objToCB({
                                    dt,
                                    label : ['nmApbd1','nmApbd2','nmApbd3','nmApbd4','nmApbd5','nmApbd6'],
                                    value :['kdApbd1','kdApbd2','kdApbd3','kdApbd4','kdApbd5','kdApbd6']
                                }
                            ).filter((item) => {
                                    if (search === "") {
                                        return item;
                                    } else if (
                                        item.label.toLowerCase().includes(search.toLowerCase())
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

FormApbd.propTypes = {
    dt : PropTypes.object.isRequired
}
export default FormApbd;
