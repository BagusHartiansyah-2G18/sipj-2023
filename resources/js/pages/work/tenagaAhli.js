import React, { useEffect, useState }  from "react"; 
import { useDispatch, useSelector } from 'react-redux';
import { useParams } from 'react-router-dom';

import HeaderPage1 from '../../components/dashboard/HeaderPage1';
import FormInformasi from "../../components/subpages/sppd/formInformasi";
import TAformData from "../../components/subpages/tenagaAhli/formData";
import TAformListDoc from "../../components/subpages/tenagaAhli/formListDoc";

import Modal1 from '../../components/Modal/modal1';


import { __user,__sjp,__doc,__checkList  } from'../../states/tenagaAhli/action'; 
 import TAformSPMCheckList from "../../components/subpages/tenagaAhli/formSPMCheklist";
import { setHtml, modalClose } from '../../states/sfHtml/action';

function TenagaAhli(){
    const { _ta, _html} = useSelector((state) => state);
    const { value } = useParams();
    const param = JSON.parse(atob(value)); 
    const dispatch = useDispatch();
    
    const [modalC, _modalC] = useState(''); 
    const [dselect, _dselect] = useState('');
    const [viewInduk, _viewInduk] = useState(0); 

    useEffect(() => {  
        dispatch(__sjp(value));
        dispatch(__user({kdDF:'4d14177b0fe753d53c11ee2ef1ee2af1'}));
        dispatch(__doc({kdDF:'e1731c146ca5a7e30b7585105aaeb224'})); 
        dispatch(__checkList({kdDF:'e76ec11da35af7d8e4d28d5946a9acb5'})); 
    }, [dispatch]);
    
    if(Object.keys(_ta).length <2){
        return <></>;
    } 
    const {basic,data, duser, ddoc, checkList} = _ta;
    const formProses=({row,i})=>{
        _viewInduk(1);
        _dselect({row,i});
    } 
    const checkListForm=()=>{
        _modalC(
            <TAformSPMCheckList 
                mclose={mclose}
                checkList={{checkList,param}}
            ></TAformSPMCheckList>
        );
        dispatch(
            setHtml({
                modal : true,
            })
        );
    }
    function mclose(){
        dispatch(modalClose());
    }
    const menuInduk=()=>{ 
        return(
            <div class="btnGroup">
                <button class={"btn2  "+ (viewInduk ==0 ? 'bsuccess3':'')} onClick={()=>_viewInduk(0)}><b>Data Pengajuan</b></button>
                <button class={"btn2  "+ (viewInduk ==1 ? 'bsuccess3':'')} ><b>Execute SPJ</b></button>
            </div> 
        ); 
    }  
    return(
        <div className="Mcontainer">
            <div className="body pm0">  
                <HeaderPage1
                    page={'Pembuatan SPJ Honor Tenaga'}
                    pageKet={'Data Pencairan'}
                    icon={'mdi-office-building-marker cdark'}
                    menu={menuInduk()}
                ></HeaderPage1> 
                {(
                    _ta.duser!=undefined && _ta.duser.length>0 && viewInduk==0 &&
                    <TAformData
                        duser={duser}
                        param={param}
                        data={data}
                        formProses={formProses}
                        basic={basic}
                    ></TAformData>
                )}
                {(
                    dselect!='' && viewInduk==1 &&
                    <TAformListDoc
                        ddoc={ddoc} 
                        dselect={dselect}
                        checkListForm={checkListForm}
                    ></TAformListDoc>
                )}
                <Modal1
                    children={modalC}
                ></Modal1>      
            </div>
        </div>
        // <>
            

            // <FormInformasi
            //     dt={basic}
            // ></FormInformasi>
            // {(
            //     _ta.duser!=undefined && _ta.duser.length>0 &&
            //     <TAformData
            //         duser={duser}
            //         param={param}
            //         data={data}
            //         formProses={formProses}
            //     ></TAformData>
            // )}
            // {(
            //     dselect!='' &&
            //     <TAformListDoc
            //         ddoc={ddoc} 
            //         dselect={dselect}
            //         checkListForm={checkListForm}
            //     ></TAformListDoc>
            // )}
        //     <Modal1
        //         children ={modalC}
        //     ></Modal1>
        // </>
    )
}
export default TenagaAhli;