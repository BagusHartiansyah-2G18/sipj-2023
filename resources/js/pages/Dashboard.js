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
        <div className="Mcontainer">
            <div className="body pm0">
                <h2>Dashboard page</h2>
                <button onClick={testModal}>modal show</button>
                 
                
            </div>
        </div>
    );
}
export default Dashboard;
