import React from "react";
import { useDispatch, useSelector } from 'react-redux';

import { setAll, setHtml  } from "../states/sfHtml/action";

import Modal1 from "../components/Modal/modal1";

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