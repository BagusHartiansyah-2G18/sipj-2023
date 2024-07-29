import React from "react";
function TAlistStaf({ dstaf, ondel }){
    return dstaf.map((v,i)=>{ 
        return (
            <div key={i} className="flexR justifySB" style={{alignItems:"center"}}>
                <label>{(i+1)+". "+v[0].label}</label>
                <button className="btn2 bdanger" onClick={()=>ondel(i)}> Batalkan</button>
            </div>
        )
    });
    return <>Bagus H</>
}
export default TAlistStaf;