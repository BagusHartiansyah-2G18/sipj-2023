import React from "react";
import { useDispatch } from 'react-redux';

import { setHtml  } from "../states/sfHtml/action";

function Dashboard() {
    const dispatch = useDispatch();


    const testModal=()=>{
        dispatch(
            setHtml({
                modal :true,
            })
        )
    }
    return (
        <div className="container">
            <div className="row justify-content-center mt-3">
                <div className="col-md-8">
                    <h2>Dashboard page</h2>
                    <button onClick={testModal}>modal show</button>
                </div>
            </div>
        </div>
    );
}
export default Dashboard;
