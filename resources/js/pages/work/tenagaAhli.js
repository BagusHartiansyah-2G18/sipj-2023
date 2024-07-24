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
    return(
        <>
            <HeaderPage1
                page={'Tenaga Ahli'}
                pageKet={'Pemberkasan administrasi Tenaga Ahli'}
                icon={'mdi-office-building-marker cdark'}
            ></HeaderPage1>

            <FormInformasi
                dt={basic}
            ></FormInformasi>
            {(
                _ta.duser!=undefined && _ta.duser.length>0 &&
                <TAformData
                    duser={duser}
                    param={param}
                    data={data}
                    formProses={formProses}
                ></TAformData>
            )}
            {(
                dselect!='' &&
                <TAformListDoc
                    ddoc={ddoc} 
                    dselect={dselect}
                    checkListForm={checkListForm}
                ></TAformListDoc>
            )}
            <Modal1
                children ={modalC}
            ></Modal1>
        </>
    )
}
export default TenagaAhli;