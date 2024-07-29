import React from "react";
export default function FormInfoSpppd({ dt }){ 
    return (
        <div className=" ">
            <div className="Flex-b45p jcSB">
                <div class="list flexR  aiC">
                    <span class="mdi mdi-numeric-0-box-multiple csuccess3  fzL2 "> </span>
                    <h3 class="pwrap_10">
                        <small>No</small><br/>
                        <span className="tbold">{dt.no} </span>
                    </h3>
                </div> 
                <div class="list flexR aiC jcE">
                    <h3 class="pwrap_10">
                        <small>Tujuan</small><br/>
                        <span className="tbold">{dt.tempatE}</span>
                    </h3>
                    <span class="mdi mdi-home-export-outline csuccess3  fzL2 "> </span>
                </div>  
            </div>
            <div className="Flex-b45p jcSB"> 
                <div class="list flexR   aiC">
                    <span class="mdi mdi-home csuccess3  fzL2 "> </span>
                    <h3 class="pwrap_10">
                        <small>Tempat Kegiatan</small><br/>
                        <span className="tbold">{dt.lokasi}</span>
                    </h3>
                </div> 
                <div class="list flexR   aiC jcE">
                    <h3 class="pwrap_10">
                        <small>Status</small><br/>
                        <span className="tbold">{dt.status} </span>
                    </h3>
                    <span class="mdi mdi-lightbulb-question csuccess3  fzL2 "> </span>
                </div>  
            </div>
            <div className="Flex-b45p jcSB"> 
                <div class="list flexR  aiC">
                    <span class="mdi mdi-airplane-clock csuccess3  fzL2 "> </span>
                    <h3 class="pwrap_10">
                        <small>Tgl Berangkat</small><br/>
                        <span className="tbold">{dt.date}</span>
                    </h3>
                </div> 
                <div class="list flexR   aiC jcE">
                    <h3 class="pwrap_10">
                        <small>Tgl Kembali</small><br/>
                        <span className="tbold">{dt.dateE}</span>
                    </h3>
                    <span class="mdi mdi-airplane-clock mdi-flip-h  csuccess3  fzL2 "> </span>
                </div>  
            </div>
        </div>
    );
}