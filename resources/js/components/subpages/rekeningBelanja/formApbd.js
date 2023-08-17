import React from "react";

import { colApbd } from '../../../states/rekeningB/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";
import sfLib from '../../mfc/sfLib';
import PropTypes from "prop-types";

function FormApbd({dt}) {
    const [search, setSearch] = useInput('');
    return (
        <div className="form1 bwhite boxShadow1px w40p hmax">
            <div className="header bprimary clight">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3>Daftar Induk Rekening</h3>
                </div>
            </div>
            <div className="body">
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
            {/* <div className="footer"></div> */}
        </div>
    );
}

FormApbd.propTypes = {
    dt : PropTypes.object.isRequired
}
export default FormApbd;
