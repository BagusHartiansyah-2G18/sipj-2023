import React from "react";

import { colSub,colUrusan } from '../../../states/subKegiatan/action';
import { useInput } from '../../../hooks/useInput';
import Tabel1 from "../../tabel/tabel1";

function FormSub({ dt, selectSub }) {
    const [search, setSearch] = useInput('');
    return (
        <div className="form1 bwhite boxShadow1px">
            <div className="header bprimary clight">
                <div className="icon">
                    <span className="mdi mdi-office-building-marker fz25 "></span>
                    <h3>Data Sub Kegiatan</h3>
                </div>
            </div>
            <div className="body">
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
            {/* <div className="footer"></div> */}
        </div>
    );
}
export default FormSub;
