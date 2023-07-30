import React from "react";

import { colAbpd6 } from '../../../states/rekeningB/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";

function FormApbd6({ dt, selectSub }) {
    const [search, setSearch] = useInput('');
    return (
        <div className="form1 bwhite boxShadow1px w50p">
            <div className="header bprimary clight">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3>Data Rekening Belanja</h3>
                </div>
            </div>
            <div className="body">
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
            {/* <div className="footer"></div> */}
        </div>
    );
}
export default FormApbd6;
